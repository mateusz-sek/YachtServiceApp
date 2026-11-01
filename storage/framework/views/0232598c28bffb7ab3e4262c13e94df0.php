<?php if($paginator->hasPages()): ?>
    <nav class="flex justify-center">
        <ul class="inline-flex items-center gap-1 px-4 py-3 bg-gray-800/80 
                   rounded-2xl border border-gray-700 shadow-xl">

            
            <?php if($paginator->onFirstPage()): ?>
                <li>
                    <span class="px-4 py-2 rounded-xl bg-gray-700/40 text-gray-500 cursor-not-allowed">
                        ‹
                    </span>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>"
                       class="px-4 py-2 rounded-xl bg-gray-700 text-gray-300
                              hover:bg-indigo-600 hover:text-white
                              transition shadow-md">
                        ‹
                    </a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                
                <?php if(is_string($element)): ?>
                    <li>
                        <span class="px-4 py-2 text-gray-500">
                            <?php echo e($element); ?>

                        </span>
                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li>
                                <span
                                    class="px-4 py-2 rounded-xl
                                           bg-gradient-to-br from-indigo-500 to-indigo-700
                                           text-white font-bold shadow-lg">
                                    <?php echo e($page); ?>

                                </span>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo e($url); ?>"
                                   class="px-4 py-2 rounded-xl
                                          bg-gray-700 text-gray-300
                                          hover:bg-indigo-600 hover:text-white
                                          transition shadow-md">
                                    <?php echo e($page); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>"
                       class="px-4 py-2 rounded-xl bg-gray-700 text-gray-300
                              hover:bg-indigo-600 hover:text-white
                              transition shadow-md">
                        ›
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <span class="px-4 py-2 rounded-xl bg-gray-700/40 text-gray-500 cursor-not-allowed">
                        ›
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /opt/lampp/htdocs/new/resources/views/vendor/pagination/pagination.blade.php ENDPATH**/ ?>