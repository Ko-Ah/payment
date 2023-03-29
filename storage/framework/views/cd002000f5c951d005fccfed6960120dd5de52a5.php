<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<?php echo $__env->make('dashboard.layouts.particials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body class="g-sidenav-show rtl bg-gray-200">

<?php echo $__env->make('dashboard.layouts.particials.left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-x-hidden">


    <?php echo $__env->make('dashboard.layouts.particials.main-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
</main>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\kosar ahmadian\payStar\resources\views/dashboard/layouts/app.blade.php ENDPATH**/ ?>