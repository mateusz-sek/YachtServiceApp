<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Repair;
use App\Models\Ship;


class RepairsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairs = Repair::where('payemnt_done', 0)->paginate(8);
        return view('repairs.repairs', compact('repairs'));   
    }




    public function autocompleteNameRepairs(Request $request)
    {
        $q = trim($request->query('q', ''));

        if ($q === '') {
            return response()->json([]);
        }

        $full_name = explode(' ', $q);

        $clients = Client::query()
            ->join('ships', 'ships.clients_id', '=', 'clients.id')
            ->join('repairs', 'repairs.ship_id', '=', 'ships.id')
            ->where('payemnt_done', 0)
            ->select('clients.first_name', 'clients.last_name') 
            ->distinct();                                      

            
        if (count($full_name) > 1) {
            $clients->where('clients.first_name', 'like', $full_name[0] . '%')
                    ->where('clients.last_name', 'like', $full_name[1] . '%');
        } else {
            $clients->where(function ($query) use ($full_name) {
                $query->where('clients.first_name', 'like', $full_name[0] . '%')
                    ->orWhere('clients.last_name', 'like', $full_name[0] . '%');
            });
        }
        return response()->json(
            $clients->limit(10)->get()
        );
    }

   public function autocompleteNameShipRepairs(Request $request)
    {
    $q = trim($request->q);
    $id = $request->id;

    if ($q === '') {
        return response()->json([]);
    }

    $ships = Ship::query()
        ->join('repairs', 'repairs.ship_id', '=', 'ships.id')
        ->where('ships.name', 'like', $q . '%')
        ->where('payemnt_done', 0);

    if ($id) {
        $ships->where('ships.clients_id', $id);
    }

    $ships = $ships->select('ships.name')
        ->distinct()
        ->limit(10)
        ->get();

    return response()->json($ships);
}


    public function searchRepair(Request $request)
{
    $repairs = Repair::query()
        ->join('ships', 'ships.id', '=', 'repairs.ship_id')
        ->join('clients', 'clients.id', '=', 'ships.clients_id')
        ->where('payemnt_done', 0)
        ->select('repairs.*'); // 👈 bardzo ważne

    // 🔹 Filtr po ID klienta
    if ($request->filled('id')) {
        $repairs->where('clients.id', $request->id);
    }

    // 🔹 Autocomplete klienta (imię + nazwisko)
    if ($request->filled('search_nameRepair')) {
        $fullName = preg_split('/\s+/', trim($request->search_nameRepair));

        if (count($fullName) > 1) {
            $repairs->where('clients.first_name', 'like', $fullName[0] . '%')
                    ->where('clients.last_name', 'like', $fullName[1] . '%');
        } else {
            $repairs->where(function ($query) use ($fullName) {
                $query->where('clients.first_name', 'like', $fullName[0] . '%')
                      ->orWhere('clients.last_name', 'like', $fullName[0] . '%');
            });
        }
    }

    // 🔹 Filtr po nazwie statku
    if ($request->filled('int_name_of_shipRepair')) {
        $repairs->where(
            'ships.name',
            'like',
            $request->int_name_of_shipRepair . '%'
        );
    }

    // 🔹 Paginacja
    $repairs = $repairs->paginate(8)->appends($request->all());

    return view('repairs.repairs', compact('repairs'));
}




    public function showByShip(string $id)
    {   
        $repairs = Repair::where('ship_id', '=', $id)->where('payemnt_done', 0)->paginate(8);
        return view('repairs.repairs', compact('repairs'));   

    }

    public function showByUser($clientId)
    {
        $repairs = Repair::whereHas('ship', function ($q) use ($clientId) {
            $q->where('clients_id', $clientId)
            ->where('payemnt_done', 0);
        })->paginate(8);
        return view('repairs.repairs', compact('repairs'));
}
    
    public function create(string $id)
    {
        $ship = Ship::findOrFail($id);
        return view('repairs.create', compact('ship'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'date_of_payment' => 'required',
        ],
    [
            'price.required' => 'Cena jest wymagana',
            'date_of_payment.required' => 'Data spłaty jest wymagana',
        ]);
        Repair::create([
            'ship_id' => $id,
            'price' => $request->price,
            'date_of_payment' => $request->date_of_payment,
            'payemnt_done' => 0,
            'desc' => $request->desc
        ]);

        return redirect('/repairs')->with('success', 'Pomyślnie dodano zamówienie!');
    }



    public function changeStatusPayment(string $id){
        $repair = Repair::findOrFail($id);
        $status = 0;
        $date = null;
        if($repair->pay_date == null){
            $date = date('Y-m-d');
        }
        if($repair->payemnt_done == 0){
            $status = 1;
        }
        $repair->update([
            'payemnt_done' => $status,
            'pay_date' => $date
        ]);
        return redirect('/repairs')->with('success', 'Pomyślnie zmieniono status płatności!');
    }

    /**
     * Display the specified resource.
     */



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $repair = Repair::findOrFail($id);
        return view('repairs.edit', compact('repair'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'date_of_payment' => 'required',
        ],
    [
            'price.required' => 'Cena jest wymagana',
            'date_of_payment.required' => 'Data spłaty jest wymagana',
        ]);
        $repair = Repair::findOrFail($id);
        $repair->update([
            'price' => $request->price,
            'date_of_payment' => $request->date_of_payment,
            'desc' => $request->desc
        ]);

        return redirect('/repairs')->with('success', 'Pomyślnie edytowano zamówienie!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $repair = Repair::findOrFail($id);
    $repair->delete();
    return  redirect('/repairs')->with('success', 'Usunięto zamówinie');
    }


    public function show(string $id)
    {
        $repair = Repair::findOrFail($id);
        return view('repairs.show', compact('repair'));
    }





}