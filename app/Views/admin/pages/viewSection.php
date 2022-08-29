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
          <p class=" ">Total subjects: <?php echo count($subjects); ?></p>
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
  <!-- SECTION CONTENT -->
  <div class="p-3 bg-gray-100 rounded-md mb-10 grid grid-cols-2 gap-5">
    <!-- Students -->
    <div class="border rounded-md p-3">
      <p class=" text-lg font-bold text-center mb-3">Students</p>
      <table class="mb-3 min-w-full">
        <thead class="border bg-gray-300">
          <tr>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Name</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $key => $student) {
            $id = $student['STUDENT_ID'];
            $fn = $student['STUDENT_FN'];
            $ln = $student['STUDENT_LN'];
            $status = $student['STATUS'];
            $isActive = $student['IS_ACTIVE']
            ?>
            <tr class="bg-white border-b hover:bg-gray-200">
              <th scope="row" class=" text-left py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                <?php echo "$id"; ?></th>
              <td class="py-4 px-6 text-sm font-medium whitespace-nowrap">
                <a href="<?php echo ($isActive)? "$base_url/admin/student/view/$id":"#"; ?>"
                class="<?php echo ($isActive)? "text-blue-600 hover:text-blue-900":"text-gray-900"; ?>"><?php echo "$ln, $fn"; ?></a></td>
              <td class="py-4 px-6 text-sm font-medium whitespace-nowrap text-center <?php echo ($status)? "bg-green-300":"bg-gray-300"; ?>">
                <?php echo ($status)? "CLEARED":"NOT CLEARED"; ?>
              </td>
            </tr>
            <?php
          } ?>

        </tbody>
      </table>
    </div>
    <!-- Subject Teacher -->
    <div class="border rounded-md p-3">
      <p class=" text-lg font-bold text-center mb-3">Subjects</p>
      <table class="mb-3 min-w-full">
        <thead class="border bg-gray-300">
          <tr>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Subject</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Teacher</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($subjects as $key => $value) {
              $subjectID = $value['SUBJECT_ID'];
              $subjectDesc = $value['SUBJECT_DESC'];

              $teacherID = $value['TEACHER_ID'];
              $teacherFN = $value['TEACHER_FN'];
              $teacherLN = $value['TEACHER_LN'];
              ?>
              <tr>
                <td class="py-4 px-6 text-sm font-medium whitespace-nowrap"><a href="#"><?php echo $subjectDesc; ?></a></td>
                <td class="py-4 px-6 text-sm font-medium whitespace-nowrap">
                  <a href="<?php echo "$base_url/admin/teacher/view/$teacherID"; ?>" class="text-blue-600 hover:text-blue-900">
                    <?php echo "{$teacherLN}, {$teacherFN}"; ?>
                  </a>
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
