<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<h1>Hello, <?php echo e($user->name); ?></h1>
<?php if($user->state > 1 && $user->state < 5): ?>
    <ul class="w3-ul w3-border">
        <li class="w3-theme w3-xxlarge">目前賠率限額</li>
        <li class="w3-xlarge">單場最大賠率: <?php echo e($user->rate()->bg); ?></li>
        <li class="w3-xlarge">單場最小賠率: <?php echo e($user->rate()->sg); ?></li>
        <li class="w3-xlarge">單注最大賠率: <?php echo e($user->rate()->bb); ?></li>
        <li class="w3-xlarge">單注最小賠率: <?php echo e($user->rate()->sb); ?></li>
    </ul>
<?php endif; ?>

<?php if($user->state < 4): ?>
    <h3>您可以:</h3>
    <div class="w3-btn-group">
        <?php if($user->state != 0 && $user->state != 1): ?>
        <a href="<?php echo e(url('setRate')); ?>" class="w3-btn w3-theme-d1 w3-ripple w3-large">設定賠率</a>
        <?php endif; ?>
        <a href="<?php echo e(url('lookBelow')); ?>" class="w3-btn w3-theme-d2 w3-ripple w3-large">查看下層</a>
        <a href="<?php echo e(url('addBelow')); ?>" class="w3-btn w3-theme-d3 w3-ripple w3-large">新增下層</a>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>