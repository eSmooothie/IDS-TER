<!-- content -->
<div class="w-full p-2">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="mb-5">
      <span class=" text-xl font-bold uppercase"><?php echo "{$teacherData['LN']}, {$teacherData['FN']}"; ?></span>
    </div>
    <div class="grid grid-cols-3 text-center gap-x-4">
      <span class="rounded-full border py-2 px-3 text-xs flex items-center justify-center border-gray-400 bg-gray-300">
        <?php echo "{$teacherData['ID']}"; ?>
      </span>
      <span class="uppercase rounded-full border py-2 px-3 text-xs flex items-center justify-center border-blue-400 bg-blue-300 hover:bg-blue-200 hover:cursor-pointer">
        <a class="" href="<?php echo "$baseUrl/admin/department/view/{$teacherData['DEPARTMENT_ID']}"; ?>">
          <?php echo ($teacherData['DEPARTMENT'])?"{$teacherData['DEPARTMENT']}":"No Department"; ?>
        </a>
      </span>
      <?php
      if($teacherData['ON_LEAVE']){
        ?>
        <span class="rounded-full border py-2 px-3 text-xs flex items-center justify-center uppercase border-red-400 bg-red-300">
          ON LEAVE
        </span>
        <?php
      }
      ?>
    </div>
  </div>
  <!-- NAV BAR -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="grid grid-cols-9">
    <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}"; ?>" class=" text-blue-700">
        <i class="fa fa-eye" aria-hidden="true"></i> View</a>
      <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class=" text-blue-700">
        <i class="fas fa-cog"></i> Edit</a>
      <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}/downloads"; ?>" class=" text-blue-700">
        <i class="fas fa-download"></i> Downloads</a>
    </div>
  </div>
  <!-- UPDATE PROFILE INFO -->
  <div class="p-3 bg-teal-200 rounded-md mb-3 <?php echo (!empty($formMessage))? "":"hidden"; ?>">
    <p class=""><?php echo (!empty($formMessage))? "{$formMessage['message']}":""; ?></p>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="font-bold text-xl mb-4"><i class="fas fa-user-edit"></i> Profile Information</p>
    <form id="profileInformation">
      <!-- ID -->
      <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
      <!-- FN -->
      <div class="grid grid-cols-4 mb-3 w-1/5">
        <label for="firstName" class="flex items-center col-span-2">First Name</label>
        <input type="text" name="fn" class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" id="firstName" placeholder="<?php echo "{$teacherData['FN']}"; ?>">
      </div>
      <!-- LN -->
      <div class="grid grid-cols-4 mb-3 w-1/5">
        <label for="lastName" class="flex items-center col-span-2">Last Name</label>
        <input type="text" name="ln" class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" id="lastName" placeholder="<?php echo "{$teacherData['LN']}"; ?>">
      </div>
      <!-- Mobile Number -->
      <div class="grid grid-cols-4 mb-3 w-1/5">
        <label for="mobileNumber" class="flex items-center col-span-2">Mobile Number</label>
        <input type="text" name="mobileNumber" class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" id="mobileNumber" placeholder="<?php echo "{$teacherData['MOBILE_NO']}"; ?>">
      </div>
      <!-- Is Lecturer -->
      <div class="mb-3">
        <input name="isLecturer" class="" type="checkbox" role="switch" id="isLecturer" <?php echo ($teacherData['IS_LECTURER'])? "checked":""; ?>>
        <label class="" for="isLecturer">Lecturer</label>
      </div>
      <!-- On Leave -->
      <div class="mb-10">
        <input name="onLeave" class="" type="checkbox" role="switch" id="onLeave" <?php echo ($teacherData['ON_LEAVE'])? "checked":""; ?>>
        <label class="" for="onLeave">On Leave</label>
      </div>
      <div class="mb-3 w-1/5 flex justify-start">
        <button type="submit" name="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2 col-span-4">Submit</button>
      </div>
    </form>
  </div>
  <!-- UPDATE DEPARTMENT -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="font-bold text-xl mb-4"><i class="fas fa-users"></i> Change Department</p>
    <!-- Change Department -->
    <form id="updateDepartment">
      <!-- ID -->
      <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
      <!-- old pass -->
      <div class="grid grid-cols-4 mb-10 w-1/5">
        <label for="" class="flex items-center col-span-2">Department</label>
        <select class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" name="updateDepartment">
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
      <div class="mb-3 w-1/5 flex justify-start">
        <button type="submit" name="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2">Submit</button>
      </div>
    </form>
  </div>

  <!-- UPDATE PASSWORD -->
  <div class="p-3 bg-teal-200 rounded-md mb-3 <?php echo (empty($passwordFormMessage))? "hidden":""; ?>">
    <p class=""><?php echo (empty($passwordFormMessage))? "":"{$passwordFormMessage['message']}"; ?></p>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="font-bold text-xl mb-4"><i class="fas fa-key"></i> Change Password</p>
    <!-- Change Password -->
    <form id="changePassword">
      <!-- ID -->
      <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
      <!-- old pass -->
      <div class="grid grid-cols-4 mb-10 w-1/5">
        <label for="oldPassword" class="flex items-center col-span-2">Old Password</label>
        <input type="password" name="oldPassword" class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" id="oldPassword">
      </div>
      <!-- new pass -->
      <div class="grid grid-cols-4 mb-10 w-1/5">
        <label for="newPassword" class="flex items-center col-span-2">New Password</label>
        <input type="password" name="newPassword" class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" id="newPassword">
      </div>
      <!-- re-enter password -->
      <div class="grid grid-cols-4 mb-10 w-1/5">
        <label for="confirmPassword" class="flex items-center col-span-2">Confirm New Password</label>
        <input type="password" name="confirmPassword" class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" id="confirmPassword">
      </div>
      <div class="mb-3 w-1/5 flex justify-start">
        <input type="submit" name="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2" value="Submit">
      </div>
    </form>
  </div>

  <!-- subject -->
  <div class="p-3 bg-teal-200 rounded-md mb-3 <?php echo (empty($subjectFormMessage))? "hidden":""; ?>">
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
        <div class="overflow-auto h-80">
          <table class="mb-3 min-w-full">
            <thead class="border bg-gray-300">
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
                <tr id="<?php echo "$id"; ?>" class="hover:bg-gray-200 text-left">
                  <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
                  <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$desc"; ?></td>
                  <td class="flex justify-center">
                    <button type="button" name="button" class=" bg-blue-300 px-4 py-3 rounded-md"
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
       
        <div class="overflow-auto h-80">
          <table class="mb-3 min-w-full">
            <thead class="border bg-gray-300">
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
                  <tr id="<?php echo "$id"; ?>" class="hover:bg-gray-200 text-left">
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
    <div class="mb-3">
    <button type="button" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2" name="button" id="submitSubject" value="<?php echo "{$teacherData['ID']}"; ?>">Submit</button>
    </div>
  </div>
</div>

<script src="<?php echo "$baseUrl/assets/js/adminTeacherEdit.js"; ?>" charset="utf-8"></script>
