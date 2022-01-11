<!-- content -->
<div class="w-full p-2">
  <!-- nav -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <button class="block text-black bg-blue-300 hover:bg-blue-200 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" 
     type="button" data-modal-toggle="addTeacherModal">
      <i class="fas fa-plus"></i> Add Teacher
    </button>
  </div>
  <!-- Teacher table -->
  <div class="p-3 bg-gray-100 rounded-md mb-10">
    <div class="mb-4">
      <label class="relative block">
          <span class="sr-only">Search</span>
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <i class="fas fa-search"></i>
          </span>
          <input class="placeholder:italic placeholder:text-gray-400 block 
          bg-white w-full border border-gray-300 
          rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none 
          focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm searchTeacher
          " placeholder="Search for teacher..." type="text" name="search"/>
        </label>
    </div>
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr class="">
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Last Name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">First Name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Department</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Is Lecturuer</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Status</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="tBodyTeacher">
        <?php
          foreach ($teacherData as $key => $value) {
            $id = $value['ID'];
            $ln = $value['LN'];
            $fn = $value['FN'];
            $isLecturer = $value['IS_LECTURER'];
            $onLeave = $value['ON_LEAVE'];
            $department = $value['DEPARTMENT_NAME'];
            ?>
            <tr class="bg-white border-b hover:bg-gray-200 <?php echo ($onLeave)? "text-red-500":"text-gray-500"; ?>">
              <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$ln"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$fn"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$department"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo ($isLecturer)? "Yes":"No"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo ($onLeave)? "ON LEAVE":""; ?></td>
              <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                <a href="<?php echo "$baseUrl/admin/teacher/view/$id"; ?>" class="text-blue-600 hover:text-blue-900">View</a>
              </td>
            </tr>
            <?php
          }
         ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Main modal -->
<div id="addTeacherModal" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
    <div class="relative px-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    Teacher
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addTeacherModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <form class="" id="addNewTeacher">
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                <div class="mb-3">
                  <!-- ID -->
                  <div class="mb-3 grid grid-cols-3">
                    <label for="" class="">ID<span class="text-red-500">*</span></label>
                    <div class="w-full col-span-2">
                      <input name="id" type="text" class="w-full rounded-md" id="teacherId" placeholder="2021-XXXX" required>
                    </div>
                  </div>
                  <!-- FN -->
                  <div class="mb-3 grid grid-cols-3">
                    <label for="" class="">First Name<span class="text-red-500">*</span></label>
                    <div class="col-span-2">
                      <input name="fn" type="text" class="w-full rounded-md" id="teacherFn" placeholder="First Name" required>
                    </div>
                  </div>
                  <!-- LN -->
                  <div class="mb-3 grid grid-cols-3">
                    <label for="" class="">Last Name<span class="text-red-500">*</span></label>
                    <div class="col-span-2">
                      <input name="ln" type="text" class="w-full rounded-md" id="teacherLn" placeholder="Last Name" required>
                    </div>
                  </div>
                  <!-- Password -->
                  <div class="mb-3 grid grid-cols-3">
                    <label for="" class="">Password<span class="text-red-500">*</span></label>
                    <div class="col-span-2">
                      <input name="password" type="password" class="w-full rounded-md" id="teacherPassword" placeholder="Password" required>
                    </div>
                  </div>
                  <!-- Mobile Number -->
                  <div class="mb-3 grid grid-cols-3">
                    <label for="" class="">Mobile Number</label>
                    <div class="col-span-2">
                      <input name="mobileNumber" type="text" class="w-full rounded-md" id="teacherCellNo" placeholder="09xxxxxxxxx">
                    </div>
                  </div>
                  <!-- Department -->
                  <div class="mb-5 grid grid-cols-3">
                    <label for="" class="">Department<span class="text-red-500">*</span></label>
                    <div class="col-span-2">
                      <select class="form-select rounded-md" name="department" required>
                        <option value="" selected>Select a department</option>
                        <?php
                        foreach ($departmentData as $key => $value) {
                          $id = $value['ID'];
                          $name = $value['NAME'];
                          ?>
                          <option value="<?php echo "$id"; ?>"><?php echo "$name"; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- Is Lecturer -->
                  <div class="mb-3">
                    <label for="toggle-example" class="flex relative items-center mb-4 cursor-pointer">
                      <input type="checkbox" id="toggle-example" class="sr-only" name="isLecturer">
                      <div class="w-11 h-6 bg-gray-200 rounded-full border border-gray-200 toggle-bg dark:bg-gray-700 dark:border-gray-600"></div>
                      <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Is a Lecturer?</span>
                    </label>
                  </div>
                  <!-- message -->
                  <div class="mb-3 d-none" id="errContainer">
                    <div class="">
                      <p id="errMessage" class="m-0"></p>
                    </div>
                  </div>
                </div>
                <div class="">
                  <p class="text-end"><small>Field with <span class="text-red-500">*</span> is required.</small></p>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                  <button data-modal-toggle="addTeacherModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Close</button>
                  <button data-modal-toggle="addTeacherModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminTeacher.js"; ?>" charset="utf-8"></script>
