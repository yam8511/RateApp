<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-lime.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <title><?php echo $__env->yieldContent('title'); ?></title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- Styles -->
  <link href="<?php echo e(url('css/app.css')); ?>" rel="stylesheet">
  <!-- Scripts -->
  <script>
     window.Laravel = <?php echo json_encode([
         'csrfToken' => csrf_token(),
     ]); ?>
  </script>
</head>

<body style="min-width:300px;">

  <nav class="w3-sidenav w3-card-2 w3-white w3-top" style="width:30%;display:none;z-index:2" id="mySidenav">
      <div class="w3-container w3-theme-d2">
        <span onclick="w3_close()" class="w3-closenav w3-right w3-xlarge">x</span>
        <br>
        <div class="w3-padding w3-center">
          <h3><?php echo e(Auth::check() ? Auth::user()->name : 'Guest'); ?></h3>
        </div>
      </div>
      <br>
      <a href="<?php echo e(url('/')); ?>">Home</a>
      <?php if(!Auth::check()): ?>
      <a href="<?php echo e(url('/login')); ?>">Login</a>
      <a href="<?php echo e(url('/register')); ?>">Register</a>
      <?php else: ?>
      <a href="<?php echo e(url('setRate')); ?>" >設定賠率</a>
      <a href="<?php echo e(url('lookBelow')); ?>" >查看下層</a>
      <a href="<?php echo e(url('addBelow')); ?>" >新增下層</a>
      <a href="<?php echo e(url('/logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
      <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
      <?php echo e(csrf_field()); ?>

      </form>
      <?php endif; ?>
  </nav>

  <header class="w3-container w3-card-4 w3-theme w3-top">
      <h1>
          <i class="w3-opennav fa fa-bars" onclick="w3_open()"></i>
          <?php echo $__env->yieldContent('title'); ?>
      </h1>
  </header>

  <div class="w3-container" style="margin-top:75px; margin-bottom:45px;">
      <hr>
      <!-- 成功訊息 -->
      <?php if(session('success')): ?>
        <div class="w3-round w3-pale-green">
            <span onclick="this.parentElement.style.display='none'" class="w3-closebtn"><i class="fa fa-close"></i></span>
            <h3><i class="fa fa-check-square-o"></i><?php echo e(session('success')); ?></h3>
        </div>
      <?php endif; ?>

      <!-- 錯誤訊息 -->
      <?php if(session('error')): ?>
        <div class="w3-round w3-pale-red">
            <span onclick="this.parentElement.style.display='none'" class="w3-closebtn"><i class="fa fa-close"></i></span>
            <h3><i class="fa fa-frown-o"></i><?php echo e(session('error')); ?></h3>
        </div>
      <?php endif; ?>
      
      <?php echo $__env->yieldContent('content'); ?>
      <hr>
  </div>

  <footer class="w3-container w3-theme w3-bottom">
    <h3>ChungYo RD1-Zoular</h3>
  </footer>

  <script>
  function w3_open() {
      document.getElementById("mySidenav").style.display = "block";
  }
  function w3_close() {
      document.getElementById("mySidenav").style.display = "none";
  }
  </script>

</body>
</html>