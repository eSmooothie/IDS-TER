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
  <!-- RENAME -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg mb-4">Rename</p>
    <form class="w-full" id="changeName">
      <input type="hidden" name="id" value="<?php echo "{$department['ID']}"; ?>">
      <div class="mb-6">
        <label for="changeName" class="block">New name</label>
        <input required type="text" name="changeName" id="changeName" class=" w-1/2" 
        placeholder="<?php echo "{$department['NAME']}"; ?>">
      </div>
      <div class="">
        <button type="submit" name="button" class="block text-black bg-blue-300 hover:bg-blue-400 focus:ring-4
     focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center">Submit</button>
      </div>
    </form>
  </div>
  <!-- ASSIGN NEW CHAIRPERSON -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg mb-4">Assign Chairperson</p>
    <form class="" id="assignChairperson">
      <input type="hidden" name="id" value="<?php echo "{$department['ID']}"; ?>">
      <div class="mb-6">
        <label for="teachers" class="block">Select Teacher</label>
        <select class=" w-1/2" name="chairperson" id="teachers">
          <?php foreach ($teachers as $key => $value) {
            $id = $value['ID'];
            $fn = $value['FN'];
            $ln = $value['LN'];
            ?>
            <option value="<?php echo "$id"; ?>"
              <?php echo (!empty($chairperson) && strcmp($id, $chairperson['ID']) == 0)? "selected":""; ?>>
              <?php echo "$ln, $fn"; ?>
            </option>
            <?php
          } ?>
        </select>
      </div>
      <div class="">
        <button class="block text-black bg-blue-300 hover:bg-blue-400 focus:ring-4
     focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminDepartment.js"; ?>" charset="utf-8"></script>
