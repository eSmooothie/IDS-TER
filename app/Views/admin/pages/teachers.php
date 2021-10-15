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
  <div class="col ps-3">
    <!-- content -->
    <div class="border rounded p-3 bg-light bg-gradient mb-3">
      <p class="fw-bold fs-5">Teacher</p>
      <button type="button" name="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
        <i class="fas fa-plus"></i> Add Teacher
      </button>
    </div>
    <!-- Teacher table -->
    <div class="border rounded p-3 bg-light bg-gradient mb-3">
      <div class="d-flex justify-content-end">
        <input type="text" name="" value="" class="form-control searchTeacher" placeholder="Search" style="width:15vw;">
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" class="col-1">ID</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Department</th>
            <th scope="col">Is Lecturuer</th>
            <th scope="col" class="col-1">Actions</th>
          </tr>
        </thead>
        <tbody class="tBodyTeacher">
          <?php
            foreach ($teacherData as $key => $value) {
              $id = $value['ID'];
              $ln = $value['LN'];
              $fn = $value['FN'];
              $isLecturer = $value['IS_LECTURER'];
              $department = $value['DEPARTMENT_NAME'];
              ?>
              <tr>
                <th scope="row"><?php echo "$id"; ?></th>
                <td><?php echo "$ln"; ?></td>
                <td><?php echo "$fn"; ?></td>
                <td><?php echo "$department"; ?></td>
                <td><?php echo ($isLecturer)? "Yes":"No"; ?></td>
                <td><a href="<?php echo "$baseUrl/admin/teacher/view/$id"; ?>">View</a></td>
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
<div class="modal fade" id="addTeacherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('addNewStudents').reset();"></button>
      </div>
      <form class="" id="addNewTeacher">
        <div class="modal-body">
          <!-- Do Something -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('addNewStudents').reset();">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminTeacher.js"; ?>" charset="utf-8"></script>
