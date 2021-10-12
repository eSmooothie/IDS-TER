<style media="screen">
  .side-nav {
    height: 5rem;
  }
</style>
<body>
<div class="container-fluid row pt-5">
  <!-- Nav -->
  <div id="nav" class="col-lg-2 col-sm-4 p-0">
    <a href="<?php echo "$baseUrl/admin/dashboard"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-columns"></i>
      <span class="ms-3">Dashboard</span>
    </a>
    <a href="<?php echo "$baseUrl/admin/section"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fab fa-buromobelexperte"></i>
      <span class="ms-3">Section</span>
    </a>
    <a href="<?php echo "$baseUrl/admin/student"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-users"></i>
      <span class="ms-3">Student</span>
    </a>
    <a href="<?php echo "$baseUrl/admin/teacher"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-user-tie"></i>
      <span class="ms-3">Teacher</span>
    </a>
    <a href="<?php echo "$baseUrl/admin/subject"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-journal-whills"></i>
      <span class="ms-3">Subject</span>
    </a>
    <a href="<?php echo "$baseUrl/admin/execom"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-user-secret"></i>
      <span class="ms-3">ExeCom</span>
    </a>
    <a href="<?php echo "$baseUrl/admin/activitylog"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-clipboard-list"></i>
      <span class="ms-3">Activity Log</span>
    </a>
  </div>
  <!-- content -->
  <div class="col-xl-2 col-lg-3" id="filterContainer" style="display:none;">
    <div class="border rounded p-3 bg-light bg-gradient ">
      <p>Filter</p>
      <form class="">
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
        <button type="button" name="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
          <i class="fas fa-plus"></i> Add students</button>
      </div>
      <div class="">
        <input type="text" name="" value="" class="form-control searchStudent" placeholder="Search">
      </div>
    </div>
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
        <tbody>
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
</div>
<!-- Modal -->
<div class="modal fade" id="addStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>
