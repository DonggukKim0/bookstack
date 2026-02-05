<?php $__env->startSection('body'); ?>

    <div class="container small">

        <div class="my-s">
            <?php echo $__env->make('entities.breadcrumbs', ['crumbs' => [
                $shelf,
                $shelf->getUrl('/edit') => [
                    'text' => trans('entities.shelves_edit'),
                    'icon' => 'edit',
                ]
            ]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <main class="card content-wrap">
            <h1 class="list-heading"><?php echo e(trans('entities.shelves_edit')); ?></h1>
            <form action="<?php echo e($shelf->getUrl()); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <?php echo $__env->make('shelves.parts.form', ['model' => $shelf], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </main>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/www/resources/views/shelves/edit.blade.php ENDPATH**/ ?>