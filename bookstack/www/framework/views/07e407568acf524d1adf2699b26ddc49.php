<?php
    $sortRules = \BookStack\Sorting\SortRule::allByName();
?>

<?php $__env->startSection('card'); ?>
    <h1 id="sorting" class="list-heading"><?php echo e(trans('settings.sorting')); ?></h1>
    <form action="<?php echo e(url("/settings/sorting")); ?>" method="POST">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="section" value="sorting">

        <div class="setting-list">
            <div>
                <div class="mb-m">
                    <label class="setting-list-label"><?php echo e(trans('settings.sorting_page_limits')); ?></label>
                    <p class="small"><?php echo e(trans('settings.sorting_page_limits_desc')); ?></p>
                </div>
                <div class="flex-container-row wrap gap-m small-inputs">
                    <?php
                        $labelByKey = ['shelves' => trans('entities.shelves'), 'books' => trans('entities.books'), 'search' => trans('entities.search_results')];
                    ?>
                    <?php $__currentLoopData = $labelByKey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label for="setting-lists-page-count-<?php echo e($key); ?>"><?php echo e($label); ?></label>
                            <?php echo $__env->make('form.number', [
                                'name' => 'setting-lists-page-count-' . $key,
                                'value' => setting()->getInteger('lists-page-count-' . $key, 18, 1, 1000),
                                'min' => 1,
                                'step' => 1,
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="grid half gap-xl items-center">
                <div>
                    <label for="setting-sorting-book-default"
                           class="setting-list-label"><?php echo e(trans('settings.sorting_book_default')); ?></label>
                    <p class="small"><?php echo e(trans('settings.sorting_book_default_desc')); ?></p>
                </div>
                <div>
                    <select id="setting-sorting-book-default" name="setting-sorting-book-default"
                            <?php if($errors->has('setting-sorting-book-default')): ?> class="neg" <?php endif; ?>>
                        <option value="0" <?php if(intval(setting('sorting-book-default', '0')) === 0): ?> selected <?php endif; ?>>
                            -- <?php echo e(trans('common.none')); ?> --
                        </option>
                        <?php $__currentLoopData = $sortRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $set): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($set->id); ?>"
                                    <?php if(intval(setting('sorting-book-default', '0')) === $set->id): ?> selected <?php endif; ?>
                            >
                                <?php echo e($set->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

        </div>

        <div class="form-group text-right">
            <button type="submit" class="button"><?php echo e(trans('settings.settings_save')); ?></button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after-card'); ?>
    <div class="card content-wrap auto-height">
        <div class="flex-container-row items-center gap-m">
            <div class="flex">
                <h2 class="list-heading"><?php echo e(trans('settings.sorting_rules')); ?></h2>
                <p class="text-muted"><?php echo e(trans('settings.sorting_rules_desc')); ?></p>
            </div>
            <div>
                <a href="<?php echo e(url('/settings/sorting/rules/new')); ?>"
                   class="button outline"><?php echo e(trans('settings.sort_rule_create')); ?></a>
            </div>
        </div>

        <?php if(empty($sortRules)): ?>
            <p class="italic text-muted"><?php echo e(trans('common.no_items')); ?></p>
        <?php else: ?>
            <div class="item-list">
                <?php $__currentLoopData = $sortRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('settings.sort-rules.parts.sort-rule-list-item', ['rule' => $rule], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('settings.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/www/resources/views/settings/categories/sorting.blade.php ENDPATH**/ ?>