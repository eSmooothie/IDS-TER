<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md">
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
  <div class="px-3 py-5 bg-gray-100 rounded-md">
    <div class="space-x-4">
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}"; ?>" class=" bg-blue-500 hover:bg-blue-400
       border px-3 py-2 rounded-md text-blue-100 space-x-2 hover:text-black">
        <i class="fa fa-eye"></i>
        <span>View</span>
      </a>
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class=" bg-blue-500 hover:bg-blue-400
       border px-3 py-2 rounded-md text-blue-100 space-x-2 hover:text-black">
        <i class="fas fa-cog"></i>
        <span>Edit</span>
      </a>
      <a href="<?php echo "$base_url/admin/teacher/view/{$teacherData['ID']}/downloads"; ?>" class=" bg-blue-500 hover:bg-blue-400
       border px-3 py-2 rounded-md text-blue-100 space-x-2 hover:text-black">
        <i class="fas fa-download"></i>
        <span>Downloads</span>
      </a>
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
