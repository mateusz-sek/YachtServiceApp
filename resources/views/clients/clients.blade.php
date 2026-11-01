@extends('layouts.app')

@section('content')


{{-- ALERT POWIADOMIEŃ --}}
@if (session('success'))
    <div id="success-alert" class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-xl 
                                     bg-green-600/20 text-green-400 border border-green-700 
                                     transition-all duration-500 ease-out transform translate-x-0" 
          role="alert">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-lg">
                {{ session('success') }}
            </span>
        </div>
    </div>
@endif

{{-- Główny kontener treści --}}
<div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-white"> 

    {{-- ****************************************************** --}}
    {{-- NAGŁÓWEK DLA TRYBU WYBIERANIA KLIENTA --}}
    {{-- ****************************************************** --}}
    @if (request()->has('clients') && request('clients') === 'all')
        <div class="p-6 bg-indigo-900/40 rounded-xl border border-indigo-700 shadow-2xl">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-center text-indigo-300 tracking-tight">
                Wybierz Klienta do Przypisania Statku 🚢
            </h1>
            <p class="text-center text-gray-300 mt-2">
                Poniżej znajdziesz listę klientów. Kliknij "Wybierz" przy właściwej osobie, by dodać nowy statek.
            </p>
        </div>
    @endif
    
    {{-- Główny kontener panelu wyszukiwania i przycisków --}}
        <div class="mb-8 p-4 bg-white/5 rounded-xl border border-white/10 shadow-lg flex flex-col md:flex-row gap-4 items-end">
        
        {{-- Przycisk 'Dodaj Klienta' widoczny tylko w trybie zarządzania (gdy nie wybieramy klienta) --}}
        @if(!request()->has('clients'))
            <div class="lg:w-auto flex-shrink-0">
                <a href="/clients/create" 
                   class="w-full lg:w-auto px-5 py-1.5 h-[36px] flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Dodaj Klienta
                </a>
            </div>
        @endif
        
        {{-- BLOK FORMULARZA WYSZUKIWANIA (zajmuje całe wolne miejsce) --}}
        <div class="flex-grow"> 
            
            {{-- FORMULARZ WYSZUKIWANIA: Dostosowanie akcji w zależności od trybu --}}
            @php
                $formAction = request()->has('clients') ? '/clients/searchClients?clients=all' : '/clients/searchClients';
            @endphp
            
            <form action="{{ $formAction }}" method="post" class="flex flex-col md:flex-row md:items-end gap-4">
                @csrf
                
                {{-- Pole: Imię i Nazwisko (Autouzupełnianie) --}}
                <div class="flex-1 min-w-[150px] relative">
                    <label for="search_name" class="block text-xs font-medium text-gray-300 mb-1">Imię i Nazwisko</label>
                    <input type="text" id="search_name" autocomplete="off" name="search_name" placeholder="Wprowadź imię lub nazwisko..."
                        class="w-full px-4 py-2 bg-gray-900/50 text-white rounded-lg border border-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner placeholder-gray-500 text-sm">
                    <ul id="autocomplete-list" 
                        class="absolute w-full mt-1 bg-gray-700 rounded-lg shadow-xl border border-gray-600 max-h-60 overflow-y-auto z-50 divide-y divide-gray-600 hidden">
                    </ul>
                </div>

                {{-- Pole: Miasto (Autouzupełnianie) --}}
                <div class="flex-1 min-w-[150px] relative">
                    <label for="search_city" class="block text-xs font-medium text-gray-300 mb-1">Miasto</label>
                    <input type="text" id="search_city" autocomplete="off" name="search_city" placeholder="Wprowadź miasto..."
                        class="w-full px-4 py-2 bg-gray-900/50 text-white rounded-lg border border-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner placeholder-gray-500 text-sm">                    
                    <ul id="autocomplete-listCity" 
                        class="absolute w-full mt-1 bg-gray-700 rounded-lg shadow-xl border border-gray-600 max-h-60 overflow-y-auto z-50 divide-y divide-gray-600 hidden">
                    </ul>
                </div>
                
                {{-- Przycisk Szukaj (wewnątrz form) --}}
                <div class="md:w-auto">
                    <button type="submit" class="w-full md:w-auto px-5 py-1.5 h-[36px] bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 text-sm">
                        Szukaj
                    </button>
                </div>
            </form>
        </div>

    </div>
    
    {{-- Grid z wynikami klientów --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        @foreach($clients as $client)
            {{-- KARTA KLIENTA --}}
            <div class="bg-white/5 rounded-2xl border border-gray-700 hover:border-indigo-500 hover:bg-gray-700/30 transition duration-300 overflow-hidden group shadow-2xl">
                
                {{-- KONTENER ZDJĘCIA --}}
                <div class="w-full h-55 bg-indigo-900 relative overflow-hidden"> 
                    
                    @if($client->image)
                        <img src="{{ asset('image/clients_image/' . $client->image) }}" alt="{{ $client->first_name }} {{ $client->last_name }}" 
                             class="w-full h-full object-cover rounded-t-2xl transition duration-500 ease-in-out group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white text-6xl font-extrabold rounded-t-2xl bg-indigo-700 transition duration-500 ease-in-out group-hover:scale-105">
                            {{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="p-4 sm:p-5"> 
                    
                    {{-- Imię i Nazwisko (text-xl) --}}
                    <h2 class="text-xl font-bold text-white leading-tight mt-1"> 
                        {{ $client->first_name }} {{ $client->last_name }}
                    </h2>
                    
                    <div class="border-t border-gray-700 my-4"></div>

                    {{-- Sekcja Adresu i Telefonu (text-xs) --}}
                    <div class="space-y-2 text-xs"> 
                        {{-- Numer Telefonu --}}
                        <div class="flex items-center text-gray-300 bg-gray-700/50 py-0.5 px-2 rounded-lg">
                            <svg class="w-4 h-4 mr-2 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.128a11.056 11.056 0 005.448 5.448l1.128-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-base font-semibold text-indigo-300">{{ $client->phone_number }}</span>
                        </div>
                        {{-- Ulica i Numer --}}
                        <div class="flex items-start text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $client->street }} {{ $client->number }}</span>
                        </div>
                        {{-- Miasto --}}
                        <div class="pl-7 text-gray-400 italic bg-gray-700/50 py-0.5 px-2 rounded-lg">
                            {{ $client->city }}
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-700 pt-4 flex justify-around items-start">
                        
                        @if(!request()->has('clients'))
                            {{-- TRYB: Zarządzanie (Statki, Naprawy, Edycja, Usuń) --}}
                            <a href="/ships/clients/{{$client->id}}" title="Zarządzaj statkami" class="flex flex-col items-center space-y-1 group/action transition transform hover:scale-105">
                                <div class="p-2.5 rounded-full w-12 h-12 bg-indigo-600 group-hover/action:bg-indigo-700 text-white flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11a9 9 0 0118 0M4 11h20m-12 8a3 3 0 11-6 0 3 3 0 016 0zM12 11V3"></path></svg>
                                </div>
                                <span class="text-xs font-medium text-indigo-300 group-hover/action:text-indigo-400">Statki</span>
                            </a>
                            
                            <a href="/repairs/showByUser/{{$client->id}}" title="Zobacz naprawy" class="flex flex-col items-center space-y-1 group/action transition transform hover:scale-105">
                                <div class="p-2.5 rounded-full w-12 h-12 bg-green-600 group-hover/action:bg-green-700 text-white flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.942 3.35 0 3.35 0 1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.942 1.543 0 3.35 0 3.35-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573 1.066c-.942 1.543 0 3.35 0 3.35-1.756.426-2.924-.426-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.942-3.35 0-3.35 0-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.942-1.543 0-3.35 0-3.35.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573-1.066zM15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="text-xs font-medium text-gray-400 group-hover/action:text-green-400">Naprawy</span>
                            </a>

                            <a href="/clients/edit/{{$client->id}}" title="Edytuj klienta" class="flex flex-col items-center space-y-1 group/action transition transform hover:scale-105">
                                <div class="p-2.5 rounded-full w-12 h-12 bg-yellow-500 group-hover/action:bg-yellow-600 text-gray-900 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </div>
                                <span class="text-xs font-medium text-gray-400 group-hover/action:text-yellow-300">Edycja</span>
                            </a>
                            
                            {{-- PRZYCISK USUŃ --}}
                            <button type="button"
                                    class="open-modal-clients flex flex-col items-center space-y-1 group/action transition transform hover:scale-105"
                                    data-modal="#delete-modal-clients"
                                    data-item-name="{{ $client->first_name }} {{ $client->last_name }}"
                                    data-form-action="/clients/destroy/{{ $client->id }}">
                                <div class="p-2.5 rounded-full w-12 h-12 bg-red-600 group-hover/action:bg-red-700 text-white flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10H8a1 1 0 00-1 1v2h10v-2a1 1 0 00-1-1z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-400 group-hover/action:text-red-400">Usuń</span>
                            </button>
                        @else
                            {{-- TRYB: Wybieranie Klienta (Tylko przycisk WYBIERZ) --}}
                            <a href="/ships/create/{{$client->id}}" title="Wybierz" class="flex flex-col items-center space-y-1 group/action transition transform hover:scale-105 w-full">
                                <div class="p-2.5 rounded-full w-20 h-20 bg-green-600 group-hover/action:bg-green-700 text-white flex items-center justify-center shadow-lg">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> 
                                </div>    
                                <span class="text-lg font-bold text-green-400 group-hover/action:text-green-300">WYBIERZ</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Paginacja --}}
    <div class="mt-8">
        {{ $clients->appends(request()->query())->links('vendor.pagination.pagination') }}
    </div>
</div>

{{-- MODAL USUWANIA --}}
<div id="delete-modal-clients" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div id="delete-modal-content" 
         class="bg-gray-800 rounded-3xl w-full max-w-sm mx-auto p-6 transform transition-all duration-300 -translate-y-12 opacity-0 border border-gray-700 shadow-2xl shadow-red-900/40">
        
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-800/20 mb-4 border border-red-700/50">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-extrabold text-white">
                Ostateczne Potwierdzenie
            </h3>
        </div>

        <p class="text-gray-300 text-center mb-6 leading-relaxed">
            Czy na pewno chcesz **trwale usunąć** <span class="modal-item-name font-extrabold text-red-400 text-lg hover:text-red-300 transition duration-150">
                [NAZWA ELEMENTU]
            </span>?
            <br>
            <span class="text-xs text-gray-400 block mt-2">
                Pamiętaj: tej akcji nie będzie można **cofnąć**.
            </span>
        </p>

        <div class="flex flex-col sm:flex-row-reverse justify-center gap-3 pt-3">
            
            <form class="modal-form w-full sm:w-auto" method="POST" action="">
                @csrf
                @method('GET')
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition duration-200 font-bold text-lg shadow-lg shadow-red-900/50 hover:shadow-xl hover:shadow-red-900/70 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                    Usuń Raz na Zawsze
                </button>
            </form>

            <button class="modal-cancel w-full sm:w-auto px-6 py-3 bg-gray-700 text-gray-200 rounded-xl hover:bg-gray-600 transition duration-200 font-semibold text-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                Anuluj
            </button>
        </div>
    </div>
</div>

{{-- Skrypty JS --}}
<script src="{{ asset('js/autoComplete.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>


@endsection