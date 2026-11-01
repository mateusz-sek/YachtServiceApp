<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;



class HomeController
{
    public function home(Request $request) {
        $clients = Client::paginate(8);
        return view('clients.clients', compact('clients'));
    }



    public function searchClients(Request $request){
            $full_name = explode(' ', $request->search_name);
            $clients = Client::query();
            if(count($full_name) >1){
                $clients->where('last_name', 'like', $full_name[1] .'%')->where('first_name', 'like', $full_name[0] . '%');
            }
            elseif(count($full_name) == 1 && $request->search_name !== null){
                $clients->where('last_name', 'like', $request->search_name .'%')->orWhere('first_name', 'like', $request->search_name . '%');
            }
            if($request->search_city != null){
                $clients->where('city', 'like', $request->search_city . '%');
            }
            $clients = $clients->paginate(6);
            return view('clients.clients', compact('clients'));
        }




    public function searchNameClientsJson(Request $request){
        $q = $request->query('q');
        $full_name = explode(' ', $q);
        if(count($full_name) > 1){
            $clients = Client::where('last_name', 'like', $full_name[1] .'%')->where('first_name', 'like', $full_name[0] . '%')->take(10)->get(['first_name', 'last_name']);
        }
        else{
            $clients = Client::where('last_name', 'like', $full_name[0] .'%')->orWhere('first_name', 'like', $full_name[0] . '%')->take(10)->get(['first_name', 'last_name']);
        }
        return response()->json($clients);
    }


    public function searchNameCityJson(Request $request){
        $q = $request->query('q');
        $city = Client::where('city', 'like', "$q%")->take(10)->distinct()->get('city');
        return response()->json($city);
    }


    public function create() {
        return view('clients.create');
    }


   public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|min:3',
        'last_name'  => 'required|min:3',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120|dimensions:min_width=400,min_height=400',
        'phone_number' => 'nullable', 'numeric', 'digits_between:9,15',
    ],
    [
        'first_name.required' => 'Imię jest wymagany',
        'first_name.min' => 'Imię musi zawierać przynajmniej 3 znaki',
        'last_name.required' => 'Nazwisko jest wymagany',
        'image.image' => 'Plik musi być obrazem.',
        'image.mimes' => 'Dozwolone formaty zdjęcia to: JPEG, PNG, JPG, GIF lub SVG.',
        'image.max'   => 'Zdjęcie nie może być większe niż 5 MB.',
        'image.dimensions' => 'Obraz musi mieć co najmniej 400x400 px.',
        'phone_number.numeric' => 'Numer telefonu musi składać się z samych cyfr',
        'phone_number.digits_between:9,15' => 'Numer telefonu musi składać z 9 do 15 cyfr'
    ]);

    $city = $request->city ?? 'BRAK';
    $street = $request->street ?? 'BRAK';
    $number = $request->number ?? 'BRAK';
    $phone_number = $request->phone_number ?? 'BRAK NR TELEFONU';

    $imageName = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');

        $imageName = time() . '_' . $image->getClientOriginalName();

        // Tutaj zapisujemy plik na serwerze
        $image->move(public_path('image/clients_image'), $imageName);
    }

    Client::create([
        'last_name' => $request->last_name,
        'first_name' => $request->first_name,
        'image' => $imageName,
        'city' => $city,
        'street' => $street,
        'number' => $number,
        'phone_number' => $phone_number
    ]);

    return redirect('/')->with('success', 'Pomyślnie dodano klienta!');
}


    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
        'first_name' => 'required|min:3',
        'last_name'  => 'required|min:3',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120|dimensions:min_width=400,min_height=400',
        'phone_number' => 'nullable', 'numeric', 'digits_between:9,15',
    ],
    [
        'first_name.required' => 'Imię jest wymagany',
        'first_name.min' => 'Imię musi zawierać przynajmniej 3 znaki',
        'last_name.required' => 'Nazwisko jest wymagany',
        'image.image' => 'Plik musi być obrazem.',
        'image.mimes' => 'Dozwolone formaty zdjęcia to: JPEG, PNG, JPG, GIF lub SVG.',
        'image.max'   => 'Zdjęcie nie może być większe niż 5 MB.',
        'image.dimensions' => 'Obraz musi mieć co najmniej 400x400 px.',
        'phone_number.numeric' => 'Numer telefonu musi składać się z samych cyfr',
        'phone_number.digits_between:9,15' => 'Numer telefonu musi składać z 9 do 15 cyfr'
    ]);

    $imageName = null;
    $client = Client::findOrFail($id);
    if ($request->hasFile('image')) {
        $imagePath = public_path('image/clients_image/' . $client->image);
        if (!$client->image == null) {
            unlink($imagePath); 
        } 
        $image = $request->file('image');

        $imageName = time() . '_' . $image->getClientOriginalName();

        // Tutaj zapisujemy plik na serwerze
        $image->move(public_path('image/clients_image'), $imageName);
    }
        if($request->image == null){
            $image = $client->image;
        }
        else{
            $image = $imageName;
        }
            $client->update([
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'image' => $image,
                'city' => $request->city,
                'street' => $request->street,
                'number' => $request->number,
                'phone_number' => $request->phone_number
            ]);
            return  redirect('/')->with('success', 'Zaktualizowano dodano dane klienta!');
    }

    public function destroy(string $id)
    {

    
    $client = Client::findOrFail($id);
    $imagePath = public_path('image/clients_image/' . $client->image);
    if (!$client->image == null) {
        unlink($imagePath); 
    } 
    $client->delete();
    return  redirect('/')->with('success', 'Usunięto klienta');
    }
}
