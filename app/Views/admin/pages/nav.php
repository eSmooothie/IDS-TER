<body  class="flex min-h-full" style="background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);">
  <!-- SIDE MENU -->
  <div class=" min-w-52 hidden md:block bg-gray-100 min-h-full">
    <div class="p-5">
      <div class="flex justify-center">
        <a href="<?php echo base_url(); ?>/admin/dashboard"><img src="/assets/img/hornet_400x400.jpg" alt="" 
          class="rounded-full w-20 hover:animate-pulse"
        ></a>
      </div>
      <div class="text-center">
        <span class="block text-xl">IDS - TER</span>
        <span class="block text-xxs">INTEGRATED DEVELOPMENTAL SCHOOL <br />TEACHER EFFICIENCY RATING</span>
      </div>
    </div>
    <!-- DASHBOARD -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4 hover:bg-gray-300">
      <span class=" text-xl col-span-1"><i class="fas fa-columns"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/dashboard" class="col-span-3">Dashboard</a>
    </div>
    <!-- STUDENT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4 hover:bg-gray-300">
      <span class=" text-xl col-span-1"><i class="fa fa-users"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/student" class="col-span-3">Student</a>
    </div>
    <!-- TEACHER -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fas fa-user-tie"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/teacher" class="col-span-3">Teacher</a>
    </div>
    <!-- EXECOM -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fas fa-user-secret"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/execom" class="col-span-3">Executives</a>
    </div>
    <!-- SECTION -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fab fa-buromobelexperte"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/section" class="col-span-3">Section</a>
    </div>
    <!-- DEPARTMENT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fa fa-th-list" aria-hidden="true"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/department" class="col-span-3">Department</a>
    </div>
    <!-- SUBJECT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fa fa-list"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/subject" class="col-span-3">Subject</a>
    </div>
    <!-- QUESTIONNAIRE -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/questionaire" class="col-span-3">Questionnaire</a>
    </div>
    <!-- ACTIVITY LOG -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fas fa-clipboard-list"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/activitylog" class="col-span-3">Activity Log</a>
    </div>
    <!-- LOGOUT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4  hover:bg-gray-300">
      <span class=" text-xl"><i class="fa fa-sign-out"></i></span>
      <a href="<?php echo $baseUrl; ?>" class="col-span-3">Log out</a>
    </div>
    
  </div>
