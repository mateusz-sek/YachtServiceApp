<nav class="w-full fixed top-0 left-0 z-50 
             bg-gray-900/80 backdrop-blur-md border-b border-white/10 
             px-4 md:px-8 h-16 flex items-center justify-between text-white shadow-xl">
    
    <div class="flex items-center space-x-8"> 
        
        <div class="font-extrabold text-xl text-indigo-400 tracking-wider whitespace-nowrap">
            Moja Aplikacja
        </div>

        <div class="hidden md:flex items-center space-x-6"> 
            
            <a href="/" class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-200">
                Klienci
            </a>
            <a href="#" class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-200">
                Statki
            </a>
            <a href="#" class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-200">
                Naprawy
            </a>
        </div>
        
    </div>
    
    <div class="flex items-center space-x-4">
        
        <button id="menu-toggle" class="md:hidden text-white hover:text-indigo-400 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <button class="text-gray-400 hover:text-indigo-400 relative hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-gray-900 bg-red-500"></span>
        </button>

        <a href="#" class="rounded-full overflow-hidden w-9 h-9 border-2 border-indigo-400 hover:border-indigo-200 transition">
            <img class="w-full h-full object-cover" src="placeholder-avatar.jpg" alt="Avatar">
        </a>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\app\resources\views/layouts/components/navbar.blade.php ENDPATH**/ ?>