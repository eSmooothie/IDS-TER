<!DOCTYPE html>
<html lang="en" class=" h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/b24469f289.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/output.css">
  <title>IDS | TER</title>
</head>
<body class="overflow-hidden" style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">
  <div class="flex h-screen">
    <div class="w-96 m-auto">
      <div class="p-8 border-5 border-solid border-black rounded-md" 
        style="background-color: #EEEEEE;">
        <div class="p-5">
          <div class="flex justify-center">
            <a href="<?php echo base_url(); ?>/admin"><img src="/assets/img/hornet_400x400.jpg" alt="" 
              class="rounded-full w-32 hover:animate-pulse"
            ></a>
          </div>
          <div class="text-center">
            <span class="block text-4xl">IDS - TER</span>
            <span class="block text-xs">INTEGRATED DEVELOPMENTAL SCHOOL <br />TEACHER EFFICIENCY RATING</span>
          </div>
        </div>
        <div class="mt-3">
          <form id="userLogin" action="/user/login" method="POST">
            <!-- Log in as -->
            <div>
              <p class=" text-base">You are?</p>
              <div class="flex justify-between mb-8">
                <div class="">
                  <input type="radio" class="sr-only peer" id="btn-check-student" name="logInAs" value="student" required>
                  <label class="flex p-2 pl-8 pr-8 bg-white border 
                  border-gray-300 rounded-lg 
                  cursor-pointer focus:outline-none 
                  hover:bg-gray-200 peer-checked:ring-pink-400
                  peer-checked:bg-pink-300
                  peer-checked:ring-2 peer-checked:border-transparent" 
                  for="btn-check-student">I'm a student</label>
                </div>
                <div class="">
                  <input type="radio" class="sr-only peer" id="btn-check-teacher" name="logInAs" value="teacher" required>
                  <label class="flex p-2 pl-8 pr-8 bg-white border 
                  border-gray-300 rounded-lg 
                  cursor-pointer focus:outline-none 
                  hover:bg-gray-200 peer-checked:ring-pink-400
                  peer-checked:bg-pink-300
                  peer-checked:ring-2 peer-checked:border-transparent" 
                  for="btn-check-teacher">I'm a teacher</label>
                </div>
              </div>
            </div>
            <!-- Username -->
            <div class=" rounded-md flex justify-between mb-2 ">
              <span class="text-center p-2 w-11 text-black bg-pink-300 rounded-md rounded-r-none" id="label-username">
                <i class="fas fa-id-card-alt"></i></span>
              <input required type="text" name="username" 
              class="w-full rounded-md rounded-l-none pl-3 border-none" 
              placeholder="20xx-xxxx" aria-label="Username" aria-describedby="label-username">
            </div>
            <!-- Password -->
            <div class=" rounded-md flex justify-between mb-3">
              <span class="text-center p-2 w-11 text-black bg-pink-300 rounded-md rounded-r-none" id="label-password">
                <i class="fas fa-key"></i></span>
              <input required type="password" name="password" 
              class="w-full border-none rounded-md rounded-l-none pl-3 " 
              placeholder="Password" aria-label="Password" aria-describedby="label-password">
            </div>
            
            <?php if(!empty($sys_msg)){?>
              <div class="mb-2 text-center text-red-500">
                <span class="" id="errMsg"><?php echo $sys_msg;?></span>
              </div>
            <?php } ?>

            <div class="flex justify-center">
              <button type="submit" name="button" class="border hover:bg-pink-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-pink-300">LOGIN</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
