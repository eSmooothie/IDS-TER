<!-- content -->
<div class="col ps-3" id="studentsColContainer">
  <div class="border rounded p-3 bg-light bg-gradient d-flex align-items-center justify-content-between mb-4">
    <div class="">
      <a href="<?php echo "$baseUrl/admin/student"; ?>" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Back</a>
    </div>
  </div>
  <!-- Server message -->
  <div id="server_message">
  </div>
  <!-- Bulk -->
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>Add BULK</p>
    <form class="" id="bulk" method="post">
      <input class="form-control mb-3" type="file" accept=".csv" id="formFile" name="bulkEnroll" required>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <!-- Individual -->
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>Add Individual</p>
    <form class="" id="individual" method="post">
      <!-- Student ID -->
      <div class="mb-3 row">
        <label for="inputStudentId" class="col-sm-2 col-form-label">Student ID</label>
        <div class="col-sm-10">
          <input name="id" type="text" class="form-control" id="inputStudentId" 
          placeholder="ex. 2018-1234" pattern="^\d{4}(-)(\d{1,4})$" required>
        </div>
      </div>
      <!-- Student LN -->
      <div class="mb-3 row">
        <label for="inputStudentLn" class="col-sm-2 col-form-label">Last name</label>
        <div class="col-sm-10">
          <input name="ln" type="text" class="form-control" id="inputStudentLn" 
          placeholder="" required>
        </div>
      </div>
      <!-- Student FN -->
      <div class="mb-3 row">
        <label for="inputStudentFn" class="col-sm-2 col-form-label">First name</label>
        <div class="col-sm-10">
          <input name="fn" type="text" class="form-control" id="inputStudentFn" 
          placeholder="" required>
        </div>
      </div>
      <!-- Section -->
      <div class="mb-3 row">
        <label for="inputStudentFn" class="col-sm-2 col-form-label">Section</label>
        <div class="col-sm-10">
          <select name="section" class="form-select" aria-label="" required>
            <option selected value="">Select Section</option>
            <?php
              foreach($sections as $key => $value){
                $id = $value['ID'];
                $gradeLv = $value['GRADE_LV'];
                $name = $value['NAME'];
                ?>
                <option value="<?php echo "$name";?>"><?php echo $name?></option>
                <?php
              }
            ?>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <input type="submit" value="Submit" class="btn btn-primary">
      </div>
    </form>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>