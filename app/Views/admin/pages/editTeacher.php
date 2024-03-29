<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md">
    <div class="mb-5">
      <span class=" text-xl font-bold uppercase"><?php echo "{$teacherData['LN']}, {$teacherData['FN']}"; ?></span>
    </div>
    <div class="grid grid-cols-3 text-center gap-x-4">
      <?php
      if($teacherData['ON_LEAVE']){
        ?>
        <span class="rounded-full border py-2 px-3 text-sm flex items-center justify-center uppercase border-red-400 bg-red-300">
          On leave
        </span>
        <?php
      }
       ?>
    </div>
  </div>
  <!-- NAV BAR -->
  <div class="px-3 py-5 bg-gray-100 rounded-md mb-3">
    <div class="space-x-4">
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}"; ?>" class=" bg-blue-300  hover:bg-blue-400
       border px-3 py-2 rounded-md text-black space-x-2 ">
        <i class="fa fa-eye"></i>
        <span>View</span>
      </a>
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class=" bg-blue-300  hover:bg-blue-400
       border px-3 py-2 rounded-md text-black space-x-2 ">
        <i class="fas fa-cog"></i>
        <span>Edit</span>
      </a>
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}/downloads"; ?>" class=" bg-blue-300  hover:bg-blue-400
       border px-3 py-2 rounded-md text-black space-x-2 ">
        <i class="fas fa-download"></i>
        <span>Downloads</span>
      </a>
    </div>
  </div>
  <!-- UPDATE PROFILE INFO -->
  <div class="p-3 bg-teal-200 rounded-md <?php echo (!empty($formMessage))? "":"hidden"; ?>">
    <p class=""><?php echo (!empty($formMessage))? "{$formMessage['message']}":""; ?></p>
  </div>
  <div class="p-3 bg-gray-100 rounded-md">
    <p class="font-bold text-xl mb-4"><i class="fas fa-user-edit"></i> Profile Information</p>
    <form id="profileInformation" class="space-y-3">
      <!-- ID -->
      <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
      <!-- FN -->
      <div class="">
        <label for="firstName" class="flex items-center col-span-2">First Name</label>
        <input type="text" name="fn" class="w-1/2 border border-black rounded-md px-3 py-1" id="firstName" placeholder="<?php echo "{$teacherData['FN']}"; ?>">
      </div>
      <!-- LN -->
      <div class="">
        <label for="lastName" class="flex items-center col-span-2">Last Name</label>
        <input type="text" name="ln" class="w-1/2 border border-black rounded-md px-3 py-1" id="lastName" placeholder="<?php echo "{$teacherData['LN']}"; ?>">
      </div>
      <!-- Mobile Number -->
      <div class="">
        <label for="mobileNumber" class="flex items-center col-span-2">Mobile Number</label>
        <input type="text" name="mobileNumber" class="w-1/2 border border-black rounded-md px-3 py-1" id="mobileNumber" placeholder="<?php echo "{$teacherData['MOBILE_NO']}"; ?>">
      </div>
      <!-- Is Lecturer -->
      <div class="">
        <input name="isLecturer" class="" type="checkbox" role="switch" id="isLecturer" <?php echo ($teacherData['IS_LECTURER'])? "checked":""; ?>>
        <label class="" for="isLecturer">Lecturer</label>
      </div>
      <!-- On Leave -->
      <div class="mb-10">
        <input name="onLeave" class="" type="checkbox" role="switch" id="onLeave" <?php echo ($teacherData['ON_LEAVE'])? "checked":""; ?>>
        <label class="" for="onLeave">On Leave</label>
      </div>
      <div class="mb-3 flex justify-end">
        <button type="submit" name="submit" class="hover:bg-blue-400 rounded-md px-5 hover:text-black
        bg-blue-300 p-2 col-span-4 font-medium text-black">Submit</button>
      </div>
    </form>
  </div>
  <!-- UPDATE DEPARTMENT -->
  <div class="p-3 bg-gray-100 rounded-md">
    <p class="font-bold text-xl mb-4"><i class="fas fa-users"></i> Change Department</p>
    <!-- Change Department -->
    <form id="updateDepartment">
      <!-- ID -->
      <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
      <div class="mb-10">
        <label for="" class="flex items-center col-span-2">Department</label>
        <select class="w-1/2 border border-black rounded-md px-3 py-1" name="updateDepartment">
          <?php
            foreach ($departments as $key => $value) {
              $deptId = $value['ID'];
              $deptName = $value['NAME'];
              ?>
              <option value="<?php echo "$deptId"; ?>" <?php echo ($teacherData['DEPARTMENT_ID'] == $deptId)? "selected":""; ?>><?php echo "$deptName"; ?></option>
              <?php
            }
          ?>
        </select>
      </div>
      <div class="flex justify-end">
        <button type="submit" name="submit" class="hover:bg-blue-400 rounded-md px-5 hover:text-black
        bg-blue-300 p-2 col-span-4 font-medium text-black">Submit</button>
      </div>
    </form>
  </div>

  <!-- UPDATE PASSWORD -->
  <div class="p-3 bg-teal-200 rounded-md <?php echo (empty($passwordFormMessage))? "hidden":""; ?>">
    <p class=""><?php echo (empty($passwordFormMessage))? "":"{$passwordFormMessage['message']}"; ?></p>
  </div>
  <div class="p-3 bg-gray-100 rounded-md">
    <p class="font-bold text-xl mb-4"><i class="fas fa-key"></i> Change Password</p>
    <!-- Change Password -->
    <form id="changePassword" class="space-y-3">
      <!-- ID -->
      <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
      <!-- old pass -->
      <div class="">
        <label for="oldPassword" class="flex items-center col-span-2">Old Password</label>
        <input type="password" name="oldPassword" class=" w-1/2 border border-black rounded-md px-3 py-1" id="oldPassword">
      </div>
      <!-- new pass -->
      <div class="">
        <label for="newPassword" class="flex items-center col-span-2">New Password</label>
        <input type="password" name="newPassword" class=" w-1/2 border border-black rounded-md px-3 py-1" id="newPassword">
      </div>
      <!-- re-enter password -->
      <div class="">
        <label for="confirmPassword" class="flex items-center col-span-2">Confirm New Password</label>
        <input type="password" name="confirmPassword" class=" w-1/2 border border-black rounded-md px-3 py-1" id="confirmPassword">
      </div>
      <div class="mb-3 flex justify-end space-x-3">
        <button type="button" id="reset-password" class="hover:bg-red-500 bg-red-400 px-5 p-2 font-medium text-black rounded-md"
        data-modal-toggle="reset-password-confirmation-modal">
          Reset Password
        </button>
        <button type="submit" name="submit" class="hover:bg-blue-400 rounded-md px-5 hover:text-black
          bg-blue-300 p-2 col-span-4 font-medium text-black">Submit</button>
      </div>
    </form>
  </div>

  <!-- subject -->
  <div class="p-3 bg-blue-200 rounded-md mb-3 <?php echo (empty($subjectFormMessage))? "hidden":""; ?>">
    <p class=""><?php echo (empty($subjectFormMessage))? "":"{$subjectFormMessage['message']}"; ?></p>
  </div>
  <?php
        $display = "";
        if(empty($currSySubject)){
          $display = "<b>Note:</b> No assigned subject ever since.";
        }else if($currSySubject['ID'] != $currSY['ID']){
          $display = "<b>Note:</b> The current subject/s are for school year {$currSySubject['SY']}:{$currSySubject['SEMESTER']}."
          ." If he/she still teaches the same for school year {$currSY['SY']}:{$currSY['SEMESTER']} click <b>\"SUBMIT\"</b>"
          ." otherwise edit it for current school year.";
        }
  ?>
  <div class="p-3 bg-gray-100 rounded-md mb-10">
    <div class="">
      <p class="font-bold text-xl mb-4"><i class="fas fa-edit"></i> Subject Handles</p>
      <p class="text-xs text-teal-600 mb-3"><?php echo $display; ?></p>
    </div>
    <div class="grid grid-cols-2 mb-5 gap-x-5">
      <!-- table for all subject -->
      <div class="" >
        <div class="flex justify-between items-center">
          <p class="font-bold text-base mb-4">List of All Subjects</p>
          <input type="text" id="searchSubject" class="" placeholder="Search">
        </div>
        <div class="overflow-x-hidden overflow-y-auto h-80 border border-gray-400">
          <table class="mb-3 min-w-full " >
            <thead class="bg-gray-300">
              <tr>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Description</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
              </tr>
            </thead>
            <tbody id="listOfSubject">
              <?php
              foreach ($subjects as $key => $value) {
                $id = $value['ID'];
                $desc = $value['DESCRIPTION'];
                ?>
                <tr id="<?php echo "$id"; ?>" class="hover:bg-gray-200 text-left odd:bg-white even:bg-gray-100">
                  <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
                  <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$desc"; ?></td>
                  <td class="flex justify-center">
                    <button type="button" name="button" class=" bg-blue-300 px-4 py-3 rounded-md hover:bg-blue-400"
                      onclick="addSubject(this);">
                      <i class="fas fa-plus"></i>
                    </button>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>

      </div>
      
      <!-- current teacher subject -->
      <div class="">
        <p class="font-bold text-base mb-4">My Subjects</p>
       
        <div class="overflow-x-hidden overflow-y-auto h-80 border border-gray-400">
          <table class="mb-3 min-w-full ">
            <thead class="bg-gray-300">
              <tr>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Description</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
              </tr>
            </thead>
            <tbody id="mySubjects">
              <?php
                foreach ($teacherSubjects as $key => $value) {
                  $id = $value['ID'];
                  $desc = $value['DESCRIPTION'];
                  ?>
                  <tr id="<?php echo "$id"; ?>" class="hover:bg-gray-200 text-left odd:bg-white even:bg-gray-100">
                    <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
                    <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$desc"; ?></td>
                    <td class="flex justify-center">
                      <button type="button" name="button" class="bg-red-400 px-4 py-3 rounded-md"
                        onclick="removeSubject(this);">
                        <i class="fas fa-times"></i>
                      </button>
                    </td>
                  </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div class="flex justify-end">
      <button type="button" class="hover:bg-blue-400 rounded-md px-5 hover:text-black
          bg-blue-300 p-2 col-span-4 font-medium text-black" 
      name="button" id="submitSubject" value="<?php echo "{$teacherData['ID']}"; ?>">Submit</button>
    </div>
  </div>
</div>

<div id="reset-password-confirmation-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="reset-password-confirmation-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to reset the password to default( 
                  <span class=" text-black font-bold">ids_ter_<?php echo $teacherData['ID']; ?></span>)?</h3>
                <button data-modal-toggle="reset-password-confirmation-modal" type="button" data-teacher-id="<?php echo $teacherData['ID']; ?>" id="confirm-reset" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes, I'm sure
                </button>
                <button data-modal-toggle="reset-password-confirmation-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminTeacherEdit.js"; ?>" charset="utf-8"></script>
