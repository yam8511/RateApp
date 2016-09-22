<?php $__env->startSection('title', '新增下層成員'); ?>

<?php $__env->startSection('content'); ?>

<form method="post" action="<?php echo e(url('addBelow')); ?>">
    <?php echo e(csrf_field()); ?>


    <div class="w3-input-group">
        <label class="w3-label">名稱</label>
        <input class="w3-input" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
        <?php if($errors->has('name')): ?>
            <ul class="w3-text-red w3-ul">
                <?php $__currentLoopData = $errors->get('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li><strong><?php echo e($error); ?></li></strong>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="w3-input-group">
        <label class="w3-label">Email</label>
        <input class="w3-input" type="eamil" name="email" value="<?php echo e(old('email')); ?>" required>
        <?php if($errors->has('email')): ?>
            <ul class="w3-text-red w3-ul">
                <?php $__currentLoopData = $errors->get('email'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li><strong><?php echo e($error); ?></li></strong>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="w3-input-group">
        <label class="w3-label">密碼</label>
        <input class="w3-input" type="password" name="password" required>
        <?php if($errors->has('password')): ?>
            <ul class="w3-text-red w3-ul">
                <?php $__currentLoopData = $errors->get('password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li><strong><?php echo e($error); ?></li></strong>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="w3-input-group">
        <label class="w3-label">確認密碼</label>
        <input type="password" class="w3-input" name="password_confirmation" required>
    </div>

    <div class="w3-input-group">
        <label class="w3-label">角色</label><br>
        <?php for($i = $master; $i < count($roles); $i++): ?>
            <?php if($master == 0 || $master != $i): ?>
                <input class="w3-radio" type="radio" name="state" value="<?php echo e($i); ?>" checked>
                <label class="w3-validate"><?php echo e($roles[$i]); ?></label>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if($errors->has('state')): ?>
            <ul class="w3-text-red w3-ul">
                <?php $__currentLoopData = $errors->get('state'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li><strong><?php echo e($error); ?></li></strong>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="w3-input-group">
        <label class="w3-label">上層成員</label>
        <select class="w3-select" name="up">
            <option value="" disabled selected>選擇上層成員</option>
            <?php if($master == 0 || $master == 1): ?>
            <option value="">【無】</option>
            <?php endif; ?>
            <?php $__currentLoopData = $ups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $up): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($up->id); ?>">【<?php echo e($roles[$up->state]); ?>】 <?php echo e($up->name); ?> - <?php echo e($up->email); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </select>
        <?php if($errors->has('up')): ?>
            <ul class="w3-text-red w3-ul">
                <?php $__currentLoopData = $errors->get('up'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li><strong><?php echo e($error); ?></li></strong>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

    <input type="submit" value="新增下層" class="w3-btn">
    <a href="<?php echo e(url('/')); ?>" class="w3-btn w3-ripple">回首頁</a>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>