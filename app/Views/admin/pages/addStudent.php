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

    </form>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>