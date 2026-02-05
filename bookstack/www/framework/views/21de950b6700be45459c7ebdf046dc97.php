<div class="content-wrap card auto-height">
    <h2 class="list-heading"><?php echo e(trans('entities.convert_to_book')); ?></h2>
    <div class="grid half left-focus no-row-gap">
        <p>
            <?php echo e(trans('entities.convert_to_book_desc')); ?>

        </p>
        <div class="text-m-right">
            <div component="dropdown" class="dropdown-container">
                <button refs="dropdown@toggle" class="button outline" aria-haspopup="true" aria-expanded="false">
                    <?php echo e(trans('entities.convert_chapter')); ?>

                </button>
                <ul refs="dropdown@menu" class="dropdown-menu" role="menu">
                    <li class="px-m py-s text-small text-muted">
                        <?php echo e(trans('entities.convert_chapter_confirm')); ?>

                        <br>
                        <?php echo e(trans('entities.convert_undo_warning')); ?>

                    </li>
                    <li>
                        <form action="<?php echo e($chapter->getUrl('/convert-to-book')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <button type="submit" class="text-link text-item"><?php echo e(trans('common.confirm')); ?></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><?php /**PATH /app/www/resources/views/chapters/parts/convert-to-book.blade.php ENDPATH**/ ?>