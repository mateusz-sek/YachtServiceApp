@if ($paginator->hasPages())
    <nav class="flex justify-center">
        <ul class="inline-flex items-center gap-1 px-4 py-3 bg-gray-800/80 
                   rounded-2xl border border-gray-700 shadow-xl">

            {{-- Poprzednia --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-4 py-2 rounded-xl bg-gray-700/40 text-gray-500 cursor-not-allowed">
                        ‹
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-4 py-2 rounded-xl bg-gray-700 text-gray-300
                              hover:bg-indigo-600 hover:text-white
                              transition shadow-md">
                        ‹
                    </a>
                </li>
            @endif

            {{-- Numery stron --}}
            @foreach ($elements as $element)

                {{-- "..." --}}
                @if (is_string($element))
                    <li>
                        <span class="px-4 py-2 text-gray-500">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Linki --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span
                                    class="px-4 py-2 rounded-xl
                                           bg-gradient-to-br from-indigo-500 to-indigo-700
                                           text-white font-bold shadow-lg">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-gray-700 text-gray-300
                                          hover:bg-indigo-600 hover:text-white
                                          transition shadow-md">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif

            @endforeach

            {{-- Następna --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-4 py-2 rounded-xl bg-gray-700 text-gray-300
                              hover:bg-indigo-600 hover:text-white
                              transition shadow-md">
                        ›
                    </a>
                </li>
            @else
                <li>
                    <span class="px-4 py-2 rounded-xl bg-gray-700/40 text-gray-500 cursor-not-allowed">
                        ›
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
