<!-- content -->
<div class="w-full p-2">
  <!-- NAVIGATION -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg uppercase mb-3"><?php echo "{$department['NAME']}"; ?></p>
    <div class="grid grid-cols-9">
    <a class=" text-center text-blue-600 hover:text-blue-700" href="<?php echo "$base_url/admin/department/view/{$department['ID']}"; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
      <a class=" text-center text-blue-600 hover:text-blue-700" href="<?php echo "$base_url/admin/department/view/{$department['ID']}/edit"; ?>"><i class="fas fa-edit"></i> Edit</a>
      <a class=" text-center text-blue-600 hover:text-blue-700" href="<?php echo "$base_url/admin/department/view/{$department['ID']}/download"; ?>"><i class="fas fa-download"></i> Download</a>
      <!-- TODO: ADD DEPT HISTORY -->
      <a class=" text-center text-gray-600" href="<?php echo "#"; ?>"><i class="fa fa-history" aria-hidden="true"></i> History</a>
    </div>
  </div>
  <!-- RENAME -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg mb-4">Rename</p>
    <form class="w-full" id="changeName">
      <input type="hidden" name="id" value="<?php echo "{$department['ID']}"; ?>">
      <div class="grid grid-cols-9 items-center mb-6">
        <label for="changeName" class="">New name</label>
        <input required type="text" name="changeName" id="changeName" class=" col-span-3" 
        placeholder="<?php echo "{$department['NAME']}"; ?>">
      </div>
      <div class="">
        <button type="submit" name="button" class="block text-black bg-blue-300 hover:bg-blue-200 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
      </div>
    </form>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg mb-4">Assign Chairperson</p>
    <form class="" id="assignChairperson">
      <input type="hidden" name="id" value="<?php echo "{$department['ID']}"; ?>">
      <div class="grid grid-cols-9 items-center mb-4">
        <label for="teachers">Select Teacher</label>
        <select class="col-span-3" name="chairperson" id="teachers">
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
        <button class="block text-black bg-blue-300 hover:bg-blue-200 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminDepartment.js"; ?>" charset="utf-8"></script>
