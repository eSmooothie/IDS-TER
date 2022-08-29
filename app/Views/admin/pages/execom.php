<!-- content -->
<div class="w-full col-span-7 p-2 space-y-3">
<!-- content -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-xl font-bold mb-4">Executive Committee</p>
    <div class="">
      <!-- TODO: ADD EDIT PAGE -->
      <a href="#" class=" text-black">
        <i class="fas fa-history"></i>
        History</a>
    </div>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr class="border border-gray-500">
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Position</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Assign</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($execom as $key => $value) {
          $id = $value['ID'];
          $pos = $value['POSITION'];
          $teacher_id = $value['TEACHER_ID'];
          $teacher_fn = $value['TEACHER_FN'];
          $teacher_ln = $value['TEACHER_LN'];
          ?>
          <tr class="border border-black text-left">
            <th scope="row" class="border border-gray-500 py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$pos"; ?></th>
            <td class="border border-gray-500 py-4 px-6 text-sm  whitespace-nowrap <?php echo ($teacher_id)? "text-blue-700":"";?> "><a href="<?php echo ($teacher_id)? "$base_url/admin/teacher/view/{$teacher_id}":"#"; ?>">
              <?php echo (empty($teacher_id))? "NO TEACHER":"{$teacher_ln}, {$teacher_fn}"; ?>
            </a></td>
            <td class="border border-gray-500 py-4 px-6 text-sm text-center text-blue-700 whitespace-nowrap"><a href="<?php echo "$base_url/admin/execom/change/$id"; ?>">Change</a></td>
          </tr>
          <?php
        }
         ?>
      </tbody>
    </table>
  </div>
</div>
