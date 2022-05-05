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
<body class="flex min-h-full" style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">
<div class="border border-black w-52 max-w-52 bg-gray-200 min-h-full">
  <!-- PROFILE INFO -->
  <div class="flex-col flex items-center p-3">
    <div class="mb-4">
      <img src="<?php echo "$base_url";?>/assets/img/hornet_400x400.jpg" alt="" class="border border-pink-700 rounded-full w-32"></a>
    </div>
    <p class=" whitespace-nowrap" ><?php echo "{$student_data['FN']} {$student_data['LN']}"; ?></p>
    <p class=" text-xs"><?php echo "{$student_data['ID']}"; ?></p>
  </div>
  <!-- NAVIGATION -->
  <div class=" flex-col flex">
    <a href="<?php echo "$base_url/user/student/"; ?>" 
    class="border border-black p-2 border-r-0 border-l-0 items-center grid grid-cols-4 hover:bg-gray-300">
      <i class="fas fa-star"></i>
      Evaluate
    </a>
    <a href="<?php echo "$base_url/user/student/settings"; ?>" 
    class="border border-black p-2 border-r-0 border-l-0 items-center grid grid-cols-4 hover:bg-gray-300">
      <i class="fas fa-cog"></i>
      Settings
    </a>
    <a href="<?php echo "$base_url/"; ?>" 
    class="border border-black p-2 border-r-0 border-l-0 items-center grid grid-cols-4 hover:bg-gray-300">
      <i class="fas fa-sign-out-alt"></i>
      Logout
    </a>
  </div>
</div>
