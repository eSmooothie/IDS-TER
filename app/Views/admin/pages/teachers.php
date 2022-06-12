<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3">
  <!-- nav -->
  <div class="p-3 bg-gray-100 rounded-md">
    <button class="block text-black bg-blue-500 hover:bg-blue-400 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" 
     type="button" data-modal-toggle="add_teacher_modal">
      <i class="fas fa-plus"></i> Add Teacher
    </button>
  </div>
  <!-- Teacher table -->
  <div class="p-3 bg-gray-100 rounded-md mb-10 space-y-4">
    <div class=" space-y-3">
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

        <div class="space-x-2 text-sm">
          <p>Legends</p>
          <div class="grid grid-cols-3">
            <div class="flex items-center space-x-2 text-xs"> 
              <div class=" bg-red-400 w-3 h-3 border border-red-600"></div>
              <p> Teacher is on Leave</p>
            </div>
          </div>
        </div>
    </div>

    <table class="mb-5 min-w-full">
      <thead class="border bg-gray-300">
        <tr class="">
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Last Name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">First Name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Department</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Is Lecturuer</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="tBodyTeacher">
        <?php
          foreach ($teacher_data as $key => $value) {
            $id = $value['ID'];
            $ln = $value['LN'];
            $fn = $value['FN'];
            $is_lecturer = $value['IS_LECTURER'];
            $on_leave = $value['ON_LEAVE'];
            $department = $value['DEPARTMENT_NAME'];
            ?>
            <tr class="border-b  hover:cursor-default<?php echo ($on_leave)? "text-red-500 bg-red-100 hover:bg-red-200":"text-gray-500 odd:bg-white even:bg-gray-100 hover:bg-gray-200"; ?>">
              <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$ln"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$fn"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$department"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo ($is_lecturer)? "Yes":"No"; ?></td>
              <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                <a href="<?php echo "$base_url/admin/teacher/view/$id"; ?>" class="text-blue-600 hover:text-blue-900">View</a>
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
<div id="add_teacher_modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed 
top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
  <div class="flex justify-center w-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow">
              <!-- Modal header -->
              <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                      Add New Teacher
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="add_teacher_modal">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                  </button>
              </div>
              <form class="" id="addNewTeacher"> 
                <!-- Modal body -->
                <div class="p-6 space-y-3">
                  <div class="">
                    <p class="text-end"><small>Field with <span class="text-red-500">*</span> is required.</small></p>
                  </div>
                  <div class="space-y-3">
                    <!-- ID -->
                    <div class="space-y-2">
                      <label for="" class="">ID<span class="text-red-500">*</span></label>
                      <div class="w-full col-span-2">
                        <input name="id" type="text" class="w-full rounded-md" id="teacherId" required>
                        <span class="text-sm">Example: 2018-1022</span>
                      </div>
                    </div>
                    <!-- FN -->
                    <div class="space-y-2">
                      <label for="" class="">First Name<span class="text-red-500">*</span></label>
                      <div class="col-span-2">
                        <input name="fn" type="text" class="w-full rounded-md" id="teacherFn" required>
                        <span class="text-sm">Example: Juan</span>
                      </div>
                    </div>
                    <!-- LN -->
                    <div class="space-y-2">
                      <label for="" class="">Last Name<span class="text-red-500">*</span></label>
                      <div class="col-span-2">
                        <input name="ln" type="text" class="w-full rounded-md" id="teacherLn" required>
                        <span class="text-sm">Example: Dela Cruz</span>
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="space-y-2">
                      <label for="" class="">Password<span class="text-red-500">*</span></label>
                      <div class="col-span-2">
                        <input name="password" type="password" class="w-full rounded-md" id="teacherPassword" required>
                        <span class="text-sm">Initial Password</span>
                      </div>
                    </div>
                    <!-- Mobile Number -->
                    <div class="space-y-2">
                      <label for="" class="">Mobile Number</label>
                      <div class="col-span-2">
                        <input name="mobile_number" type="text" class="w-full rounded-md" id="teacherCellNo">
                        <span class="text-sm">Example: 09123456789</span>
                      </div>
                    </div>
                    <!-- Department -->
                    <div class="space-y-2">
                      <label for="" class="">Department<span class="text-red-500">*</span></label>
                      <div class="w-full">
                        <select class="form-select rounded-md w-full" name="department" required>
                          <option value="" selected>Select a department</option>
                          <?php
                          foreach ($department_data as $key => $value) {
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
                    <div class="space-y-2">
                      <p class="text-sm font-medium text-gray-900 ">Is Lecturer?<span class="text-red-500">*</span></p>
                      <div class="ml-3">
                        <input id="radio-is-lecturer-yes" type="radio" value="1" 
                        name="is_lecturer" 
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 " required>
                        <label for="radio-is-lecturer-yes" class="ml-2 text-sm font-medium text-gray-900 ">Yes</label>
                      </div>
                      <div class="ml-3">
                        <input id="radio-is-lecturer-no" type="radio" value="0" 
                        name="is_lecturer" 
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 " required>
                        <label for="radio-is-lecturer-no" class="ml-2 text-sm font-medium text-gray-900 ">No</label>
                      </div>
                    </div>
                    <!-- message -->
                    <div class="mb-3 d-none" id="errContainer">
                      <div class="">
                        <p id="errMessage" class="m-0 text-red-500"></p>
                      </div>
                    </div>
                  </div>
                  <div class="">
                    <p class="text-end"><small>Field with <span class="text-red-500">*</span> is required.</small></p>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-between p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="add_teacher_modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Close</button>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
              </form>
          </div>
      </div>
  </div>

</div>

<script src="<?php echo "$base_url/assets/js/adminTeacher.js"; ?>" charset="utf-8"></script>
