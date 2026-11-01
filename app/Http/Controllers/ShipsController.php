<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;

class ShipsController
{
    public function index(Request $request)
    {
        $ships = Ship::paginate(8);
        return view('ships.ships', compact('ships'));
    }




    //WYPELNIA NAZWE STATKU
    public function autocompleteNameShip(Request $request)
    {
        $q = $request->q;
        $id = $request->id;
        $query = Ship::query();
        if ($id) {
            $query->where('clients_id', $id);
        }
        if ($q) {
            $query->where('name', 'like', $q . '%');
        }
    return response()->json($query->limit(10)->get());
    }

    //WYPELNIA KLIENTA
    public function autocompleteClientsShip(Request $request){
        $q = $request->query('q');
        $clients = Client::query();
        $clients->join('ships', function (JoinClause $join) {
            $join->on('clients.id', '=', 'ships.clients_id');
        });
        $full_name = explode(' ', $q);
        if(count($full_name) > 1){
            $clients->where('last_name', 'like', $full_name[1] .'%')->where('first_name', 'like', $full_name[0] . '%')->take(10)->get(['first_name', 'last_name']);
        }
        else{
            $clients->where('last_name', 'like', $full_name[0] .'%')->orWhere('first_name', 'like', $full_name[0] . '%')->take(10)->get(['first_name', 'last_name']);
        }
        return response()->json($clients->limit(10)->get());
    }


    //WYSZUKIWANIE STATKU
    public function searchShip(Request $request)
    {
        $ships = Ship::query();
        // Filtr po ID klienta
        if ($request->id != null) {
            $ships->where('clients_id', $request->id);
        }
        // Autocomplete klienta po imieniu i nazwisku
        if ($request->search_nameShip != null) {
            $full_name = explode(' ', trim($request->search_nameShip));
            if (count($full_name) > 1) {
                $clients = Client::where('first_name', 'like', $full_name[0] . '%')->where('last_name', 'like', $full_name[1] . '%')->pluck('id');
            }
            else {
                $clients = Client::where(function($query) use ($full_name) {
                    $query->where('first_name', 'like', $full_name[0] . '%')->orWhere('last_name', 'like', $full_name[0] . '%');
                })->pluck('id');
            }
            $ships->whereIn('clients_id', $clients);
        }
        // Filtr po nazwie statku
        if ($request->int_name_of_ship) {
            $ships->where('name', 'like', '%' . $request->int_name_of_ship . '%');
        }
        // Paginacja z zachowaniem wszystkich parametrów wyszukiwania
        $ships = $ships->paginate(8)->appends($request->all());
        return view('ships.ships', compact('ships'));
    }


    public function create(string $id)
    {
        return view('ships.create', compact('id'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120|dimensions:min_width=400,min_height=400',
            'name' => 'required|min:3',
        ],
        [
            'client_id.required' => 'Musi zostać przypisany klient do statku',
            'image.image' => 'Plik musi być obrazem.',
            'image.mimes' => 'Dozwolone formaty zdjęcia to: JPEG, PNG, JPG, GIF lub SVG.',
            'image.max'   => 'Zdjęcie nie może być większe niż 5 MB.',
            'image.dimensions' => 'Obraz musi mieć co najmniej 400x400 px.',
            'name.required' => 'Nazwa jest wymagana',
            'name.min' => 'Nazwa musi zawierać przynajmniej 3 znaki',
        ]);
        $imageName = null;

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/ships'), $imageName);
            Ship::create([
                'clients_id' => $request->client_id,
                'image' => $imageName,
                'name' => $request->name,
]);
            return redirect('/ships/clients/' . $request->client_id)->with('success', 'Pomyślnie dodano statek do klienta!');
    }


    //STATKI UZYTKOWNIKA
    public function show(string $id, Request $request)
    {   
        $ships = Ship::where('clients_id', '=', $id)->paginate(8);
        return view('ships.ships', compact('ships'));
    }


    public function edit(string $id)
    {
        $ship = Ship::findOrFail($id);
        return view('ships.edit', compact('ship'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'client_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120|dimensions:min_width=400,min_height=400',
            'name' => 'required|min:3',
        ],
        [
            'client_id.required' => 'Musi zostać przypisany klient do statku',
            'image.image' => 'Plik musi być obrazem.',
            'image.mimes' => 'Dozwolone formaty zdjęcia to: JPEG, PNG, JPG, GIF lub SVG.',
            'image.max'   => 'Zdjęcie nie może być większe niż 5 MB.',
            'image.dimensions' => 'Obraz musi mieć co najmniej 400x400 px.',
            'name.required' => 'Nazwa jest wymagana',
            'name.min' => 'Nazwa musi zawierać przynajmniej 3 znaki',
        ]);
        $imageName = null;
        $ship = Ship::findOrFail($id);
        if ($request->hasFile('image')) {
            $imagePath = public_path('image/ships/' . $ship->image);
            if (!$ship->image == null) {
                unlink($imagePath); 
            } 
            $image = $request->file('image');

            $imageName = time() . '_' . $image->getClientOriginalName();

            // Tutaj zapisujemy plik na serwerze
            $image->move(public_path('image/ships'), $imageName);
        }
            if($request->image == null){
                $image = $ship->image;
            }
            else{
                $image = $imageName;
            }
            $ship->update([
                'clients_id' => $request->client_id,
                'image' => $image,
                'name' => $request->name,
            ]);
            return  redirect('/ships')->with('success', 'Zaktualizowano dane statku!');
    }

    public function destroy(string $id)
    {
        $ship = Ship::findOrFail($id);
        $ship->delete();
        return  redirect('/ships')->with('success', 'Usunięto statek');
    }
}

