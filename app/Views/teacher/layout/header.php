<!DOCTYPE html>
<html lang="en" class=" h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- FontAwsome -->
  <script src="https://kit.fontawesome.com/b24469f289.js" crossorigin="anonymous"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Flowbite -->
  <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
  <!-- TailwindCSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/output.css">

  <title><?php echo "$page_title"; ?></title>
</head>
<body class="min-h-full" style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">

<div class="border border-black w-56 max-w-56 bg-gray-200 min-h-full fixed">
  <!-- PROFILE INFO -->
  <div class="flex-col flex items-center p-3 w-full">
    <div class="mb-4">
      <img src="<?php echo "$base_url";?>/assets/img/hornet_400x400.jpg" alt="" class="border border-pink-700 rounded-full w-32"></a>
    </div>
    <p class=" px-1 break-words w-full text-center" ><?php echo "{$personal_data['FN']} {$personal_data['LN']}"; ?></p>
    <p class=" text-base"><small><?php echo "{$personal_data['ID']}"; ?></small></p>
  </div>
  <!-- NAVIGATION -->
  <div class=" flex flex-col justify-between h-[71vh]">
    <div>
        <a href="<?php echo "$base_url/user/teacher/"; ?>" 
        class="border border-black p-2 border-r-0 border-l-0 items-center hover:bg-gray-300 flex justify-between py-3">
          <span class="">Evaluate</span>
          <i class="fa-solid fa-list-check fa-lg"></i>
        </a>
        <a href="<?php echo ($is_cleared)? "$base_url/user/teacher/analytics/rating":""; ?>"
        class="border border-black p-2 border-r-0 border-l-0 items-center flex justify-between hover:bg-gray-300 py-3">
          <?php
            if($is_cleared){
              ?>
              <span>Analytics</span>
              <i class="fa-solid fa-chart-pie fa-lg"></i> 
              <?php
            }else{
              ?>
              <span>Analytics (lock)</span>
              <i class="fas fa-lock fa-lg"></i> 
              <?php
            }
          ?>
        </a>
        <a href="<?php echo "$base_url/user/teacher/settings"; ?>"
        class="border border-black p-2 border-r-0 border-l-0 items-center flex justify-between hover:bg-gray-300 py-3">
          <span>Settings</span>
          <i class="fa-solid fa-screwdriver-wrench fa-lg"></i>
        </a>
    </div>

    <a href="<?php echo "$base_url/"; ?>"
     class=" p-2 border-r-0 border-l-0 items-center
      bg-red-500
     flex justify-between hover:bg-red-600 h-24">
      <span>Logout</span>
      <i class="fa-solid fa-arrow-right-from-bracket fa-lg"></i>
    </a>
  </div>
</div>

<div class="grid grid-cols-10">
  <div class=" col-span-2"></div>