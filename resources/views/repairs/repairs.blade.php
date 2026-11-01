@extends('layouts.app')

@section('content')
    
    {{-- ALERT POWIADOMIEŃ (BEZ ZMIAN) --}}
    @if (session('success'))
        <div id="success-alert" class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-2xl backdrop-blur-sm 
                                             bg-green-600/30 text-green-300 border border-green-700 
                                             transition-all duration-500 ease-out transform translate-x-0" 
             role="alert">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium text-lg">
                    {{ session('success') }}
                </span>
            </div>
        </div>
    @endif
    
    {{-- Główny Kontener --}}
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10 text-white">

        {{-- 🔍 KONTENER WYSZUKIWANIA, FILTROWANIA i PRZYCISK DODAJ ZLECENIE (BEZ ZMIAN) --}}
        <div class="mb-8 p-4 bg-white/5 rounded-xl border border-white/10 shadow-lg flex flex-col md:flex-row gap-4 items-end">
            
                
                {{-- ➕ PRZYCISK DODAJ ZLECENIE --}}
                <div class="lg:w-auto flex-shrink-0">
                    @php
                        $idSegment = request()->segment(3);
                        $shipId = request('id', is_numeric($idSegment) ? $idSegment : null);
                    @endphp

                    @if($shipId)
                        <a href="/repairs/create/{{ $shipId }}" 
                            class="w-full lg:w-auto px-5 py-1.5 h-[36px] flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                            <i class="fas fa-plus text-lg mr-2"></i>
                            Dodaj Zlecenie
                        </a>
                    @else
                         <a href="/ships?action=selectForRepair" 
                            class="w-full lg:w-auto px-5 py-1.5 h-[36px] flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                            <i class="fas fa-plus text-lg mr-2"></i>
                            Dodaj Zlecenie
                        </a>
                    @endif
                </div>
                
                {{-- FORMULARZ WYSZUKIWANIA (BEZ ZMIAN) --}}
                <form class="flex-grow flex flex-col md:flex-row md:items-end gap-4" action="/repairs/searchRepair" method="GET">
                    @csrf
                    @if(!request()->id)
                    {{-- Pole: Imię i Nazwisko --}}
                    <div class="flex-1 min-w-[150px] relative">
                        <label for="search_nameRepair" class="block text-xs font-medium text-gray-300 mb-1">Imię i Nazwisko</label>
                        <input type="text" id="search_nameRepair" autocomplete="off" name="search_nameRepair" placeholder="Wprowadź imię lub nazwisko..."
                                class="w-full px-4 py-2 bg-gray-900/50 text-white rounded-lg border border-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner placeholder-gray-500 text-sm">
                        <ul id="autocomplete-listRepair" 
                            class="absolute w-full mt-1 bg-gray-700 rounded-lg shadow-xl border border-gray-600 max-h-60 overflow-y-auto z-50 divide-y divide-gray-600 hidden">
                        </ul>
                    </div>
                    @endif
                    {{-- Pole: Nazwa łodzi --}}
                    <div class="flex-1 min-w-[150px] relative">
                        <label for="int_name_of_shipRepair" class="block text-sm font-medium text-gray-300 mb-1">Nazwa statku</label>
                        <input type="text" id="int_name_of_shipRepair" name="int_name_of_shipRepair"
                            value="{{ request('int_name_of_shipRepair') }}"
                            data-id="{{ request('id', request()->segment(3)) }}"
                            autocomplete="off"
                            class="w-full px-4 py-2 bg-gray-900/50 text-white rounded-lg border border-gray-700 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner placeholder-gray-500 text-sm"
                            placeholder="Nazwa statku">

                        <ul id="autocompleteshipsRepair-list" 
                            class="absolute w-full mt-1 bg-gray-700 rounded-lg shadow-xl border border-gray-600 max-h-60 overflow-y-auto z-50 divide-y divide-gray-600 hidden">
                        </ul>
                        <input type="hidden" name="id" value="{{ request('id', request()->segment(3)) }}">
                    </div>
                    
                    {{-- Przycisk Szukaj --}}
                    <div class="md:w-auto flex-shrink-0">
                        <button type="submit" class="w-full md:w-auto px-5 py-1.5 h-[36px] bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 text-sm">
                            <i class="fas fa-search mr-1"></i> Szukaj
                        </button>
                    </div>
                </form>

        </div>
        
        <hr class="border-gray-700">

       
        
        <div class="overflow-x-auto shadow-2xl rounded-xl border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Właściciel</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Statek</th>
                        <th scope="col" class="px-6 py-3 text-right text-sm font-medium text-gray-300 uppercase tracking-wider">Cena</th>
                        <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-300 uppercase tracking-wider">Termin zapłaty</th>
                        <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-300 uppercase tracking-wider">Stan spłaty</th>
                        <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-300 uppercase tracking-wider">Pozostało dni</th>
                        <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-300 uppercase tracking-wider">Akcje</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
    @foreach($repairs as $repair)
        @php
            $remainingDays = $repair->getDiffDataAttribute; 
            $isDue = ($remainingDays <= 7 && $repair->payemnt_done == 0);
            $isOverdue = ($remainingDays < 0 && $repair->payemnt_done == 0);

            $rowClass = 'hover:bg-gray-700/50 transition duration-150';
            if ($isOverdue) {
                $rowClass = 'bg-red-900/30 hover:bg-red-900/50 transition duration-150 border-l-4 border-red-600';
            } elseif ($isDue) {
                $rowClass = 'bg-yellow-900/30 hover:bg-yellow-900/50 transition duration-150 border-l-4 border-yellow-500';
            }

            $remainingDaysClass = $isOverdue ? 'font-bold text-red-500' : ($isDue ? 'font-bold text-yellow-400' : 'text-gray-400');
        @endphp

        <tr class="{{ $rowClass }}">
            <td class="px-4 py-2 text-sm text-gray-300 max-w-[150px] truncate">
                {{$repair->ship->ownerShip->first_name}} {{$repair->ship->ownerShip->last_name}}
            </td>
            <td class="px-4 py-2 text-sm font-medium text-indigo-400 truncate">
                {{$repair->ship->name}}
            </td>   
            <td class="px-4 py-2 whitespace-nowrap text-sm font-bold text-yellow-400 text-right">
                {{ number_format($repair->price, 2, ',', ' ') }} PLN
            </td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-300 text-center">
                {{$repair->date_of_payment}}
            </td>
            <td class="px-4 py-2 whitespace-nowrap text-center text-sm">
                <span class="px-2 py-1 rounded-full {{ $repair->payemnt_done == 0 ? 'bg-red-500/20 text-red-300' : 'bg-green-500/20 text-green-300' }}">
                    {{ $repair->payemnt_done == 0 ? 'Niezapłacone' : 'Zapłacone' }}
                </span>
            </td>
            <td class="px-4 py-2 whitespace-nowrap text-center text-sm {{ $remainingDaysClass }}">
                @if($remainingDays < 0 && $repair->payemnt_done == 0)
                    <span title="Termin minął {{ abs($remainingDays) }} dni temu">
                        <i class="fas fa-exclamation-triangle mr-1 text-sm"></i> PO TERMINIE
                    </span>
                @elseif($remainingDays == 0 && $repair->payemnt_done == 0)
                    DZIŚ
                @else
                    {{ $remainingDays }}
                @endif
            </td>

            {{-- AKCJE --}}
            <td class="px-4 py-2 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <!-- Zobacz szczegóły -->
                    <a href="/repairs/show/{{ $repair->id }}"
                       class="p-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition duration-150 shadow-md text-[12px]"
                       title="Zobacz szczegóły">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Zmień status opłaty -->
                    <button
                        type="button"
                        class="open-modal-repairs p-2 rounded-lg transition duration-150 shadow-md text-white text-[12px]
                            {{ $repair->payemnt_done == 0 ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-600 hover:bg-gray-700' }}"
                        data-id="{{ $repair->id }}"
                        data-modal="#status-modal-repairs"
                        data-status="{{ $repair->payemnt_done }}"
                        data-ship="{{ $repair->ship->name }}"
                        title="Zmień status płatności"
                    >
                        @if($repair->payemnt_done == 0)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-times"></i>
                        @endif
                    </button>

                    <!-- Edytuj -->
                    <a href="/repairs/edit/{{ $repair->id }}"
                       class="p-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition duration-150 shadow-md text-[12px]"
                       title="Edytuj zlecenie">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- Usuń -->
                    <button type="button"
                            class="open-modal-destroy-repairs p-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition duration-150 shadow-md text-[12px]"
                            data-modal="#delete-modal-repairs"
                            data-item-name="naprawę dla statku: {{$repair->ship->name}} (ID: {{$repair->id}})"
                            data-form-action="/repairs/destroy/{{$repair->id}}"
                            title="Usuń zlecenie">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>

        {{-- Paginacja (BEZ ZMIAN) --}}
        <div class="mt-8">
            {{ $repairs->links('vendor.pagination.pagination') }}
        </div>

    </div>


    <div id="status-modal-repairs"
     class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4">

    <!-- OKNO MODALA -->
    <div
        class="modal-dialog-content bg-gray-800 rounded-3xl w-full max-w-md mx-auto p-6
               transform transition-all duration-300 -translate-y-12 opacity-0
               border border-gray-700 shadow-2xl"
    >

        <!-- IKONA -->
        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-full bg-indigo-800/30 flex items-center justify-center border border-indigo-700/40">
                <i class="fas fa-money-bill-wave text-indigo-400 text-2xl"></i>
            </div>
        </div>

        <!-- TYTUŁ -->
        <h3 class="text-2xl font-extrabold text-white text-center mb-4">
            Zmiana statusu płatności
        </h3>

        <!-- TREŚĆ -->
        <p class="text-gray-300 text-center mb-6 leading-relaxed">
            Czy na pewno chcesz zmienić status płatności dla statku:
            <br>
            <span class="modal-ship-name font-extrabold text-indigo-400 text-lg"></span>?
        </p>

        <!-- PRZYCISKI -->
        <div class="flex flex-col sm:flex-row-reverse gap-3">
            <a href="#"
               class="modal-confirm-status w-full sm:w-auto px-6 py-3 bg-green-600 text-white rounded-xl
                      hover:bg-green-700 transition font-bold text-lg shadow-lg text-center">
                Potwierdź
            </a>

            <button type="button"
                    class="modal-cancel w-full sm:w-auto px-6 py-3 bg-gray-700 text-gray-200 rounded-xl
                           hover:bg-gray-600 transition font-semibold text-lg shadow-md">
                Anuluj
            </button>
        </div>

    </div>
</div>


{{-- MODAL USUWANIA --}}
<div id="delete-modal-repairs" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
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

<script src="{{ asset('js/autoComplete.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>

@endsection