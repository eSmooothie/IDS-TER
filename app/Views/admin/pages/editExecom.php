<!-- content -->
<div class="w-full p-2">
  <!-- NAV BAR -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-xl font-bold mb-4"><?php echo "{$execom['NAME']}"; ?></p>
    <div class="">
      <a href="<?php echo "$base_url/admin/execom"; ?>" class="text-blue-700">
        <i class="fas fa-arrow-circle-left"></i>
        Back</a>
    </div>
  </div>
  <!-- ASSIGN TEACHER -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-4">
      Assign new <?php echo "{$execom['NAME']}"; ?> for school year 
      <b><?php echo "{$school_year['SY']}:{$school_year['SEMESTER']}"; ?></b>
    </p>
    <form id="changeTeacher">
      <input type="hidden" name="id" value="<?php echo "{$execom['ID']}"; ?>">
      <div class="grid grid-cols-4 mb-3 w-1/5">
        <label for="newTeacher" class="flex items-center col-span-2">Select teacher</label>
        <select class="ml-3 col-span-2 w-52 border border-black rounded-md px-3 py-1" name="teacher" id="newTeacher">
          <?php foreach ($teachers as $key => $value) {
            $id = $value['ID'];
            $fn = $value['FN'];
            $ln = $value['LN'];

            ?>
            <option value="<?php echo "$id"; ?>"
              <?php if(!empty($currentAssign)){echo (strcmp($id, $currentAssign['TEACHER_ID']) == 0)? "selected":"";}?>
              ><?php echo "$ln, $fn"; ?></option>
            <?php
          } ?>

        </select>
      </div>
      <div class="mb-3 w-1/5 flex justify-start">
        <button type="submit" name="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2 col-span-4">Submit</button>
      </div>
    </form>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-10">
    <p class=" text-xl font-bold mb-4">Former <?php echo "{$execom['NAME']}"; ?></p>
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr class="">
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Last Name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">First Name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
        </tr>
      </thead>
      <tbody class="tBodyTeacher">
        <?php
          foreach ($formerAssign as $key => $value) {
            $id = $value['TEACHER_ID'];
            $ln = $value['TEACHER_LN'];
            $fn = $value['TEACHER_FN'];
            ?>
            <tr class="bg-white border-b hover:bg-gray-200">
              <th scope="row" class="py-4 text-left px-6 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$ln"; ?></td>
              <td class="py-4 px-6 text-sm  whitespace-nowrap"><?php echo "$fn"; ?></td>
              <td class="py-4 px-6 text-sm font-medium text-center whitespace-nowrap">
                <a href="<?php echo "$base_url/admin/teacher/view/$id"; ?>" class="text-blue-600 hover:text-blue-900">View</a>
              </td>
            </tr>
            <?php
          }
         ?>
      </tbody>
    </table>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminExecom.js"; ?>" charset="utf-8"></script>
