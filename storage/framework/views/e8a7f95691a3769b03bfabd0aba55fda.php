

<?php $__env->startSection('content'); ?>


<div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 min-h-screen">
    
    
    <div class="w-full max-w-xl bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700 space-y-6">
        <h3 class="text-3xl font-extrabold text-white text-center">Edytuj statek </h3>
        <form method="post" action="/ships/update/<?php echo e($ship->id); ?>" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            
            <div class="space-y-1">
                <label for="image" class="block text-sm font-medium text-gray-300">Zdjęcie Statku</label>
                
                <input class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:border-red-500 <?php else: ?> border-gray-600 focus:border-indigo-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        
                        file:mr-4 
                        file:py-2 
                        file:px-4 
                        file:rounded-lg 
                        file:border-0 
                        file:text-sm 
                        file:font-semibold 
                        file:bg-indigo-600 
                        file:text-white 
                        
                        file:transform 
                        file:transition 
                        file:duration-300 
                        hover:file:scale-105 
                        
                        hover:file:bg-indigo-700 
                        cursor-pointer" 
                        name="image" 
                        type="file" 
                        id="image">
                        
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                    <div class="text-red-400 text-xs mt-1"><?php echo e($message); ?></div> 
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div class="space-y-1">
                <label for="name" class="block text-sm font-medium text-gray-300">Nazwa</label>
                <input type="text" name="name" value = '<?php echo e($ship->name); ?>' id="name" placeholder="Nazwa"
                        value="<?php echo e(old('name')); ?>"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border transition duration-150 shadow-inner 
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:border-red-500 <?php else: ?> border-gray-600 focus:border-indigo-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                    <div class="text-red-400 text-xs mt-1"><?php echo e($message); ?></div> 
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <input type="hidden" name="client_id" id="client_id" value="<?php echo e($ship->ownerShip->id); ?>">

            
            
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg 
                                         transition duration-300 ease-in-out 
                                         transform hover:scale-105 
                                         focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                Przypisz statek
            </button>
            

        </form>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/new/resources/views/ships/edit.blade.php ENDPATH**/ ?>