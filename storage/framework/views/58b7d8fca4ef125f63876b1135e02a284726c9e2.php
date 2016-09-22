<?php $__env->startSection('title', '設定賠率'); ?>

<?php $__env->startSection('content'); ?>
<?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post" action="<?php echo e(url('setRate')); ?>" class="w3-padding">
    <?php echo e(csrf_field()); ?>


    <div class="w3-row-padding w3-margin">
        <div class="w3-col m6">
            <label class="w3-label">單場最大賠率</label>
            <input class="w3-input" type="number" name="bg" value="<?php echo e(isset($user->bg) ? $user->bg : 0); ?>" required>
            <?php if($errors->has('bg')): ?>
                <span class="w3-text-red">
                    <strong><?php echo e($errors->first('bg')); ?></strong>
                </span>
            <?php endif; ?>
        </div>

        <div class="w3-col m6">
            <label class="w3-label">單場最小賠率</label>
            <input class="w3-input" type="number" name="sg" value="<?php echo e(isset($user->sg) ? $user->sg : 0); ?>" required>
            <?php if($errors->has('sg')): ?>
                <span class="w3-text-red">
                    <strong><?php echo e($errors->first('sg')); ?></strong>
                </span>
            <?php endif; ?>
        </div>

        <div class="w3-col m6">
            <label class="w3-label">單注最大賠率</label>
            <input class="w3-input" type="number" name="bb" value="<?php echo e(isset($user->bb) ? $user->bb : 0); ?>" required>
            <?php if($errors->has('bb')): ?>
                <span class="w3-text-red">
                    <strong><?php echo e($errors->first('bb')); ?></strong>
                </span>
            <?php endif; ?>
        </div>

        <div class="w3-col m6">
            <label class="w3-label">單注最小賠率</label>
            <input class="w3-input" type="number" name="sb" value="<?php echo e(isset($user->sb) ? $user->sb : 0); ?>" required>
            <?php if($errors->has('sb')): ?>
                <span class="w3-text-red">
                    <strong><?php echo e($errors->first('sb')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="w3-input-group w3-center">
        <button onclick="" class="w3-btn w3-round w3-theme-d1 w3-ripple">儲存</button>
        <button onclick="" class="w3-btn w3-round w3-theme-d3 w3-ripple">同步</button>
        <a href="<?php echo e(url('/')); ?>" class="w3-btn w3-round w3-theme-d5 w3-ripple">回首頁</a>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>