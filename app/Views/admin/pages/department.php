<!-- content -->
<div class="w-full p-2">
<!-- content -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class=" text-lg font-bold mb-3">
      <p>Departments</p>
    </div>
    <div class="mb-10">
      <table class="mb-3 min-w-full">
        <thead class="border bg-gray-300">
          <tr>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">NAME</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">CHAIRPERSON</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($department as $key => $value) {
              $id = $value['ID'];
              $name = $value['NAME'];
              $chairperson = $value['CHAIRPERSON'];
              ?>
              <tr class="bg-white border-b hover:bg-gray-200 ">
                <th scope="row" class="py-4 px-6 text-sm text-left font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
                <td class="py-4 px-6 text-sm  whitespace-nowrap uppercase"><?php echo "$name"; ?></td>
                <td class="py-4 px-6 text-sm font-medium text-left whitespace-nowrap uppercase">
                  <a class="<?php echo (empty($chairperson))? "text-gray-400":"text-blue-600 hover:text-blue-900";?>" href="<?php echo (empty($chairperson))? "#":"$baseUrl/admin/teacher/view/{$chairperson['ID']}"; ?>">
                  <?php echo (empty($chairperson))?"NO CHAIRPERSON":"{$chairperson['LN']}, {$chairperson['FN']}"; ?></a>
                </td>
                <td class="py-4 px-6 text-sm font-medium text-left whitespace-nowrap">
                  <a href="<?php echo "$baseUrl/admin/department/view/$id"; ?>" class="text-blue-600 hover:text-blue-900">View</a>
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
