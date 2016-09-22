<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<h1>Hello, <?php echo e(Auth::user()->name); ?></h1>
<h3>您可以:</h3>
<div class="w3-btn-group">
    <?php if($user->state != 0 && $user->state != 1): ?>
    <a href="<?php echo e(url('setRate')); ?>" class="w3-btn w3-theme-d1 w3-ripple">設定賠率</a>
    <?php endif; ?>
    <a href="<?php echo e(url('lookBelow')); ?>" class="w3-btn w3-theme-d2 w3-ripple">查看下層</a>
    <a href="<?php echo e(url('addBelow')); ?>" class="w3-btn w3-theme-d3 w3-ripple">新增下層</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>