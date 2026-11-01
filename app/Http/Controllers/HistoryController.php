<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repair;
use App\Models\Client;
use App\Models\Ship;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HistoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairs = Repair::where('payemnt_done', 1)->paginate(8);
        return view('repairs.history', compact('repairs'));   
    }



    public function autocompleteNameRepairsHistory(Request $request)
    {
        $q = trim($request->query('q', ''));

        if ($q === '') {
            return response()->json([]);
        }

        $full_name = explode(' ', $q);

        $clients = Client::query()
            ->join('ships', 'ships.clients_id', '=', 'clients.id')
            ->join('repairs', 'repairs.ship_id', '=', 'ships.id')
            ->where('payemnt_done', 1)
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

    public function autocompleteNameShipRepairsHistory(Request $request)
    {
    $q = trim($request->q);
    $id = $request->id;

    if ($q === '') {
        return response()->json([]);
    }

    $ships = Ship::query()
        ->join('repairs', 'repairs.ship_id', '=', 'ships.id')
        ->where('ships.name', 'like', $q . '%')
        ->where('payemnt_done', 1);

    if ($id) {
        $ships->where('ships.clients_id', $id);
    }

    $ships = $ships->select('ships.name')
        ->distinct()
        ->limit(10)
        ->get();

    return response()->json($ships);
}


public function searchRepairHistory(Request $request)
{
    $repairs = Repair::query()
        ->join('ships', 'ships.id', '=', 'repairs.ship_id')
        ->join('clients', 'clients.id', '=', 'ships.clients_id')
        ->where('payemnt_done', 1)
        ->select('repairs.*'); // 👈 bardzo ważne


    // 🔹 Autocomplete klienta (imię + nazwisko)
    if ($request->filled('search_nameRepairHistory')) {
        $fullName = preg_split('/\s+/', trim($request->search_nameRepairHistory));

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
    if ($request->filled('int_name_of_shipRepairHistory')) {
        $repairs->where(
            'ships.name',
            'like',
            $request->int_name_of_shipRepairHistory . '%'
        );
    }

    // 🔹 Paginacja
    $repairs = $repairs->paginate(8)->appends($request->all());

    return view('repairs.history', compact('repairs'));
}




public function dashboard()
    {
        /* PODSTAWOWE STATYSTYKI */
        $stats = [
            'clients' => Client::count(),
            'ships'   => Ship::count(),
            'repairs' => Repair::count(),
            'paid'    => Repair::where('payemnt_done', 1)->count(),
            'unpaid'  => Repair::where('payemnt_done', 0)->count(),
            'income'  => Repair::where('payemnt_done', 1)->sum('price'),
        ];

        /* OSTATNIE NAPRAWY */
        $latestRepairs = Repair::with('ship.ownerShip')
            ->latest()
            ->take(5)
            ->get();

        $currentYear = Carbon::now()->year;
        $previousYear = $currentYear - 1;

        /* PRZYCHODY – BIEŻĄCY ROK */
        $incomeCurrentYear = Repair::select(
                DB::raw('MONTH(pay_date) as month'),
                DB::raw('SUM(price) as total')
            )
            ->whereYear('pay_date', $currentYear)
            ->whereNotNull('pay_date')
            ->groupBy(DB::raw('MONTH(pay_date)'))
            ->orderBy(DB::raw('MONTH(pay_date)'))
            ->get();

        /* PRZYCHODY – POPRZEDNI ROK */
        $incomePreviousYear = Repair::select(
                DB::raw('MONTH(pay_date) as month'),
                DB::raw('SUM(price) as total')
            )
            ->whereYear('pay_date', $previousYear)
            ->whereNotNull('pay_date')
            ->groupBy(DB::raw('MONTH(pay_date)'))
            ->orderBy(DB::raw('MONTH(pay_date)'))
            ->get();

        return view('repairs.dashboard', compact(
            'stats',
            'latestRepairs',
            'incomeCurrentYear',
            'incomePreviousYear',
            'currentYear',
            'previousYear'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
