@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">

    <!-- NAGŁÓWEK -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-100">
            Szczegóły naprawy
        </h1>

    </div>

    <!-- KARTA -->
    <div class="bg-gray-800 rounded-3xl shadow-xl border border-gray-700 overflow-hidden">

        <!-- ZDJĘCIE -->
            <div class="w-full h-80 bg-black">
                <img src="{{ asset('image/ships/' . $repair->ship->image) }}"
                     alt="Zdjęcie naprawy"
                     class="w-full h-full object-cover">
            </div>

        <!-- TREŚĆ -->
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- LEWA KOLUMNA -->
            <div class="space-y-5">

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Opis naprawy
                    </h3>
                    <p class="text-gray-200 mt-2 leading-relaxed">
                        {{ $repair->desc }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Cena
                    </h3>
                    <p class="text-2xl font-extrabold text-indigo-400 mt-1">
                        {{ number_format($repair->price, 2, ',', ' ') }} zł
                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Status płatności
                    </h3>

                    @if($repair->payemnt_done)
                        <span class="inline-flex items-center px-3 py-1 rounded-full
                                     bg-green-600/20 text-green-400 font-bold">
                            ✔ Opłacona
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full
                                     bg-red-600/20 text-red-400 font-bold">
                            ✖ Nieopłacona
                        </span>
                    @endif
                </div>

                @if($repair->pay_date)
                    <div>
                        <h3 class="text-sm uppercase text-gray-400 font-semibold">
                            Data płatności
                        </h3>
                        <p class="text-gray-200">
                            {{ \Carbon\Carbon::parse($repair->pay_date)->format('d.m.Y') }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- PRAWA KOLUMNA -->
            <div class="space-y-5">

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Właściciel
                    </h3>
                    <p class="text-xl font-bold text-gray-100">
                        {{ $repair->ship->ownerShip->first_name }}
                        {{ $repair->ship->ownerShip->last_name }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Statek
                    </h3>
                    <p class="text-lg text-gray-200">
                        {{ $repair->ship->name }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Data utworzenia
                    </h3>
                    <p class="text-gray-200">
                        {{ $repair->created_at->format('d.m.Y') }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
