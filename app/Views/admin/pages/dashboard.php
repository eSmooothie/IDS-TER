<body class="flex min-h-full" style="background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);">
  <!-- SIDE MENU -->
  <div class="w-52 hidden md:block bg-gray-100 min-h-full">
    <div class="p-5">
      <div class="flex justify-center">
        <a href="<?php echo base_url(); ?>/admin"><img src="/assets/img/hornet_400x400.jpg" alt="" 
          class="rounded-full w-20 hover:animate-pulse"
        ></a>
      </div>
      <div class="text-center">
        <span class="block text-xl">IDS - TER</span>
        <span class="block text-xxs">INTEGRATED DEVELOPMENTAL SCHOOL <br />TEACHER EFFICIENCY RATING</span>
      </div>
    </div>
    <!-- DASHBOARD -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl col-span-1"><i class="fas fa-columns"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/dashboard" class="col-span-3">Dashboard</a>
    </div>
    <!-- STUDENT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl col-span-1"><i class="fa fa-users"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/student" class="col-span-3">Student</a>
    </div>
    <!-- TEACHER -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fas fa-user-tie"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/teacher" class="col-span-3">Teacher</a>
    </div>
    <!-- EXECOM -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fas fa-user-secret"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/execom" class="col-span-3">Executives</a>
    </div>
    <!-- SECTION -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fab fa-buromobelexperte"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/section" class="col-span-3">Section</a>
    </div>
    <!-- DEPARTMENT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fa fa-th-list" aria-hidden="true"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/department" class="col-span-3">Department</a>
    </div>
    <!-- SUBJECT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fa fa-list"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/subject" class="col-span-3">Subject</a>
    </div>
    <!-- QUESTIONNAIRE -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/questionaire" class="col-span-3">Questionnaire</a>
    </div>
    <!-- ACTIVITY LOG -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fas fa-clipboard-list"></i></span>
      <a href="<?php echo $baseUrl; ?>/admin/activitylog" class="col-span-3">Activity Log</a>
    </div>
    <!-- LOGOUT -->
    <div class="border border-black p-2 border-r-0 border-l-0 grid grid-cols-4">
      <span class=" text-xl"><i class="fa fa-sign-out"></i></span>
      <a href="<?php echo $baseUrl; ?>" class="col-span-3">Log out</a>
    </div>
    
  </div>
  <!-- CONTENT -->
  <div class=" w-full p-2">
    <!-- SYSTEM INFO -->
    <div class="w-full grid grid-cols-3 bg-gray-100 pb-2 pt-2 rounded-md mb-3">
      <div class=" flex flex-col items-center justify-center">
        <span class="text-2xl font-bold"><i class="fa fa-calendar" aria-hidden="true"></i>&emsp;<?php echo "{$school_year['SY']} : {$school_year['SEMESTER']}"; ?></span>
        <span class="text-xxs">School Year : Semester</span>
      </div>
      <div class=" flex flex-col items-center justify-center">
        <span class="text-2xl font-bold"><i class="fas fa-users"></i>&emsp;<?php echo "$countStudent"; ?></span>
        <span class="text-xxs">Students</span>
      </div>
      <div class=" flex flex-col items-center justify-center">
        <span class="text-2xl font-bold"><i class="fas fa-user-tie    "></i>&emsp;<?php echo "$countTeacher"; ?></span>
        <span class="text-xxs">Teachers</span>
      </div>
    </div>
    <!--  -->
    <div class=" bg-gray-100 p-2 rounded-md mb-10">
      <div class="flex mb-3">
        <!-- NEW SCHOOL YEAR -->
        <div class="border border-gray-400 p-2 w-1/2 mr-1 rounded-md">
          <p class="text-base font-bold mb-3">New School Year</p>
          <form class="" id="newSchoolYear">
            <div class="flex mb-2 items-center">
              <label class=" w-24" for="from">From: </label>
              <input type="month" min="2018-01" name="from"
              value="" id="from" class=" w-48 border border-black rounded-md p-2 text-xs" required>
            </div>
            <div class="flex items-center mb-2">
              <label for="to" class=" w-24">To: </label>
              <input type="month" min="2018-01" name="to"
              value="" id="to" class=" w-48 border border-black rounded-md p-2 text-xs" required>
            </div>
            <div class="flex items-center mb-5">
              <label for="to" class="w-24">Semester</label>
              <input type="number" min="1" max="4" name="semester"
              id="to" class=" w-48 border border-black rounded-md p-2 text-xs" required>
            </div>
            <div class="text-danger text-center">
              <p id="errMessage" class=" text-xs text-red-500"></p>
            </div>
            <div class="flex justify-end">
              <button type="submit" class=" border hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300">Submit</button>
            </div>
          </form>
        </div>
        <!-- INSTRUCTION -->
        <div class="border border-gray-400 p-2 w-1/2 ml-1 rounded-md">
          <p class="font-bold text-base">Instruction:</p>
          <p class="mt-3">When creating new school year there are information must be setup before you proceed to evaluation. You must perform following(in order):</p>
          <ul class=" list-decimal pl-8 mt-3">
            <li>
              Update/Edit the teachers handled subjects. 
              <a href="<?php echo "$baseUrl/admin/teacher"; ?>" class=" text-blue-700 text-xs">GO TO TEACHER PAGE</a>
            </li>
            <li>
              Enroll students in the section and update/edit subjects in section. 
              <a href="<?php echo "$baseUrl/admin/section"; ?>" class=" text-blue-700 text-xs">GO TO SECTION PAGE</a>
            </li>
            <li>
              Select a chairperson per department.
              <a href="<?php echo "$baseUrl/admin/department"; ?>" class=" text-blue-700 text-xs">GO TO DEPARTMENT PAGE</a>
            </li>
            <li>
              Assign a teacher in the executive committee.
              <a href="<?php echo "$baseUrl/admin/execom"; ?>" class=" text-blue-700 text-xs">GO TO EXECOM PAGE</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- LINKS -->
      <div class="px-2 pb-7 pt-9 mb- grid grid-cols-3 gap-7 border border-gray-400 rounded-md">
        <!-- Student -->
        <a href="<?php echo $baseUrl; ?>/admin/student" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fa fa-users"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Student</p>
            <span class=" text-xs">Manage IDS Students</span>
          </div>
        </a>
        <!-- Teacher -->
        <a href="<?php echo $baseUrl; ?>/admin/teacher" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fas fa-user-tie"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Teacher</p>
            <span class=" text-xs">Manage IDS Teachers</span>
          </div>
        </a>
        <!-- Execom -->
        <a href="<?php echo $baseUrl; ?>/admin/execom" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fas fa-user-secret" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Executive Committee</p>
            <span class=" text-xs">Manage Executive Committee</span>
          </div>
        </a>        
        <!-- Section -->
        <a href="<?php echo $baseUrl; ?>/admin/section" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fab fa-buromobelexperte"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Section</p>
            <span class=" text-xs">Manage IDS Sections</span>
          </div>
        </a>
        <!-- Department -->
        <a href="<?php echo $baseUrl; ?>/admin/department" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fa fa-th-list" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Department</p>
            <span class=" text-xs">Manage IDS Departments</span>
          </div>
        </a>
        <!-- Subject -->
        <a href="<?php echo $baseUrl; ?>/admin/subject" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fa fa-list" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Subjects</p>
            <span class=" text-xs">Manage Subject</span>
          </div>
        </a>
        <!-- Manage Questionnaire -->
        <a href="<?php echo $baseUrl; ?>/admin/questionaire" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Questionnaire</p>
            <span class=" text-xs">Manage evaluation questions</span>
          </div>
        </a>
        <!-- Activit log -->
        <a href="<?php echo $baseUrl; ?>/admin/activitylog" class="w-full h-full flex items-center p-2 bg-blue-300 hover:bg-blue-400 rounded-md" style="">
          <span class=" text-3xl mr-3"><i class="fas fa-clipboard-list"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Activity Log</p>
            <span class=" text-xs">Activity Logs</span>
          </div>
        </a>
        
        <!-- END -->
      </div>
    </div>
  </div>

<script src="<?php echo "$baseUrl/assets/js/adminDashboard.js"; ?>" charset="utf-8"></script>
