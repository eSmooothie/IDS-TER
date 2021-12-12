<!-- content -->
<!-- Filter -->
<div class="col-xl-2 col-lg-3" id="filterContainer" style="display:none;">
<div class="border rounded p-3 bg-light bg-gradient ">
  <p>Filter</p>
  <form class="">
    <div class="border p-2 rounded mb-3">
      <p>School Year</p>
    </div>
    <div class="border p-2 rounded mb-3">
      <p>Section</p>
    </div>
    <div class="border p-2 rounded">
      <p>Order by</p>
    </div>
  </form>
</div>
</div>
<div class="col ps-3" id="studentsColContainer">
<div class="border rounded p-3 bg-light bg-gradient d-flex align-items-center justify-content-between mb-2">
  <div class="">
    <button type="button" name="button" class="btn btn-primary" id="filterBtn">
      <i id="filterIcon" class="fas fa-chevron-right"></i> Filter</button>
    <a href="<?php echo "$baseUrl/admin/student/add"; ?>" class="btn btn-primary">
      <i class="fas fa-plus"></i> Add students</a>
  </div>
  <div class="">
    <input type="text" name="" value="" class="form-control searchStudent" placeholder="Search">
  </div>
</div>
<?php
  if(!empty($uploadStudentMsg)){
    $message = $uploadStudentMsg['message'];
    $data = $uploadStudentMsg['data'];
    $isErr = ($data != "Done")? true:false;
    ?>
    <div class="mb-3 <?php echo ($isErr)?"bg-danger":"bg-success"; ?> text-light bg-gradient border rounded p-2">
      <p class="m-0">
        <i class="fas <?php echo ($isErr)?"fa-exclamation-circle":"fa-check-circle"; ?>"></i>
        <span><?php echo "$message"; ?></span>
        <?php if($data != "Done"){
          ?>
          <ul>
            <?php
              if(!empty($data)){
                  ?>
                    <li><?php echo implode(", ", $data); ?></li>
                  <?php
              }
             ?>
          </ul>
          <?php
        } ?>
      </p>
    </div>
    <?php
  }
 ?>

<!-- table -->
<div class="border rounded p-3 bg-light bg-gradient">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Last name</th>
        <th scope="col">First name</th>
        <th scope="col">Section</th>
        <th scope="col" class="col-1">Is cleared?</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody class="tbodyStudents">
      <?php
        foreach ($students as $key => $value) {
          $id = $value['ID'];
          $fn = $value['FN'];
          $ln = $value['LN'];
          $section = $value['section'];
          $status = $value['status'];
          ?>
          <tr>
            <th scope="row"><?php echo "$id"; ?></th>
            <td><?php echo "$ln"; ?></td>
            <td><?php echo "$fn"; ?></td>
            <td><?php echo ($section)?"$section":"NO SECTION"; ?></td>
            <td class="<?php echo ($status)? "bg-success":"bg-secondary"; ?>"></td>
            <td class="text-center"><a href="<?php echo "$baseUrl"; ?>/admin/student/view/<?php echo "$id"; ?>">View</a></td>
          </tr>
          <?php
        }
       ?>
    </tbody>
  </table>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Enroll New Students</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('addNewStudents').reset();"></button>
      </div>
      <form class="" id="addNewStudents">
        <div class="modal-body">
          <div class="mb-3">
            <p class="fs-5">Upload CSV file</p>
            <p><span class="text-info fw-bold">Note:</span> File format comma separated <span class="fw-bold">(ID, LN, FN, SECTION NAME)</span></p>
            <input class="form-control" type="file" id="formFile" name="bulkEnroll" required>
          </div>
          <hr>
          <!-- <div class="">
            <p class="fs-5">Individual</p>
            <p><span class=""></span></p>
          </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('addNewStudents').reset();">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="loading" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Please Wait</h5>
      </div>
      <div class="modal-body">
        <p class="text-danger">Do not reload the page!</p>
      </div>
      <div class="modal-footer">

      </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>
