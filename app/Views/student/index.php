<div class="w-full p-2">
  <!-- INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-lg font-bold">System Information</p>
    <div class=" grid grid-cols-4 text-sm uppercase">
      <p class="">School Year: </p>
      <p class=" col-span-3"><?php echo "{$school_year['SY']}"; ?></p>

      <p class="">Semester: </p>
      <p class=" col-span-3"><?php echo "{$school_year['SEMESTER']}"; ?></p>

      <p class="">Section: </p>
      <p class=" col-span-3"><?php echo "{$student_section['NAME']}"; ?></p>

      <p class="">Has Research and Immersion: </p>
      <p class=" col-span-3"><?php echo ($student_section['HAS_RNI'])? "Yes":"No"; ?></p>

      <p class="">Total Evaluated: </p>
      <p class=" col-span-3"><?php echo "$done_evaluated_counter/".count($student_subjects); ?></p>

      <p class="">Status: </p>
      <p class=" col-span-3"><?php echo ($student_status)? "Cleared":"Not Cleared"; ?></p>

      <p class="">Mode: </p>
      <p class=" col-span-3">student</p>
    </div>
  </div>
  <!-- EVALUATION -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300 text-sm">
        <tr>
          <th scope="col" class="py-3 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
          <th scope="col" class="py-3 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Name</th>
          <th scope="col" class="py-3 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Subject</th>
          <th scope="col" class="py-3 px-6 font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($student_subjects as $key => $value) {
            $is_done = $value['is_done'];
            $subject = $value['subject_data'];
            $teacher = $value['teacher_data'];

            $evaluation_path = ($is_done)? "#":"$base_url/evaluate/student/{$teacher['ID']}/{$subject['ID']}";
            ?>
            <tr>
              <th scope="row" class="py-1 px-6 text-left font-medium whitespace-nowrap"><?php echo "{$teacher['ID']}"; ?></th>
              <td class="py-1 px-6 text-left font-medium whitespace-nowrap"><?php echo "{$teacher['LN']}, {$teacher['FN']}"; ?></td>
              <td class="py-1 px-6 text-left font-medium whitespace-nowrap"><?php echo "{$subject['DESCRIPTION']}"; ?></td>
              <td class="py-1 px-6 font-medium whitespace-nowrap text-center">
                <a <?php echo ($is_done)?"":"target=\"_blank\""; ?> href="<?php echo "$evaluation_path"; ?>" 
                class="<?php echo ($is_done)?"text-green-500":"text-blue-600"; ?>"><?php echo ($is_done)?"Done":"Evaluate"; ?></a></td>
            </tr>
            <?php
          }
          ?>
      </tbody>
    </table>
  </div>
</div>



<script>
// refresh the page when active
  document.addEventListener("visibilitychange", function() {
     if (!document.hidden){
       location.reload();
     }
  });
</script>
