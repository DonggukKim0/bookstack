<?php $__env->startSection('container-attrs'); ?>
    component="entity-search"
    option:entity-search:entity-id="<?php echo e($chapter->id); ?>"
    option:entity-search:entity-type="chapter"
<?php $__env->stopSection(); ?>

<?php $__env->startPush('social-meta'); ?>
    <meta property="og:description" content="<?php echo e(Str::limit($chapter->description, 100, '...')); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('entities.body-tag-classes', ['entity' => $chapter], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('body'); ?>

    <div class="mb-m print-hidden">
        <?php echo $__env->make('entities.breadcrumbs', ['crumbs' => [
            $chapter->book,
            $chapter,
        ]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <main class="content-wrap card">
        <h1 class="break-text"><?php echo e($chapter->name); ?></h1>
        <div refs="entity-search@contentView" class="chapter-content">
            <div class="text-muted break-text"><?php echo $chapter->descriptionInfo()->getHtml(); ?></div>
            <?php if(count($pages) > 0): ?>
                <div class="entity-list book-contents">
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('pages.parts.list-item', ['page' => $page], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="mt-xl">
                    <hr>
                    <p class="text-muted italic mb-m mt-xl"><?php echo e(trans('entities.chapters_empty')); ?></p>

                    <div class="icon-list block inline">
                        <?php if(userCan(\BookStack\Permissions\Permission::PageCreate, $chapter)): ?>
                            <a href="<?php echo e($chapter->getUrl('/create-page')); ?>" class="icon-list-item text-page">
                                <span class="icon"><?php echo (new \BookStack\Util\SvgIcon('page'))->toHtml(); ?></span>
                                <span><?php echo e(trans('entities.books_empty_create_page')); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if(userCan(\BookStack\Permissions\Permission::BookUpdate, $book)): ?>
                            <a href="<?php echo e($book->getUrl('/sort')); ?>" class="icon-list-item text-book">
                                <span class="icon"><?php echo (new \BookStack\Util\SvgIcon('book'))->toHtml(); ?></span>
                                <span><?php echo e(trans('entities.books_empty_sort_current_book')); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endif; ?>
        </div>

        <?php echo $__env->make('entities.search-results', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </main>

    <?php echo $__env->make('entities.sibling-navigation', ['next' => $next, 'previous' => $previous], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('right'); ?>

    <div class="mb-xl">
        <h5><?php echo e(trans('common.details')); ?></h5>
        <div class="blended-links">
            <?php echo $__env->make('entities.meta', ['entity' => $chapter, 'watchOptions' => $watchOptions], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php if($book->hasPermissions()): ?>
                <div class="active-restriction">
                    <?php if(userCan(\BookStack\Permissions\Permission::RestrictionsManage, $book)): ?>
                        <a href="<?php echo e($book->getUrl('/permissions')); ?>" class="entity-meta-item">
                            <?php echo (new \BookStack\Util\SvgIcon('lock'))->toHtml(); ?>
                            <div><?php echo e(trans('entities.books_permissions_active')); ?></div>
                        </a>
                    <?php else: ?>
                        <div class="entity-meta-item">
                            <?php echo (new \BookStack\Util\SvgIcon('lock'))->toHtml(); ?>
                            <div><?php echo e(trans('entities.books_permissions_active')); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($chapter->hasPermissions()): ?>
                <div class="active-restriction">
                    <?php if(userCan(\BookStack\Permissions\Permission::RestrictionsManage, $chapter)): ?>
                        <a href="<?php echo e($chapter->getUrl('/permissions')); ?>" class="entity-meta-item">
                            <?php echo (new \BookStack\Util\SvgIcon('lock'))->toHtml(); ?>
                            <div><?php echo e(trans('entities.chapters_permissions_active')); ?></div>
                        </a>
                    <?php else: ?>
                        <div class="entity-meta-item">
                            <?php echo (new \BookStack\Util\SvgIcon('lock'))->toHtml(); ?>
                            <div><?php echo e(trans('entities.chapters_permissions_active')); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="actions mb-xl">
        <h5><?php echo e(trans('common.actions')); ?></h5>
        <div class="icon-list text-link">

            <?php if(userCan(\BookStack\Permissions\Permission::PageCreate, $chapter)): ?>
                <a href="<?php echo e($chapter->getUrl('/create-page')); ?>" data-shortcut="new" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('add'))->toHtml(); ?></span>
                    <span><?php echo e(trans('entities.pages_new')); ?></span>
                </a>
            <?php endif; ?>

            <hr class="primary-background"/>

            <?php if(userCan(\BookStack\Permissions\Permission::ChapterUpdate, $chapter)): ?>
                <a href="<?php echo e($chapter->getUrl('/edit')); ?>" data-shortcut="edit" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('edit'))->toHtml(); ?></span>
                    <span><?php echo e(trans('common.edit')); ?></span>
                </a>
            <?php endif; ?>
            <?php if(userCanOnAny(\BookStack\Permissions\Permission::Create, \BookStack\Entities\Models\Book::class) || userCan(\BookStack\Permissions\Permission::ChapterCreateAll) || userCan(\BookStack\Permissions\Permission::ChapterCreateOwn)): ?>
                <a href="<?php echo e($chapter->getUrl('/copy')); ?>" data-shortcut="copy" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('copy'))->toHtml(); ?></span>
                    <span><?php echo e(trans('common.copy')); ?></span>
                </a>
            <?php endif; ?>
            <?php if(userCan(\BookStack\Permissions\Permission::ChapterUpdate, $chapter) && userCan(\BookStack\Permissions\Permission::ChapterDelete, $chapter)): ?>
                <a href="<?php echo e($chapter->getUrl('/move')); ?>" data-shortcut="move" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('folder'))->toHtml(); ?></span>
                    <span><?php echo e(trans('common.move')); ?></span>
                </a>
            <?php endif; ?>
            <?php if(userCan(\BookStack\Permissions\Permission::RestrictionsManage, $chapter)): ?>
                <a href="<?php echo e($chapter->getUrl('/permissions')); ?>" data-shortcut="permissions" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('lock'))->toHtml(); ?></span>
                    <span><?php echo e(trans('entities.permissions')); ?></span>
                </a>
            <?php endif; ?>
            <?php if(userCan(\BookStack\Permissions\Permission::ChapterDelete, $chapter)): ?>
                <a href="<?php echo e($chapter->getUrl('/delete')); ?>" data-shortcut="delete" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('delete'))->toHtml(); ?></span>
                    <span><?php echo e(trans('common.delete')); ?></span>
                </a>
            <?php endif; ?>

            <?php if($chapter->book && userCan(\BookStack\Permissions\Permission::BookUpdate, $chapter->book)): ?>
                <hr class="primary-background"/>
                <a href="<?php echo e($chapter->book->getUrl('/sort')); ?>" data-shortcut="sort" class="icon-list-item">
                    <span><?php echo (new \BookStack\Util\SvgIcon('sort'))->toHtml(); ?></span>
                    <span><?php echo e(trans('entities.chapter_sort_book')); ?></span>
                </a>
            <?php endif; ?>

            <hr class="primary-background"/>

            <?php if($watchOptions->canWatch() && !$watchOptions->isWatching()): ?>
                <?php echo $__env->make('entities.watch-action', ['entity' => $chapter], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
            <?php if(!user()->isGuest()): ?>
                <?php echo $__env->make('entities.favourite-action', ['entity' => $chapter], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
            <?php if(userCan(\BookStack\Permissions\Permission::ContentExport)): ?>
                <?php echo $__env->make('entities.export-menu', ['entity' => $chapter], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('left'); ?>

    <?php echo $__env->make('entities.search-form', ['label' => trans('entities.chapters_search_this')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if($chapter->tags->count() > 0): ?>
        <div class="mb-xl">
            <?php echo $__env->make('entities.tag-list', ['entity' => $chapter], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php endif; ?>

    <?php echo $__env->make('entities.book-tree', ['book' => $book, 'sidebarTree' => $sidebarTree], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.tri', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/www/resources/views/chapters/show.blade.php ENDPATH**/ ?>