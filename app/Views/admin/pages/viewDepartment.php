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
  <!-- LIST OF ALL CHAIRPERSONS -->
  <div class="p-3 bg-gray-100 rounded-md mb-3 flex items-center space-x-3">
    <p class=" font-medium text-lg">Current Chairperson: 
      <span class=" font-medium uppercase <?php echo (empty($chairperson))? "text-gray-600" : "text-blue-600 hover:text-blue-700";?>">
        <a href="<?php echo (empty($chairperson))? "":"$base_url/admin/teacher/view/{$chairperson['ID']}"; ?>">
          <?php echo (empty($chairperson))? "NO CHAIRPERSON":"{$chairperson['LN']}, {$chairperson['FN']}"; ?>
        </a>
      </span>
    </p>
    
  </div>
  <!-- LIST OF TEACHERS IN THE DEPARTMENT -->
  <div class="p-3 bg-gray-100 rounded-md mb-10">
    <table class="mb-3 min-w-full border border-gray-300">
      <thead class="border bg-gray-300">
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Last Name</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">First Name</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">status</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">action</th>
      </thead>
      <tbody>
        <?php
        foreach ($teachers as $key => $value) {
          $id = $value['ID'];
          $fn = $value['FN'];
          $ln = $value['LN'];
          $onLeave = $value['ON_LEAVE'];
          ?>
          <tr class="bg-white border-b hover:bg-gray-200 odd:bg-white even:bg-gray-100 <?php echo ($onLeave)? "text-red-600":""; ?>">
            <th scope="row" class="py-4 px-6 text-sm text-left font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
            <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$ln"; ?></td>
            <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$fn"; ?></td>
            <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo ($onLeave)? "ON LEAVE":""; ?></td>
            <td class="py-4 px-6 text-sm  whitespace-nowrap text-blue-600 text-center">
              <a href="<?php echo "$base_url/admin/teacher/view/$id"; ?>">View</a>
            </td>
          </tr>
          <?php
        }
         ?>
      </tbody>
    </table>
  </div>
</div>
