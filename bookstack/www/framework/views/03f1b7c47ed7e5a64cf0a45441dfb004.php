<?php $__env->startSection('body'); ?>

    <div class="container small">

        <div class="my-s">
            <?php echo $__env->make('entities.breadcrumbs', ['crumbs' => [
                $book,
                $chapter,
                $chapter->getUrl('/edit') => [
                    'text' => trans('entities.chapters_edit'),
                    'icon' => 'edit'
                ]
            ]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <main class="content-wrap card auto-height">
            <h1 class="list-heading"><?php echo e(trans('entities.chapters_edit')); ?></h1>
            <form action="<?php echo e($chapter->getUrl()); ?>" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <?php echo $__env->make('chapters.parts.form', ['model' => $chapter], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </main>

        <?php if(userCan(\BookStack\Permissions\Permission::ChapterDelete, $chapter) && userCan(\BookStack\Permissions\Permission::BookCreateAll)): ?>
            <?php echo $__env->make('chapters.parts.convert-to-book', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/www/resources/views/chapters/edit.blade.php ENDPATH**/ ?>