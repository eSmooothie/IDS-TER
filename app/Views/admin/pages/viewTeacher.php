<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
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
  <!-- GRAPH -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="text-xs">GRAPH HERE (soon)</p>
  </div>
  <!-- HANDLE SUBJECTS -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="font-bold text-xl mb-2">Handled subjects</p>
    <table class="mb-3 min-w-full border border-gray-400">
      <thead class=" bg-gray-300">
        <tr>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">School Year (Semester)</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Subject</th>
        </tr>
      </thead>
      <tbody class="">
        <?php
          foreach ($subjectHandles as $key => $subject) {
            $subjectName = $subject['SUBJECT_NAME'];
            $year = $subject['YEAR'];
            $semester = $subject['SEMESTER'];
            ?>
            <tr class="hover:bg-gray-200 text-left odd:bg-white even:bg-gray-100">
              <td class="py-4 px-6 text-sm  whitespace-nowrap">
                <?php echo "$year ($semester)";?>
              </td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap">
                <?php echo "$subjectName";?>
              </td>
            </tr>
            <?php
          }
            ?>
      </tbody>
    </table>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminViewTeacher.js"; ?>" charset="utf-8"></script>
