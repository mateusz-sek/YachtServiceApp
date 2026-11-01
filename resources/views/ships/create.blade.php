@extends('layouts.app')

@section('content')

{{-- Główny kontener: Centrowanie i ograniczenie szerokości na ciemnym tle --}}
<div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 min-h-screen">
    
    {{-- Karta formularza: Ciemne tło, zaokrąglenia, cień --}}
    <div class="w-full max-w-xl bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700 space-y-6">
        <h3 class="text-3xl font-extrabold text-white text-center">Przypisz statek </h3>
        <form method="post" action="/ships/store" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- ZDJĘCIE (INPUT FILE) --}}
            <div class="space-y-1">
                <label for="image" class="block text-sm font-medium text-gray-300">Zdjęcie Statku</label>
                
                <input class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                        @error('image') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror
                        
                        {{-- ZMIANY TUTAJ: Dodano transformację i przejście dla przycisku file: --}}
                        file:mr-4 
                        file:py-2 
                        file:px-4 
                        file:rounded-lg 
                        file:border-0 
                        file:text-sm 
                        file:font-semibold 
                        file:bg-indigo-600 
                        file:text-white 
                        
                        file:transform 
                        file:transition 
                        file:duration-300 
                        hover:file:scale-105 
                        
                        hover:file:bg-indigo-700 
                        cursor-pointer" 
                        name="image" 
                        type="file" 
                        id="image">
                        
                @error('image') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>
            {{-- NAZWISKO --}}
            <div class="space-y-1">
                <label for="name" class="block text-sm font-medium text-gray-300">Nazwa</label>
                <input type="text" name="name" id="name" placeholder="Nazwa"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                        @error('name') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('name') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- DODANE UKRYTE POLE --}}
            <input type="hidden" name="client_id" id="client_id" value="{{ $id }}">

            {{-- PRZYCISK SUBMIT --}}
            
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg 
                                         transition duration-300 ease-in-out 
                                         transform hover:scale-105 
                                         focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                Przypisz statek
            </button>
            

        </form>

    </div>
</div>

@endsection