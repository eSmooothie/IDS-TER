<!-- content -->
<div class="w-full p-2">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="mb-5">
      <span class=" text-xl font-bold uppercase"><?php echo "{$teacherData['LN']}, {$teacherData['FN']}"; ?></span>
    </div>
    <div class="grid grid-cols-3 text-center gap-x-4">
      <span class="rounded-full border py-2 px-3 text-xs flex items-center justify-center border-gray-400 bg-gray-300">
        <?php echo "{$teacherData['ID']}"; ?>
      </span>
      <span class="uppercase rounded-full border py-2 px-3 text-xs flex items-center justify-center border-blue-400 bg-blue-300 hover:bg-blue-200 hover:cursor-pointer">
        <a class="" href="<?php echo "$base_url/admin/department/view/{$teacherData['DEPARTMENT_ID']}"; ?>">
          <?php echo ($teacherData['DEPARTMENT'])?"{$teacherData['DEPARTMENT']}":"No Department"; ?>
        </a>
      </span>
      <?php
      if($teacherData['ON_LEAVE']){
        ?>
        <span class="rounded-full border py-2 px-3 text-xs flex items-center justify-center uppercase border-red-400 bg-red-300">
          ON LEAVE
        </span>
        <?php
      }
      ?>
    </div>
  </div>
  <!-- NAV BAR -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="grid grid-cols-9">
    <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}"; ?>" class=" text-blue-700">
        <i class="fa fa-eye" aria-hidden="true"></i> View</a>
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class=" text-blue-700">
        <i class="fas fa-cog"></i> Edit</a>
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}/downloads"; ?>" class=" text-blue-700">
        <i class="fas fa-download"></i> Downloads</a>
    </div>
  </div>
  <!-- DOWNLOAD -->
  <div class="p-3 bg-gray-100 rounded-md mb-10">
    <p class="font-bold text-xl mb-4">Downloads</p>
    <table class="mb-3 min-w-full"">
      <thead class="border bg-gray-300">
        <tr>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">School Year</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Link</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($sy as $key => $value) {
            $id = $value['ID'];
            $sy = $value['SY'];
            $sem = $value['SEMESTER'];

            $pdfName = "{$sy}_{$sem}_{$teacherData['ID']}_{$teacherData['LN']}";
            ?>
            <tr class="hover:bg-gray-200 text-left">
              <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$sy:$sem"; ?></th>
              <td>
                <a target="_blank" class="text-blue-600 hover:text-blue-900"
                href="<?php echo "$base_url/download/individual/{$id}/{$teacherData['ID']}/$pdfName"; ?>">Download</a>
              </td>
            </tr>
            <?php
          }
         ?>
      </tbody>
    </table>
  </div>
</div>
<div class="mb-5 mt-5">
</div>
