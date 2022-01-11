<!-- content -->
<div class="w-full p-2">
  <!-- NAV -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="">
      <div class="">
        <p class=" text-2xl font-bold"><?php echo "${sectionData['NAME']}"; ?></p>
        <p class=" text-xs"><?php echo "(${schoolyear['SY']}:${schoolyear['SEMESTER']})"; ?></p>
        <span class=" grid grid-cols-8 gap-x-7 mt-5">
          <span class=" bg-gray-400 rounded-full text-center py-1">Grade <?php echo $sectionData['GRADE_LV']; ?></span>
          <span class=" bg-gray-400 rounded-full text-center py-1"><?php echo count($students); ?> Students</span>
          <span class=" bg-gray-400 rounded-full text-center py-1"><?php echo count($sectionSubjects); ?> Subjects</span>
          <span class=" bg-blue-400 rounded-full text-center py-1">
            <a href="<?php echo "$baseUrl/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}"; ?>">
              <i class="fa fa-eye mr-2" aria-hidden="true"></i></i>View
            </a>
          </span>
          <span class=" bg-blue-400 rounded-full text-center py-1">
            <a href="<?php echo "$baseUrl/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}/edit"; ?>">
              <i class="fas fa-cog mr-2"></i>Option
            </a>
          </span>
          <!-- TODO: ADD HISTORY PAGE -->
          <span class=" bg-gray-400 rounded-full text-center py-1">
            <a href="#">
              <i class="fas fa-history mr-2"></i>History
            </a>
        </span>
        </span>
      </div>
    </div>
  </div>
  <!-- Options -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="grid grid-cols-6 gap-5">
      <button type="button" name="button" class="hover:bg-blue-400 pt-2 pb-2 
        pl-9 pr-9 rounded-md bg-blue-300" onclick="changeEditContainer(1);">Students</button>
      <button type="button" name="button" class=" hover:bg-blue-400 pt-2 pb-2 
        pl-9 pr-9 rounded-md bg-blue-300" onclick="changeEditContainer(2);">Subjects</button>
      <button type="button" name="button" class=" hover:bg-blue-400 pt-2 pb-2 
        pl-9 pr-9 rounded-md bg-blue-300" onclick="changeEditContainer(3);">Profile</button>
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
    <div class=" pt-5 mb-10" id="enrollStudentContainer">
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
              <input type="file" class="block w-1/5 text-sm rounded-full text-black bg-gray-300
                file:mr-4 file:py-2 file:px-4 file:text-black
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-300 file:cursor-pointer
                hover:file:bg-blue-100" 
                accept=".csv" id="formFile" name="csvFile"/>
            </label>
            <button type="submit" name="button" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2">Submit</button>
          </div>
        </form>
        <!-- INDIVIDUAL -->
        <div class="border border-gray-300 p-3 rounded-md">
          <div class="">
            <label for="" class="font-bold">Individual</label>
          </div>
          <div id="individual" class="grid grid-cols-2 gap-4">
            <!-- List of student -->
            <div class="border border-gray-300 p-3 rounded-md">
              <div class="flex justify-between items-center h-16">
                <p class=""></p>
                <div class="">
                  <input type="text" name="" value="" class="form-control searchStudent" placeholder="Search">
                </div>
              </div>
              <div class=" overflow-auto h-80">
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
                        <tr id="<?php echo "$id"; ?>" class="hover:bg-gray-200 text-left">
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
            <div class="border border-gray-300 p-3 rounded-md">
              <p class=" font-bold h-16 flex items-center justify-center">To Enroll</p>
              <div class="overflow-auto"  style="max-height:50vh;">
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
            <button type="button" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2" name="button" id="enroll" value="<?php echo "${sectionData['ID']}"; ?>">Enroll</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit subject -->
    <div class="hidden pt-5 mb-10" id="editSubjectContainer">
      <p class=" text-lg font-bold mb-3 uppercase">Setup subjects</p>
      <div class="">
        
        <div class="grid grid-cols-2 gap-5">
          <!-- CURRENT SUBJECT -->
          <div class="">
            <div class="text-center py-3 h-16">
              <p class="font-bold">Current Subjects</p>
            </div>
            <div class=" overflow-auto max-h-80">
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
                    <tr id="<?php echo $teacherID; ?>" class="bg-white border-b hover:bg-gray-200 ">
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
          <!-- ADD SUBJECT -->
          <div class="">
            <div class="flex justify-between items-center h-16">
              <p></p>
              <p class="font-bold">Add Subjects</p>
              <div class="">
                <input type="text" name="" value="" class="searchSubject" placeholder="Search">
              </div>
            </div>
            <div class=" overflow-auto max-h-80">
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
                      <tr id="<?php echo "$teacherId"; ?>" class="bg-white border-b hover:bg-gray-200 teacherRow">
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
        </div>
        <!-- BUTTON -->
        <div class="">
            <p class="bg-teal-200 rounded-full px-2 py-1 w-1/5 text-center hidden mb-3" id="SystemMessageSubject"></p>
            <button id="updateSectionSubject" 
            type="button" name="button" class="hover:bg-blue-400 py-2 px-9 rounded-md bg-blue-300" 
            value="<?php echo "${sectionData['ID']}"; ?>">Update</button>
          </div>
      </div>
    </div>

    <!-- Edit Section -->
    <div class="hidden pt-5 mb-10" id="editSectionContainer">
      <p class=" text-lg font-bold mb-3 uppercase">Edit profile</p>
      <!-- MODIFY PROFILE -->
      <div class="border border-gray-400 rounded-md p-3 w-1/2 mb-3">
        <form class="w-full" id="editSectionForm">
          <input type="hidden" name="sectionId" value="<?php echo $sectionData['ID']; ?>">
          <!-- name -->
          <div class="grid grid-cols-3 mb-3">
            <label for="sectionName" class="">Change Name</label>
            <input name="sectionName" type="text" class="col-span-2" 
            id="sectionName" placeholder="<?php echo $sectionData['NAME']; ?>">
          </div>
          <!-- grade lv -->
          <div class="grid grid-cols-3 mb-3">
            <label for="gradeLevel" class="">Change Grade Level</label>
            <select class="col-span-2 min-w-full" aria-label="Grade Level" name="gradeLevel">
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
          <div class="grid grid-cols-3 mb-3">
            <label class="" for="hasRNI">Has research and immersion</label>
            <input name="hasRNI" class="col-span-2" type="checkbox" id="hasRNI" <?php echo ($sectionData['HAS_RNI'])? "checked":"";  ?>>
          </div>
          <div class="mt-2">
            <button type="submit" name="button" class="hover:bg-blue-400 pt-2 pb-2 
            pl-9 pr-9 rounded-md bg-blue-300">Update</button>
          </div>
        </form>
      </div>
      <!-- DELETE SECTION -->
      <div class="border border-gray-400 rounded-md p-3 w-1/2">
        <p class=" font-bold">Delete Section</p>
        <p class="text-red-500 mb-3"><span class=" font-bold text-black">Warning: </span> This will deactivate the section which no longer can be seen or interact with.</p>
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
            <button type="submit" class="hover:bg-red-400 pt-2 pb-2 
            pl-9 pr-9 rounded-md bg-red-300">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo "$baseUrl/assets/js/adminSection.js"; ?>" charset="utf-8"></script>
