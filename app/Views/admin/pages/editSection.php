<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3">
  <!-- INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="">
      <div class="space-y-3">
        <p class=" text-2xl font-bold"><?php echo "${sectionData['NAME']}"; ?></p>
        <div class="">
          <p class=" ">Grade: <?php echo $sectionData['GRADE_LV']; ?></p>
          <p class=" ">Number of students: <?php echo count($students); ?></p>
          <p class=" ">Total subjects: <?php echo count($sectionSubjects); ?></p>
        </div>
      </div>
    </div>
  </div>
  <!-- NAV -->
  <div class="px-3 py-4 bg-gray-100 rounded-md mb-3 space-x-3">
      
      <a href="<?php echo "$base_url/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}"; ?>" 
      class="px-5 py-2.5 bg-blue-300 hover:bg-blue-400 rounded-md">
        <i class="fa fa-eye mr-2" aria-hidden="true"></i></i>View
      </a>
    
    
      <a href="<?php echo "$base_url/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}/edit"; ?>"
      class="px-5 py-2.5 bg-blue-300 hover:bg-blue-400 rounded-md">
        <i class="fas fa-cog mr-2"></i>Option
      </a>
    
      <a href="#" class="px-5 py-2.5 bg-gray-300 hover:bg-gray-400 rounded-md">
        <i class="fas fa-history mr-2"></i>History
      </a>
     
  </div>
  <!-- Options -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="">
      <button type="button" name="button" class="hover:bg-blue-400 py-2 
       px-9 rounded-md  <?php echo ($selected_tab=="enroll" || empty($selected_tab))?"bg-blue-400 ring-2 ring-blue-600":"bg-blue-300";?>" onclick="changeEditContainer(1);">Edit Students</button>
      <button type="button" name="button" class=" hover:bg-blue-400 py-2 
       px-9 rounded-md bg-blue-300 <?php echo ($selected_tab=="subject")?"bg-blue-400 ring-2 ring-blue-600":"bg-blue-300";?>" onclick="changeEditContainer(2);">Edit Subjects</button>
      <button type="button" name="button" class=" hover:bg-blue-400 py-2 
       px-9 rounded-md bg-blue-300 <?php echo ($selected_tab=="profile")?"bg-blue-400 ring-2 ring-blue-600":"bg-blue-300";?>" onclick="changeEditContainer(3);">Edit Profile</button>
    </div>
    <!-- Display Err and Succ Messages -->
    <div class="hidden">
      <div class="border border-black bg-green-300 p-3 rounded-md">
        <p class=""></p>
      </div>
      <div class="border border-black bg-red-300 p-3 rounded-md">
        <p class=""></p>
      </div>
      <div id="ServerErrContainer" class="border border-black bg-gray-300 p-3 rounded-md">
        <p class="" id="ServerErrMessage"></p>
      </div>
    <?php
        if($enrolledStudent){
          ?>
          <div class="text-dark mb-3 w-100 border border-success p-2 rounded" style="background-color:#a2ff83;">
            <p class="m-0">Successfully Enrolled</p>
            <ul>
              <?php
                foreach ($enrolledStudent as $key => $value) {
                  ?>
                  <li><?php echo "$value"; ?></li>
                  <?php
                }
               ?>
            </ul>
          </div>
          <?php
        }
     ?>
    <?php
        if($invalidRows){
          ?>
          <div class="text-dark mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
            <p class="m-0">Invalid lines</p>
            <ul>
              <?php
              foreach ($invalidRows as $key => $value) {
                $lineNum = $value['key'] + 1;
                $line = $value['line'];
                ?>
                <li><?php echo "Line $lineNum: $line" ?></li>
                <?php
              }
               ?>
            </ul>
          </div>
          <?php
        }
     ?>
    <?php
        if($invalidStudentId){
           ?>
           <div class="text-dark mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
             <p class="m-0">Invalid student id (Does not exist in the database)</p>
             <ul>
               <?php
               foreach ($invalidStudentId as $key => $value) {
                 ?>
                 <li><?php echo "$value[0]" ?></li>
                 <?php
               }
                ?>
             </ul>
           </div>
           <?php
         }
     ?>
    <?php
        if($removeStudent){
            ?>
            <div class="text-dark mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
              <p class="m-0">These students already enrolled in this school year.</p>
              <ul>
                <?php
                foreach ($removeStudent as $key => $value) {
                  ?>
                  <li><?php echo "$value" ?></li>
                  <?php
                }
                 ?>
              </ul>
            </div>
            <?php
          }
     ?>
      <!-- message -->
      <?php if($enrollStudentStatus){

        if(!empty($enrollStudentStatus['enrolled'])){
          ?>
          <div class="w-100 border border-success p-2 rounded" style="background-color:#a2ff83;">
            <p class="m-0"><?php echo "Enrolled"; ?></p>
            <ul>
              <?php
              foreach ($enrollStudentStatus['enrolled'] as $key => $value) {
                ?>
                <li><?php echo $value; ?></li>
                <?php
              }
               ?>
            </ul>

          </div>

        <?php
      }
      if(!empty($enrollStudentStatus['remove'])){
        ?>
        <div class="w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
          <p class="m-0">These students already enrolled in this school year.</p>
          <ul>
            <?php
            foreach ($enrollStudentStatus['remove'] as $key => $value) {
              ?>
              <li><?php echo $value; ?></li>
              <?php
            }
             ?>
          </ul>

        </div>

        <?php
      }
    } ?>
    </div>
    <!-- Enroll new  student -->
    <div class=" pt-5 mb-10 <?php echo ($selected_tab=="enroll" || empty($selected_tab))?"":"hidden";?>" id="enrollStudentContainer">
      <p class=" text-lg font-bold mb-3 uppercase">Enroll students</p>
      <div class="">
        <!-- Bulk -->
        <form id="bulkEnroll" class="border border-gray-400 p-3 rounded-md mb-3">
          <div class="">
            <label for="" class="font-bold">Bulk</label>
          </div>
          <div class="mb-3">
            <span class="mb-4 block text-xs">Note: CSV format comma separated. Example: 2018-000,LN,FN</span>
            <input type="hidden" name="sectionId" value="<?php echo "{$sectionData['ID']}"; ?>">
            <label class="block mb-4">
              <span class="sr-only">Upload CSV file</span>
              <input type="file" class="block w-1/2 text-sm rounded-full text-black bg-gray-300
                file:mr-4 file:py-2 file:px-4 file:text-black
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-300 file:cursor-pointer
                hover:file:bg-blue-100" 
                accept=".csv" id="formFile" name="csvFile"/>
            </label>
            <button type="submit" name="button" class="hover:bg-blue-400 rounded-md px-5 bg-blue-300 p-2">Submit</button>
          </div>
        </form>
        <!-- INDIVIDUAL -->
        <div class="border border-gray-300 p-3 rounded-md">
          <div class="">
            <label for="" class="font-bold">Individual</label>
          </div>
          <div id="individual" class="grid grid-cols-2 gap-4">
            <!-- List of student -->
            <div class="p-3 rounded-md col-span-2">
              <div class="flex justify-between items-center h-16">
                <p class=" font-medium h-16">List of all students</p>
                <div class="">
                  <input type="text" name="" value="" class="rounded-md searchStudent" placeholder="Search student">
                </div>
              </div>
              <div class=" overflow-auto h-[50vh] border border-gray-400">
                <table class="mb-3 min-w-full">
                  <thead class="border bg-gray-300">
                    <tr>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">LAST NAME</th>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">FIRST NAME</th>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">ACTION</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyStudentsE" class="tbodyStudents">
                    <?php
                      foreach ($allStudents as $key => $student) {
                        $id = $student['ID'];
                        $ln = $student['LN'];
                        $fn = $student['FN'];
                        ?>
                        <tr id="<?php echo "$id"; ?>" class="hover:bg-gray-200 text-left odd:bg-white even:bg-gray-100">
                          <th scope="row" class="py-4 px-4 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
                          <td class="py-4 px-4 text-sm  whitespace-nowrap"><?php echo "$ln"; ?></td>
                          <td class="py-4 px-4 text-sm  whitespace-nowrap"><?php echo "$fn"; ?></td>
                          <td class="flex justify-center">
                            <button onclick="add(this);" class="bg-blue-300 px-4 py-3 rounded-md studentDataE" type="button" name="button" value="<?php echo "$id"; ?>">
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
            <!-- To Enroll -->
            <div class="p-3 rounded-md col-span-2">
              <p class=" font-medium h-16 texc-left">List of student to enroll</p>
              <div class="overflow-auto max-h-[50vh] border border-gray-400">
                <table class="mb-3 min-w-full">
                  <thead class="border bg-gray-300">
                    <tr>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">LAST NAME</th>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">FIRST NAME</th>
                      <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">ACTION</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyEnrollee">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="flex justify-end mt-5">
            <button type="button" class="hover:bg-blue-400 rounded-md px-5 bg-blue-300 p-2" name="button" id="enroll" value="<?php echo "${sectionData['ID']}"; ?>">Enroll</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit subject -->
    <div class=" pt-5 mb-10 <?php echo ($selected_tab=="subject")?"":"hidden";?>" id="editSubjectContainer">
      <p class=" text-lg font-bold mb-3 uppercase">Setup subjects</p>
      <div class="">
        
        <div class="space-y-3">
          <!-- ADD SUBJECT -->
          <div class="">
            <div class="flex justify-between items-center h-16">
              <p class="font-medium">List of all subjects</p>
              <div class="">
                <input type="text" name="" value="" class="rounded-md searchSubject" placeholder="Search">
              </div>
            </div>
            <div class=" overflow-auto max-h-[50vh] border border-gray-400">
              <table class="mb-3 min-w-full border border-gray-300">
                <thead class="border bg-gray-300">
                  <tr>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Subject</th>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Teacher</th>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
                  </tr>
                </thead>
                <tbody class="tbodySubjects" id="listOfSubjectsTbody">
                  <?php
                    foreach ($teachers as $key => $teacherData) {
                      $teacherId = $teacherData['TEACHER_ID'];
                      $teacherFn = $teacherData['TEACHER_FN'];
                      $teacherLn = $teacherData['TEACHER_LN'];
                      $subjectID = $teacherData['SUBJECT_ID'];
                      $subjectDESC = $teacherData['SUBJECT_DESCRIPTION'];
                      ?>
                      <tr id="<?php echo "$teacherId"; ?>" class="bg-white border-b hover:bg-gray-200 odd:bg-white even:bg-gray-100 teacherRow">
                          <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$subjectDESC"; ?></th>
                          <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$teacherLn, $teacherFn"; ?></td>
                          <td class="flex justify-center">
                            <button id="<?php echo "$subjectID"; ?>" type="button" name="button" class="bg-blue-300 px-4 py-3 rounded-md"
                              onclick="appendSubject(this);">
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
          <div class="w-full">
            <p class="bg-teal-100 rounded-md px-2 py-1 w-full hidden text-center  mb-3" id="SystemMessageSubject">Added subject</p>
          </div>
          <!-- CURRENT SUBJECT -->
          <div class="">
            <div class="text-left py-3 h-16">
              <p class="font-medium">List of current subjects</p>
            </div>
            <div class=" overflow-auto max-h-[80vh] border border-gray-400">
              <table class="mb-3 min-w-full border border-gray-300">
                <thead class="border bg-gray-300">
                  <tr>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Subject</th>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Teacher</th>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
                  </tr>
                </thead>
                <tbody id="sectionSubjectTbody">
                  <?php
                  foreach ($sectionSubjects as $key => $data) {
                    $teacherID = $data['TEACHER_ID'];
                    $teacherFN = $data['TEACHER_FN'];
                    $teacherLN = $data['TEACHER_LN'];
                    $subjectID = $data['SUBJECT_ID'];
                    $subjectDESC = $data['SUBJECT_DESCRIPTION'];
                    ?>
                    <tr id="<?php echo $teacherID; ?>" class="bg-white border-b hover:bg-gray-200 odd:bg-white even:bg-gray-100">
                      <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo $subjectDESC; ?></th>
                      <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo $teacherLN.", ".$teacherFN; ?></td>
                      <td class="flex justify-center">
                        <button id="<?php echo $subjectID; ?>" type="button" name="button" class="bg-red-300 px-4 py-3 rounded-md"
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
        <!-- BUTTON -->
        <div class="">
            
            <button id="updateSectionSubject" 
            type="button" name="button" class="hover:bg-blue-400 py-2 px-9 rounded-md bg-blue-300" 
            value="<?php echo "${sectionData['ID']}"; ?>">Update</button>
          </div>
      </div>
    </div>

    <!-- Edit Section -->
    <div class=" pt-5 mb-10 <?php echo ($selected_tab=="profile")?"":"hidden";?>" id="editSectionContainer">
      <p class=" text-lg font-bold mb-3 uppercase">Edit profile</p>
      <!-- MODIFY PROFILE -->
      <div class="border border-gray-400 rounded-md p-3 w-full mb-3">
      <p class=" font-medium">Update Section</p>
        <form class="w-full space-y-4" id="editSectionForm">
          <input type="hidden" name="sectionId" value="<?php echo $sectionData['ID']; ?>">
          <!-- name -->
          <div class="">
            <label for="sectionName" class="block">Change Name</label>
            <input name="sectionName" type="text" class="min-w-full" 
            id="sectionName" placeholder="<?php echo $sectionData['NAME']; ?>">
          </div>
          <!-- grade lv -->
          <div class="">
            <label for="gradeLevel" class="block">Change Grade Level</label>
            <select class="min-w-full" aria-label="Grade Level" name="gradeLevel">
              <option value="" selected>Select Grade Level</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
          </div>
          <!-- has rni -->
          <div class="flex items-center space-x-4">
            <input name="hasRNI" class="col-span-2" type="checkbox" id="hasRNI" <?php echo ($sectionData['HAS_RNI'])? "checked":"";  ?>>
            <label class="" for="hasRNI">Has research and immersion</label>
          </div>
          <div class="mt-2">
            <button type="submit" name="button" class="hover:bg-blue-400 py-2 
           px-9 rounded-md bg-blue-300">Update</button>
          </div>
        </form>
      </div>
      <!-- DELETE SECTION -->
      <div class="border border-gray-400 rounded-md p-3 w-full space-y-2">
        <p class=" font-medium">Delete Section</p>
        <p class="text-black mb-3"><span class=" font-medium text-red-600">Warning: </span> This will deactivate the section which no longer can be seen or interact with.</p>
        <p>Please type <span class="text-red-500 font-bold text-lg"><?php echo $sectionData['NAME']; ?></span> to confirm</p>
        <form  class="" id="removeSectionForm">
          <div class="mb-4">
            <input type="hidden" name="sectionID" value="<?php echo $sectionData['ID']; ?>">
            <input required name="removeSectionName" type="text" class="rounded-md w-full invalid:border-red-500" id="removeSectionName" aria-describedby="sectionName">
            <span id="feedback" class="text-xs text-red-600 hidden">
              Does not match.
            </span>
          </div>
          <div class="">
            <button type="submit" class="hover:bg-red-400 py-2 
           px-9 rounded-md bg-red-300">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>


<div id="confirmation-enrollee-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    Confirmation
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white confirmation-enrollment-modal-close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Are you sure do you want to enroll the following students?
                </p>
                <ul id="list-of-students-to-enroll" class="list-disc pl-6">
                </ul>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600 justify-between">
                <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 
                focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 
                text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 
                dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600  
                confirmation-enrollment-modal-close">No, cancel</button>
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 
                text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 
                confirmation-enrollment-modal-accept">Yes, I'm sure</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo "$base_url/assets/js/adminSection.js"; ?>" charset="utf-8"></script>
