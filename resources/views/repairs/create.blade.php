@extends('layouts.app')

@section('content')

    {{-- Główny kontener - ciemne tło --}}
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 text-white"> 

        {{-- Nagłówek informacyjny --}}
        <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-2xl mb-8">
            <h1 class="text-3xl font-extrabold text-white mb-2">
                Dodaj Nowe Zlecenie Naprawy 🔧
            </h1>
            <p class="text-gray-400">
            </p>
        </div>

        {{-- Karta formularza --}}
        <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-2xl">
            
            <form method="post" action="/repairs/store/{{$ship->id}}">
                {{-- Użyj dyrektywy Blade dla CSRF (łatwiejsze do odczytania niż csrf_field()) --}}
                @csrf 
                
                {{-- Pole: Opis --}}
                <div class="mb-5">
                    <label for="desc" class="block text-sm font-medium text-gray-300 mb-2">Opis Naprawy</label>
                    <textarea class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg border 
                                     @error('desc') border-red-500 @else border-gray-700 @enderror
                                     focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner" 
                              style="height: 150px" name="desc" id="desc" placeholder="Szczegółowy opis wykonanej pracy...">{{ old('desc') }}</textarea>
                    
                    @error('desc') 
                        <div class="text-sm text-red-400 mt-1">{{ $message }}</div> 
                    @enderror
                </div>
                
                {{-- Pole: Cena --}}
                <div class="mb-5">
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Cena (PLN)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                           class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg border 
                                  @error('price') border-red-500 @else border-gray-700 @enderror
                                  focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner"
                           placeholder="Np. 1500.00">
                           
                    @error('price') 
                        <div class="text-sm text-red-400 mt-1">{{ $message }}</div> 
                    @enderror
                </div>
                
                {{-- Pole: Data płatności --}}
                <div class="mb-8">
                    <label for="date_of_payment" class="block text-sm font-medium text-gray-300 mb-2">Termin Płatności</label>
                    <input type="date" name="date_of_payment" id="date_of_payment" value="{{ old('date_of_payment') }}"
                           class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg border 
                                  @error('date_of_payment') border-red-500 @else border-gray-700 @enderror
                                  focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner">
                           
                    @error('date_of_payment') 
                        <div class="text-sm text-red-400 mt-1">{{ $message }}</div> 
                    @enderror
                </div>
                
                {{-- Przycisk Submit --}}
                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    Dodaj Zamówienie
                </button>
            </form>
        </div>

    </div>

@endsection