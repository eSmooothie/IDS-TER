<!-- content -->
<div class=" w-full col-span-7 p-2 space-y-3">
  <!-- NAVIGATION -->
  <div class="py-4 px-3 bg-gray-100 rounded-md mb-3 space-y-5">
    <p class=" font-bold text-lg uppercase"><?php echo "{$department['NAME']}"; ?></p>
    <div class=" space-x-3">
      <a class=" text-center px-5 py-2.5 bg-blue-300 hover:bg-blue-400 rounded-md" href="<?php echo "$base_url/admin/department/view/{$department['ID']}"; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
      <a class=" text-center px-5 py-2.5 bg-blue-300 hover:bg-blue-400 rounded-md" href="<?php echo "$base_url/admin/department/view/{$department['ID']}/edit"; ?>"><i class="fas fa-edit"></i> Edit</a>
      <a class=" text-center px-5 py-2.5 bg-blue-300 hover:bg-blue-400 rounded-md" href="<?php echo "$base_url/admin/department/view/{$department['ID']}/download"; ?>"><i class="fas fa-download"></i> Download</a>
      <!-- TODO: ADD DEPT HISTORY -->
      <a class=" text-center  px-5 py-2.5 bg-gray-300 hover:bg-gray-400 rounded-md" href="<?php echo "#"; ?>"><i class="fa fa-history" aria-hidden="true"></i> History</a>
    </div>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg mb-4">Download Evaluation</p>
    <table class="mb-3 min-w-full border border-gray-300">
      <thead class="border bg-gray-300">
        <tr>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">School Year (Semester)</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Download Link</th>
        </tr>
      </thead>
      <tbody>

          <?php

            foreach ($school_year as $key => $value) {
              $id = $value['ID'];
              $sy = $value['SY'];
              $sem = $value['SEMESTER'];
              ?>
              <tr class="bg-white border-b hover:bg-gray-200 odd:bg-white even:bg-gray-100">
                <td class="py-4 px-6 text-sm text-left font-medium text-gray-900 whitespace-nowrap">
                  <?php echo "$sy ($sem)"; ?></td>
                <td class="py-4 px-6 text-sm font-medium text-center whitespace-nowrap">
                  <a href="<?php echo "$base_url/download/department/$id/{$department['ID']}/{$department['NAME']}"; ?>" 
                  target="_blank" class="text-blue-600 hover:text-blue-900"><i class="fas fa-download"></i> Download</a>
                </td>
              </tr>
              <?php
            }
           ?>

      </tbody>
    </table>
  </div>
</div>

