

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-100">
                Dashboard
            </h1>
            <p class="text-gray-400 mt-1">
                Podsumowanie działalności serwisu
            </p>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-14">

        <!-- KLIENCI -->
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-3xl p-6 shadow-lg">
            <div class="absolute right-4 top-4 opacity-20 text-6xl">
                <i class="fas fa-users"></i>
            </div>
            <p class="text-sm text-indigo-200">Klienci</p>
            <p class="text-4xl font-extrabold text-white">
                <?php echo e($stats['clients']); ?>

            </p>
        </div>

        <!-- STATKI -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-6 shadow-lg">
            <div class="absolute right-4 top-4 opacity-20 text-6xl">
                <i class="fas fa-ship"></i>
            </div>
            <p class="text-sm text-blue-200">Statki</p>
            <p class="text-4xl font-extrabold text-white">
                <?php echo e($stats['ships']); ?>

            </p>
        </div>

        <!-- NAPRAWY -->
        <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 to-purple-800 rounded-3xl p-6 shadow-lg">
            <div class="absolute right-4 top-4 opacity-20 text-6xl">
                <i class="fas fa-tools"></i>
            </div>
            <p class="text-sm text-purple-200">Naprawy</p>
            <p class="text-4xl font-extrabold text-white">
                <?php echo e($stats['repairs']); ?>

            </p>
        </div>

        <!-- PRZYCHÓD -->
        <div class="relative overflow-hidden bg-gradient-to-br from-green-600 to-green-800 rounded-3xl p-6 shadow-lg">
            <div class="absolute right-4 top-4 opacity-20 text-6xl">
                <i class="fas fa-coins"></i>
            </div>
            <p class="text-sm text-green-200">Przychód</p>
            <p class="text-3xl font-extrabold text-white">
                <?php echo e(number_format($stats['income'], 2, ',', ' ')); ?> zł
            </p>
        </div>

        <!-- NIEOPŁACONE -->
        <div class="relative overflow-hidden bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-6 shadow-lg">
            <div class="absolute right-4 top-4 opacity-20 text-6xl">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <p class="text-sm text-red-200">Nieopłacone</p>
            <p class="text-4xl font-extrabold text-white">
                <?php echo e($stats['unpaid']); ?>

            </p>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-14">

        <!-- BAR -->
        <div class="bg-gray-800 rounded-3xl p-6 border border-gray-700 shadow-xl">
            <h2 class="text-xl font-bold mb-1">
                Przychody miesięczne
            </h2>
            <p class="text-sm text-gray-400 mb-4">
                Bieżący rok (<?php echo e($currentYear); ?>)
            </p>
            <canvas id="barChart" height="140"></canvas>
        </div>

        <!-- LINE -->
        <div class="bg-gray-800 rounded-3xl p-6 border border-gray-700 shadow-xl">
            <h2 class="text-xl font-bold mb-1">
                Porównanie rok do roku
            </h2>
            <p class="text-sm text-gray-400 mb-4">
                <?php echo e($previousYear); ?> vs <?php echo e($currentYear); ?>

            </p>
            <canvas id="lineChart" height="140"></canvas>
        </div>

    </div>

    <!-- OSTATNIE NAPRAWY -->
    <div class="bg-gray-800 rounded-3xl p-6 border border-gray-700 shadow-xl">
        <h2 class="text-xl font-bold mb-6">
            Ostatnie naprawy
        </h2>

        <ul class="space-y-4">
            <?php $__currentLoopData = $latestRepairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="flex items-center justify-between bg-gray-900/60 rounded-xl p-4">
                    <div>
                        <p class="font-semibold">
                            <?php echo e($repair->ship->name); ?>

                        </p>
                        <p class="text-sm text-gray-400">
                            <?php echo e($repair->ship->ownerShip->first_name); ?>

                            <?php echo e($repair->ship->ownerShip->last_name); ?>

                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        <?php echo e($repair->payemnt_done
                            ? 'bg-green-600/20 text-green-400'
                            : 'bg-red-600/20 text-red-400'); ?>">
                        <?php echo e($repair->payemnt_done ? 'Opłacona' : 'Nieopłacona'); ?>

                    </span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const months = [
    'Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
    'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'
];

const currentYearData = Array(12).fill(0);
const previousYearData = Array(12).fill(0);

<?php echo json_encode($incomeCurrentYear, 15, 512) ?>.forEach(item => {
    currentYearData[item.month - 1] = item.total;
});
<?php echo json_encode($incomePreviousYear, 15, 512) ?>.forEach(item => {
    previousYearData[item.month - 1] = item.total;
});

new Chart(barChart, {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Przychód',
            data: currentYearData,
            backgroundColor: 'rgba(99,102,241,0.7)'
        }]
    }
});

new Chart(lineChart, {
    type: 'line',
    data: {
        labels: months,
        datasets: [
            {
                label: '<?php echo e($previousYear); ?>',
                data: previousYearData,
                borderColor: 'rgb(239,68,68)',
                tension: 0.3
            },
            {
                label: '<?php echo e($currentYear); ?>',
                data: currentYearData,
                borderColor: 'rgb(34,197,94)',
                tension: 0.3
            }
        ]
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/new/resources/views/repairs/dashboard.blade.php ENDPATH**/ ?>