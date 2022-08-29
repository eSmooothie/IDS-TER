<!-- content -->
<div class="w-full p-2 col-span-7">
  <!-- CURRENT USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="mb-5">
      <span class=" text-xl font-bold"><?php echo "{$studentData['LN']}, {$studentData['FN']}"; ?></span>
    </div>
    <div class="">
      
    </div>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <a href="<?php echo "$base_url/admin/student";?>" class=" text-blue-700">
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
    </a>
    <!-- TODO: ADD EDIT PAGE -->
    <a href="#" class=" ml-4 text-black">
      <i class="fas fa-edit    "></i> Edit
    </a>
  </div>
  <!-- SECTION HISTORY -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-xl mb-2">Tracker</p>
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr class="">
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">School Year (Semester)</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Grade</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Section</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($sections as $key => $value){
            $name = empty($value['SECTION_NAME'])? "NOT ENROLLED":$value['SECTION_NAME'];
            $grade_lv = empty($value['SECTION_GRADE_LV'])? "NOT ENROLLED":$value['SECTION_GRADE_LV'];
            $sy = $value['SY'];
            $sem = $value['SEMESTER'];
            $status = $value['STATUS'];
          ?>
          <tr class="hover:bg-gray-200 text-left <?php echo ($status === '1')?"bg-green-200":"";?>">
            <th scope="row" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$sy ($sem)";?></th>
            <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$grade_lv";?></td>
            <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$name";?></td>
            <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo ($status === '1')?"Cleared":"Not Cleared";?></td>
          </tr>
          <?php
          }
        ?>        
      </tbody>
    </table>
  </div>
</div>
