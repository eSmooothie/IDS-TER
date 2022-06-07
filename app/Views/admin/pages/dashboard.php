  <script src="<?php echo "$base_url/assets/js/adminDashboard.js"; ?>" charset="utf-8"></script>
  <!-- CONTENT -->
  <div class=" w-full col-span-7 p-2 space-y-3">
    <!-- SYSTEM INFO -->
    <div class="w-full grid grid-cols-3 bg-gray-100 pb-2 pt-2 rounded-md">
      <div class=" flex flex-col items-center justify-center">
        <span class="text-2xl font-bold"><i class="fa fa-calendar" aria-hidden="true"></i>&emsp;<?php echo "{$school_year['SY']} : {$school_year['SEMESTER']}"; ?></span>
        <span class="text-sm">School Year : Semester</span>
      </div>
      <div class=" flex flex-col items-center justify-center">
        <span class="text-2xl font-bold"><i class="fas fa-users"></i>&emsp;<?php echo "$countStudent"; ?></span>
        <span class="text-sm">Number of Students</span>
      </div>
      <div class=" flex flex-col items-center justify-center">
        <span class="text-2xl font-bold"><i class="fas fa-user-tie    "></i>&emsp;<?php echo "$countTeacher"; ?></span>
        <span class="text-sm">Number of Teachers</span>
      </div>
    </div>
    <!--  -->
    <div class=" space-y-1 wrapper hidden">
      <?php foreach($to_config_section as $key => $value){
        $id = $value['SECTION_ID'];
        $lv = $value['SECTION_GRADE_LV'];
        $name = $value['SECTION_NAME'];
       ?>
        <div class="p-2 bg-yellow-200 rounded-md sys-msg">
          <span class=" font-medium">WARNING:</span> No subject detected in 
          <span class=" font-medium italic"><?php echo $name; ?></span>. Try to add subject
          <a href="<?php echo "$base_url/admin/section/grade/$lv/$id/edit"; ?>" class=" text-blue-600">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
          </a>
        </div>
      <?php } ?>
      <button class="show-more hidden bg-blue-500 px-3 py-2 rounded-md font-medium hover:bg-blue-400" type="button">Show more</button>
    </div>
    <!--  -->
    <div class=" bg-gray-100 p-2 rounded-md mb-10">
      <p class=" mb-1">Actions</p>
      <div class="px-2 pb-7 pt-9 grid grid-cols-3 gap-7 border border-gray-400 rounded-md mb-3">
          <button class=" w-full h-full p-2 bg-blue-500 hover:bg-blue-400 rounded-md flex justify-start items-center space-x-2" 
          data-tooltip-target="tooltip-new-sy" 
          data-modal-toggle="modal-new-sy"
          data-tooltip-placement="top"
          type="button" >
            <span class=" text-3xl"><i class="fa-solid fa-calendar-plus"></i></span>
            <span class="">New school year</span>
          </button>
          <div id="tooltip-new-sy" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 tooltip">
          Create new school year
              <div class="tooltip-arrow" data-popper-arrow></div>
          </div>
      </div>
      <!-- LINKS -->
      <p class=" mb-1">Quick links</p>
      <div class="px-2 pb-7 pt-9 grid grid-cols-3 gap-7 border border-gray-400 rounded-md">
        <!-- Student -->
        <a href="<?php echo $base_url; ?>/admin/student" 
        class="w-full h-full flex items-center p-2 bg-blue-500 hover:bg-blue-400 rounded-md space-x-2">
          <span class=" text-3xl"><i class="fa fa-users"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Student</p>
            <span class=" text-sm">Manage IDS Students</span>
          </div>
        </a>
        <!-- Teacher -->
        <a href="<?php echo $base_url; ?>/admin/teacher" 
        class="w-full h-full flex items-center p-2 bg-blue-500 hover:bg-blue-400 rounded-md space-x-2">
          <span class=" text-3xl"><i class="fas fa-user-tie"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Teacher</p>
            <span class=" text-sm">Manage IDS Teachers</span>
          </div>
        </a>
        <!-- Execom -->
        <a href="<?php echo $base_url; ?>/admin/execom" 
        class="w-full h-full flex items-center p-2 bg-blue-500 space-x-2 hover:bg-blue-400 rounded-md">
          <span class=" text-3xl mr-3"><i class="fas fa-user-secret" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Executive Committee</p>
            <span class=" text-sm">Manage Executive Committee</span>
          </div>
        </a>        
        <!-- Section -->
        <a href="<?php echo $base_url; ?>/admin/section" class="w-full h-full flex items-center p-2 bg-blue-500 space-x-2 hover:bg-blue-400 rounded-md">
          <span class=" text-3xl mr-3"><i class="fab fa-buromobelexperte"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Section</p>
            <span class=" text-sm">Manage IDS Sections</span>
          </div>
        </a>
        <!-- Department -->
        <a href="<?php echo $base_url; ?>/admin/department" class="w-full h-full flex items-center p-2 bg-blue-500 space-x-2 hover:bg-blue-400 rounded-md">
          <span class=" text-3xl mr-3"><i class="fa fa-th-list" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Department</p>
            <span class=" text-sm">Manage IDS Departments</span>
          </div>
        </a>
        <!-- Subject -->
        <a href="<?php echo $base_url; ?>/admin/subject" class="w-full h-full flex items-center p-2 bg-blue-500 space-x-2 hover:bg-blue-400 rounded-md">
          <span class=" text-3xl mr-3"><i class="fa fa-list" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Subjects</p>
            <span class=" text-sm">Manage Subject</span>
          </div>
        </a>
        <!-- Manage Questionnaire -->
        <a href="<?php echo $base_url; ?>/admin/questionaire" class="w-full h-full flex items-center p-2 bg-blue-500 space-x-2 hover:bg-blue-400 rounded-md">
          <span class=" text-3xl mr-3"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Questionnaire</p>
            <span class=" text-sm">Manage evaluation questions</span>
          </div>
        </a>
        <!-- Activit log -->
        <a href="<?php echo $base_url; ?>/admin/activitylog" class="w-full h-full flex items-center p-2 bg-blue-500 space-x-2 hover:bg-blue-400 rounded-md">
          <span class=" text-3xl mr-3"><i class="fas fa-clipboard-list"></i></span>
          <div class="">
            <p class=" text-xl font-bold">Activity Log</p>
            <span class=" text-sm">Activity Logs</span>
          </div>
        </a>
        
        <!-- END -->
      </div>
    </div>
  </div>

<!-- Main modal -->
<div id="modal-new-sy" tabindex="-1" aria-hidden="true" class=" hidden
  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class=" flex justify-center w-full">
      <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Create new school year
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modal-new-sy">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                  </button>
              </div>
              <form id="form-new-sy">
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                  <span id="modal-new-sy-note">Note: Ignore the month as long the year(1 year = 10 months) is valid, month does not matter.</span>
                 
                  <div class="flex flex-col mb-3">
                    <label for="start_yr">From</label>
                    <input type="month" name="start_yr" id="start_yr" required>
                  </div>
                  <div class="flex flex-col mb-3">
                    <label for="end_yr">To</label>
                    <input type="month" name="end_yr" id="end_yr" class=" border border-gray-300" readonly />
                  </div>
                  <div class="flex flex-col mb-3">
                    <label for="end_yr">Semester</label>
                    <input type="number" name="semester" id="semester" min="1" value="" class=" border border-gray-300" readonly>
                  </div>
                  <div>
                    <p class="mb-0">Others</p>
                    <div class="border border-gray-300 p-3">
                      <div class="flex items-center mb-4">
                          <input id="checkbox-retain-teacher-subj" name="is_retain_teacher_subj" 
                          type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                          <label for="checkbox-retain-dept" 
                          class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Retain teacher handled subjects</label>
                      </div>
                      <div id="retain-student-sec" class="hidden items-center mb-4">
                          <input id="checkbox-retain-student-sec" name="is_retain_stud_sec" type="checkbox" 
                          value="1" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                          <label for="checkbox-retain-dept" 
                          class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Retain student in section</label>
                      </div>
                      <div class="flex items-center mb-4">
                          <input id="checkbox-retain-dept" name="is_retain_dept_chair" 
                          type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                          <label for="checkbox-retain-dept" 
                          class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Retain department chairperson</label>
                      </div>
                      <div class="flex items-center mb-4">
                          <input id="checkbox-retain-execom" name="is_retain_execom" type="checkbox" 
                          value="1" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                          <label for="checkbox-retain-dept" 
                          class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Retain executive committee</label>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-between p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="modal-new-sy" type="button" class="text-gray-500 bg-white 
                    hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border 
                    border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 
                    dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 
                    dark:focus:ring-gray-600">Close</button>

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                    dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
              </form>
          </div>
      </div>
    </div>
</div>

<div id="loading" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full 
bg-black bg-opacity-30 hidden">
  <div class=" flex justify-center w-full items-center h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto flex justify-center">
          <div class="relative rounded-lg shadow bg-white w-1/2 py-5">
            <div class="flex justify-center mb-2">
              <img width="64px" src="<?php echo "$base_url/assets/img/loading_gif.gif"?>" alt="loading...">
            </div>
            <p class="text-center">Please wait</p>
          </div>
        </div>
  </div>
</div>

