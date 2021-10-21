<!-- content -->
<div class="col ps-3">
<!-- content -->
  <div class="bg-light bg-gradient rounded border mb-3 p-3">
    <p class="fw-bold fs-4"><?php echo "{$execom['NAME']}"; ?></p>
    <div class="">
      <a href="<?php echo "$baseUrl/admin/execom"; ?>">
        <i class="fas fa-arrow-circle-left"></i>
        Back</a>
    </div>
  </div>
  <div class="bg-light bg-gradient rounded border mb-3 p-3">
    <p>Assign new <?php echo "{$execom['NAME']}"; ?> for school year <?php echo "{$school_year['S.Y']}:{$school_year['SEMESTER']}"; ?></p>
    <form id="changeTeacher">
      <input type="hidden" name="id" value="<?php echo "{$execom['ID']}"; ?>">
      <div class="mb-3">
        <label for="newTeacher">Select teacher</label>
        <select class="form-select" name="teacher" id="newTeacher">
          <?php foreach ($teachers as $key => $value) {
            $id = $value['ID'];
            $fn = $value['FN'];
            $ln = $value['LN'];

            ?>
            <option value="<?php echo "$id"; ?>"
              <?php echo (strcmp($id, $currentAssign['TEACHER_ID']) == 0)? "selected":""; ?>
              ><?php echo "$ln, $fn"; ?></option>
            <?php
          } ?>

        </select>
      </div>
      <div class="mb-3">
        <button class="btn btn-primary" type="submit">Submit</button>
      </div>
    </form>
  </div>
  <div class="bg-light bg-gradient rounded border mb-3 p-3">
    <p>Former <?php echo "{$execom['NAME']}"; ?></p>
  </div>
</div>

<script src="<?php echo "$baseUrl/assets/js/adminExecom.js"; ?>" charset="utf-8"></script>
