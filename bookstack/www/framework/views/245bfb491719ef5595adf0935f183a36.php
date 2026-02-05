<div class="item-list-row flex-container-row items-center wrap">
    <div class="<?php echo e(isset($nameFilter) && $tag->value ? 'flex-2' : 'flex'); ?> py-s px-m min-width-m">
        <span class="text-bigger mr-xl"><?php echo $__env->make('entities.tag', ['tag' => $tag], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
    </div>
    <div class="flex-2 flex-container-row justify-center items-center gap-m py-s px-m min-width-l wrap">
        <a href="<?php echo e(isset($tag->value) ? $tag->valueUrl() : $tag->nameUrl()); ?>"
           title="<?php echo e(trans('entities.tags_usages')); ?>"
           class="flex fill-area min-width-xxs bold text-right text-muted"><span class="opacity-60"><?php echo (new \BookStack\Util\SvgIcon('leaderboard'))->toHtml(); ?></span><?php echo e($tag->usages); ?></a>
        <a href="<?php echo e(isset($tag->value) ? $tag->valueUrl() : $tag->nameUrl() . '+{type:page}'); ?>"
           title="<?php echo e(trans('entities.tags_assigned_pages')); ?>"
           class="flex fill-area min-width-xxs bold text-right text-page"><span class="opacity-60"><?php echo (new \BookStack\Util\SvgIcon('page'))->toHtml(); ?></span><?php echo e($tag->page_count); ?></a>
        <a href="<?php echo e(isset($tag->value) ? $tag->valueUrl() : $tag->nameUrl() . '+{type:chapter}'); ?>"
           title="<?php echo e(trans('entities.tags_assigned_chapters')); ?>"
           class="flex fill-area min-width-xxs bold text-right text-chapter"><span class="opacity-60"><?php echo (new \BookStack\Util\SvgIcon('chapter'))->toHtml(); ?></span><?php echo e($tag->chapter_count); ?></a>
        <a href="<?php echo e(isset($tag->value) ? $tag->valueUrl() : $tag->nameUrl() . '+{type:book}'); ?>"
           title="<?php echo e(trans('entities.tags_assigned_books')); ?>"
           class="flex fill-area min-width-xxs bold text-right text-book"><span class="opacity-60"><?php echo (new \BookStack\Util\SvgIcon('book'))->toHtml(); ?></span><?php echo e($tag->book_count); ?></a>
        <a href="<?php echo e(isset($tag->value) ? $tag->valueUrl() : $tag->nameUrl() . '+{type:bookshelf}'); ?>"
           title="<?php echo e(trans('entities.tags_assigned_shelves')); ?>"
           class="flex fill-area min-width-xxs bold text-right text-bookshelf"><span class="opacity-60"><?php echo (new \BookStack\Util\SvgIcon('bookshelf'))->toHtml(); ?></span><?php echo e($tag->shelf_count); ?></a>
    </div>
    <?php if($tag->values ?? false): ?>
        <div class="flex text-s-right text-muted py-s px-m min-width-s">
            <a href="<?php echo e(url('/tags?name=' . urlencode($tag->name))); ?>"><?php echo e(trans('entities.tags_x_unique_values', ['count' => $tag->values])); ?></a>
        </div>
    <?php elseif(empty($nameFilter)): ?>
        <div class="flex text-s-right text-muted py-s px-m min-width-s">
            <a href="<?php echo e(url('/tags?name=' . urlencode($tag->name))); ?>"><?php echo e(trans('entities.tags_all_values')); ?></a>
        </div>
    <?php endif; ?>
</div><?php /**PATH /app/www/resources/views/tags/parts/tags-list-item.blade.php ENDPATH**/ ?>