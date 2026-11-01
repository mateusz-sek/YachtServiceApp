@extends('layouts.app')

@section('content')

{{-- Główny kontener: Centrowanie i ograniczenie szerokości na ciemnym tle --}}
<div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 min-h-screen">
    
    {{-- Karta formularza: Ciemne tło, zaokrąglenia, cień --}}
    <div class="w-full max-w-xl bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700 space-y-6">
        <h3 class="text-3xl font-extrabold text-white text-center">Dodaj Klienta</h3>
        <form method="post" action="/clients/store" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- ZDJĘCIE (INPUT FILE) --}}
            <div class="space-y-1">
                <label for="image" class="block text-sm font-medium text-gray-300">Zdjęcie Klienta</label>
                
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

            {{-- IMIĘ --}}
            <div class="space-y-1">
                <label for="first_name" class="block text-sm font-medium text-gray-300">Imię</label>
                <input type="text" name="first_name" id="first_name" placeholder="Imię klienta"
                       value="{{ old('first_name') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                       @error('first_name') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('first_name') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- NAZWISKO --}}
            <div class="space-y-1">
                <label for="last_name" class="block text-sm font-medium text-gray-300">Nazwisko</label>
                <input type="text" name="last_name" id="last_name" placeholder="Nazwisko klienta"
                       value="{{ old('last_name') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                       @error('last_name') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('last_name') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- MIASTO --}}
            <div class="space-y-1">
                <label for="city" class="block text-sm font-medium text-gray-300">Miasto</label>
                <input type="text" name="city" id="city" placeholder="Np. Gdańsk"
                       value="{{ old('city') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                       @error('city') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('city') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- ULICA --}}
            <div class="space-y-1">
                <label for="street" class="block text-sm font-medium text-gray-300">Ulica</label>
                <input type="text" name="street" id="street" placeholder="Np. Długa"
                       value="{{ old('street') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                       @error('street') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('street') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- NR DOMU/MIESZKANIA --}}
            <div class="space-y-1">
                <label for="number" class="block text-sm font-medium text-gray-300">Nr domu/mieszkania</label>
                <input type="text" name="number" id="number" placeholder="Np. 12A/3"
                       value="{{ old('number') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                       @error('number') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('number') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- NR TELEFONU --}}
            <div class="space-y-1">
                <label for="phone_number" class="block text-sm font-medium text-gray-300">Nr telefonu</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="Np. 555 123 456"
                       value="{{ old('phone_number') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                       @error('phone_number') border-red-500 focus:border-red-500 @else border-gray-600 focus:border-indigo-500 @enderror">
                @error('phone_number') 
                    <div class="text-red-400 text-xs mt-1">{{ $message }}</div> 
                @enderror
            </div>

            {{-- PRZYCISK SUBMIT --}}
            
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg 
                                         transition duration-300 ease-in-out 
                                         transform hover:scale-105 
                                         focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                Dodaj Klienta
            </button>
            

        </form>

    </div>
</div>

@endsection