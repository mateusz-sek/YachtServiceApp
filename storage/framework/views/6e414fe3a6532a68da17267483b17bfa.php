

<?php $__env->startSection('content'); ?>
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
                <img src="<?php echo e(asset('image/ships/' . $repair->ship->image)); ?>"
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
                        <?php echo e($repair->desc); ?>

                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Cena
                    </h3>
                    <p class="text-2xl font-extrabold text-indigo-400 mt-1">
                        <?php echo e(number_format($repair->price, 2, ',', ' ')); ?> zł
                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Status płatności
                    </h3>

                    <?php if($repair->payemnt_done): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full
                                     bg-green-600/20 text-green-400 font-bold">
                            ✔ Opłacona
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full
                                     bg-red-600/20 text-red-400 font-bold">
                            ✖ Nieopłacona
                        </span>
                    <?php endif; ?>
                </div>

                <?php if($repair->pay_date): ?>
                    <div>
                        <h3 class="text-sm uppercase text-gray-400 font-semibold">
                            Data płatności
                        </h3>
                        <p class="text-gray-200">
                            <?php echo e(\Carbon\Carbon::parse($repair->pay_date)->format('d.m.Y')); ?>

                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- PRAWA KOLUMNA -->
            <div class="space-y-5">

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Właściciel
                    </h3>
                    <p class="text-xl font-bold text-gray-100">
                        <?php echo e($repair->ship->ownerShip->first_name); ?>

                        <?php echo e($repair->ship->ownerShip->last_name); ?>

                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Statek
                    </h3>
                    <p class="text-lg text-gray-200">
                        <?php echo e($repair->ship->name); ?>

                    </p>
                </div>

                <div>
                    <h3 class="text-sm uppercase text-gray-400 font-semibold">
                        Data utworzenia
                    </h3>
                    <p class="text-gray-200">
                        <?php echo e($repair->created_at->format('d.m.Y')); ?>

                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\app\resources\views/repairs/show.blade.php ENDPATH**/ ?>