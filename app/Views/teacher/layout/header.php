<!DOCTYPE html>
<html lang="en" class=" h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- FontAwsome -->
  <script src="https://kit.fontawesome.com/b24469f289.js" crossorigin="anonymous"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/bootstrap-5.0.2/css/bootstrap.min.css">
  <script src="<?php echo base_url(); ?>/bootstrap-5.0.2/js/bootstrap.min.js" charset="utf-8"></script>

  <title><?php echo "$pageTitle"; ?></title>
</head>
<body style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">
<div class="border bg-white col-xl-2 col-lg-3 col-md-4" style="position:fixed; height:100vh;">
  <div class="p-3">
    <div class="">
      <img src="https://via.placeholder.com/150" alt="" class="d-block mx-auto rounded-circle" style="height:150px; width:150px;"></a>
    </div>
    <p class="text-center fw-bold mb-0" ><?php echo "{$myData['FN']} {$myData['LN']}"; ?></p>
    <p class="text-center fw-bold mb-0" style="font-size:14px;"><small><?php echo "{$myData['ID']}"; ?></small></p>
  </div>
  <div class="">
    <a href="<?php echo "$baseUrl/user/teacher/"; ?>" class="btn btn-outline-primary w-100 rounded-0 text-start">
      <i class="fas fa-star"></i>
      Evaluate
    </a>
    <a href="<?php echo "$baseUrl/user/teacher/analytics/rating"; ?>" class="btn btn-outline-primary w-100 rounded-0 text-start">
      <i class="fas fa-chart-bar"></i>
      Analytics
    </a>
    <a href="<?php echo "$baseUrl/user/teacher/settings"; ?>" class="btn btn-outline-warning w-100 rounded-0 text-start">
      <i class="fas fa-cog"></i>
      Settings
      <i class="fas fa-exclamation-triangle"></i>
    </a>
    <a href="<?php echo "$baseUrl/"; ?>" class="btn btn-outline-primary w-100 rounded-0 text-start">
      <i class="fas fa-sign-out-alt"></i>
      Logout
    </a>
  </div>
</div>
