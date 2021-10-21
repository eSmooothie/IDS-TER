<!-- content -->
<div class="col ps-3">
<!-- content -->
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <p class="fw-bold fs-5"><?php echo "{$department['NAME']}"; ?></p>
    <div class="">
      <a href="<?php echo "$baseUrl/admin/department/view/{$department['ID']}"; ?>" class="me-2">
        <i class="fas fa-arrow-circle-left"></i> Back</a>
      <a href="#"><i class="fas fa-download"></i> Download</a>
    </div>
  </div>
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <p>Change Name</p>
    <form class="" id="changeName">
      <input type="hidden" name="id" value="<?php echo "{$department['ID']}"; ?>">
      <div class="mb-3">
        <label for="changeName">New name</label>
        <input required type="text" name="changeName" id="changeName" class="form-control" placeholder="<?php echo "{$department['NAME']}"; ?>">
      </div>
      <div class="mb-3">
        <button type="submit" name="button" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <p>Assign Chairperson</p>
    <form class="" id="assignChairperson">
      <input type="hidden" name="id" value="<?php echo "{$department['ID']}"; ?>">
      <div class="mb-3">
        <label for="teachers">Select Teacher</label>
        <select class="form-select" name="chairperson" id="teachers">
          <?php foreach ($teachers as $key => $value) {
            $id = $value['ID'];
            $fn = $value['FN'];
            $ln = $value['LN'];
            ?>
            <option value="<?php echo "$id"; ?>"
              <?php echo (strcmp($id, $chairperson['ID']) == 0)?"selected":""; ?>>
              <?php echo "$ln, $fn"; ?>
            </option>
            <?php
          } ?>
        </select>
      </div>
      <div class="mb-3">
        <button class="btn btn-primary" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

<script src="<?php echo "$baseUrl/assets/js/adminDepartment.js"; ?>" charset="utf-8"></script>
