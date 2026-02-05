<input type="number" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
       <?php if($errors->has($name)): ?> class="text-neg" <?php endif; ?>
       <?php if(isset($placeholder)): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
       <?php if($autofocus ?? false): ?> autofocus <?php endif; ?>
       <?php if($disabled ?? false): ?> disabled="disabled" <?php endif; ?>
       <?php if($readonly ?? false): ?> readonly="readonly" <?php endif; ?>
       <?php if($min ?? false): ?> min="<?php echo e($min); ?>" <?php endif; ?>
       <?php if($max ?? false): ?> max="<?php echo e($max); ?>" <?php endif; ?>
       <?php if($step ?? false): ?> step="<?php echo e($step); ?>" <?php endif; ?>
       <?php if(isset($model) || old($name) || isset($value)): ?> value="<?php echo e(old($name) ?? $model->$name ?? $value); ?>" <?php endif; ?>>
<?php if($errors->has($name)): ?>
    <div class="text-neg text-small"><?php echo e($errors->first($name)); ?></div>
<?php endif; ?>
<?php /**PATH /app/www/resources/views/form/number.blade.php ENDPATH**/ ?>