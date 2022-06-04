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
            <a href="<?php echo base_url(); ?>/">
              <img src="/assets/img/hornet_400x400.jpg" alt="" class="rounded-full w-32 hover:animate-pulse">
            </a>
        </div>
        <div class="text-center">
            <span class="block text-4xl">IDS - TER</span>
            <span class="block text-sm">INTEGRATED DEVELOPMENTAL SCHOOL <br />TEACHER EFFICIENCY RATING</span>
        </div>
      </div>
      <div class="mt-3">
        <form id="adminLogin" class="" action="" method="post">
          <!-- Username -->
          <div class=" rounded-md flex justify-between mb-2">
            <span class="text-center p-2 w-11 text-black bg-pink-300 rounded-md rounded-r-none" id="label-username">
              <i class="fas fa-id-card-alt"></i></span>
            <input name="username" required type="text" class="w-full rounded-md rounded-l-none pl-3  border-none" placeholder="Username" 
            aria-label="Username" aria-describedby="label-username">
          </div>
          <!-- Password -->
          <div class=" rounded-md flex justify-between mb-2">
            <span class="text-center p-2 w-11 text-black bg-pink-300 rounded-md rounded-r-none" id="label-password">
              <i class="fas fa-key"></i></span>
            <input name="password" required type="password" class="w-full rounded-md rounded-l-none pl-3  border-none" 
            placeholder="Password" aria-label="Password" aria-describedby="label-password">
          </div>
          <div class="mb-2 text-center text-red-500">
            <span class="" id="errorMessage"></span>
          </div>
          <div class="flex justify-center">
            <button type="submit" name="button" class="border hover:bg-pink-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-pink-300">LOGIN</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>/assets/js/login.js" charset="utf-8"></script>
