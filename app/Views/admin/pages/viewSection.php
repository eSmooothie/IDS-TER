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
          <span class=" bg-gray-400 rounded-full text-center py-1"><?php echo count($subjects); ?> Subjects</span>
          <span class=" bg-blue-400 rounded-full text-center py-1">
            <a href="<?php echo "$base_url/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}"; ?>">
              <i class="fa fa-eye mr-2" aria-hidden="true"></i></i>View
            </a>
          </span>
          <span class=" bg-blue-400 rounded-full text-center py-1">
            <a href="<?php echo "$base_url/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}/edit"; ?>">
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
  <!-- SECTION INFO -->
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
