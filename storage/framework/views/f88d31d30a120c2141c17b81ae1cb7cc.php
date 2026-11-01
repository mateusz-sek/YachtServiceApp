

<?php $__env->startSection('content'); ?>

    
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 text-white"> 

        
        <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-2xl mb-8">
            <h1 class="text-3xl font-extrabold text-white mb-2">
                Edytuj Zlecenie Naprawy 🔧
            </h1>
            <p class="text-gray-400">
            </p>
        </div>

        
        <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-2xl">
            
            <form method="post" action="/repairs/update/<?php echo e($repair->id); ?>">
                
                <?php echo csrf_field(); ?> 
                
                
                <div class="mb-5">
                    <label for="desc" class="block text-sm font-medium text-gray-300 mb-2">Opis Naprawy</label>
                    <textarea class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg border 
                                     <?php $__errorArgs = ['desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-gray-700 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                     focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner" 
                              style="height: 150px" name="desc" id="desc" placeholder="Szczegółowy opis wykonanej pracy..."><?php echo e($repair->desc); ?></textarea>
                    
                    <?php $__errorArgs = ['desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="text-sm text-red-400 mt-1"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                
                <div class="mb-5">
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Cena (PLN)</label>
                    <input type="number" step="0.01" name="price" id="price" value="<?php echo e($repair->price); ?>"
                           class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg border 
                                  <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-gray-700 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                  focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner"
                           placeholder='<?php echo e($repair->price); ?>'>
                           
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="text-sm text-red-400 mt-1"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                
                <div class="mb-8">
                    <label for="date_of_payment" class="block text-sm font-medium text-gray-300 mb-2">Termin Płatności</label>
                    <input type="date" name="date_of_payment" id="date_of_payment" value="<?php echo e($repair->date_of_payment); ?>"
                           class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg border 
                                  <?php $__errorArgs = ['date_of_payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-gray-700 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                  focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-inner">
                           
                    <?php $__errorArgs = ['date_of_payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="text-sm text-red-400 mt-1"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                
                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    Edytuj Zamówienie
                </button>
            </form>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\app\resources\views/repairs/edit.blade.php ENDPATH**/ ?>