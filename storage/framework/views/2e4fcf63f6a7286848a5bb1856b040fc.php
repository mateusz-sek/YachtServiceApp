<nav class="w-full fixed top-0 left-0 z-50 
             bg-gray-900/80 backdrop-blur-md border-b border-white/10 
             px-4 md:px-8 h-16 flex items-center justify-between text-white shadow-xl">
    
    <div class="flex items-center space-x-8"> 
        
        <div class="font-extrabold text-xl text-indigo-400 tracking-wider whitespace-nowrap">
            Moja Aplikacja
        </div>

        <div class="hidden md:flex items-center space-x-6"> 
            
            <a href="/" id ='link' class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-300 transform hover:scale-110">
                Klienci
            </a>
            <a href="/ships" id ='link' class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-300 transform hover:scale-110">
                Statki
            </a>
            <a href="/repairs" id ='link' class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-300 transform hover:scale-110">
                Naprawy
            </a>
            <a href="/repairs/history" id ='link' class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-300 transform hover:scale-110">
                Historia
            </a>
            <a href="/dashboard" id ='link' class="font-semibold text-gray-300 hover:text-indigo-400 transition duration-300 transform hover:scale-110">
                Statystyki
            </a>
        </div>
        
    </div>
    
   
</nav>
<script src="<?php echo e(asset('js/active_link.js')); ?>"></script>
<?php /**PATH C:\xampp\htdocs\app\resources\views/partials/navbar.blade.php ENDPATH**/ ?>