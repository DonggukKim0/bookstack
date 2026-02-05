<?php echo e(csrf_field()); ?>

<div class="form-group title-input">
    <label for="name"><?php echo e(trans('common.name')); ?></label>
    <?php echo $__env->make('form.text', ['name' => 'name', 'autofocus' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<div class="form-group description-input">
    <label for="description_html"><?php echo e(trans('common.description')); ?></label>
    <?php echo $__env->make('form.description-html-input', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<div class="form-group collapsible" component="collapsible" id="logo-control">
    <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
        <label for="tags"><?php echo e(trans('entities.chapter_tags')); ?></label>
    </button>
    <div refs="collapsible@content" class="collapse-content">
        <?php echo $__env->make('entities.tag-manager', ['entity' => $chapter ?? null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<div class="form-group collapsible" component="collapsible" id="template-control">
    <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
        <label for="template-manager"><?php echo e(trans('entities.default_template')); ?></label>
    </button>
    <div refs="collapsible@content" class="collapse-content">
        <?php echo $__env->make('entities.template-selector', ['entity' => $chapter ?? null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<div class="form-group text-right">
    <a href="<?php echo e(isset($chapter) ? $chapter->getUrl() : $book->getUrl()); ?>" class="button outline"><?php echo e(trans('common.cancel')); ?></a>
    <button type="submit" class="button"><?php echo e(trans('entities.chapters_save')); ?></button>
</div>

<?php echo $__env->make('entities.selector-popup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('form.editor-translations', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/www/resources/views/chapters/parts/form.blade.php ENDPATH**/ ?>