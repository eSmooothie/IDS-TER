<style media="screen">
  .side-nav {
    height: 5rem;
  }
</style>
<body>
<div class="container-fluid row pt-5 mb-5">
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
    <a href="<?php echo "$baseUrl/admin/department"; ?>" class="side-nav btn btn-outline-primary w-100 text-start  d-flex align-items-center fs-5">
      <i class="fas fa-users"></i>
      <span class="ms-3">Department</span>
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
      <div class="mb-2">
        <span class="fs-4"><?php echo "{$teacherData['LN']}, {$teacherData['FN']}"; ?></span>
      </div>
      <div class="" style="width:50vw;">
        <span class="me-2 mb-2 text-white bg-primary border ps-2 pe-2 border-primary rounded-pill">
            <small class="text-uppercase">
              <?php echo "{$teacherData['ID']}"; ?>
            </small>
        </span>
        <span class="mb-2 text-white bg-primary border ps-2 pe-2 border-primary rounded-pill">
          <a class="text-white text-decoration-none" href="<?php echo ($teacherData['DEPARTMENT'])? "$baseUrl/admin/department/view/{$teacherData['DEPARTMENT_ID']}":"#"; ?>">
            <small class="text-uppercase">
              <?php echo ($teacherData['DEPARTMENT'])?"{$teacherData['DEPARTMENT']}":"No Department"; ?>
               department
            </small>
          </a>
        </span>
      </div>
    </div>
    <div class="border rounded p-3 bg-light bg-gradient mb-3">
      <div class="">
        <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class="text-decoration-none"><i class="fas fa-cog"></i> Edit</a>
        <a href="#" class="ms-3 text-decoration-none"><i class="fas fa-download"></i> Download Evaluation PDF</a>
      </div>
    </div>
    <div class="border rounded p-3 bg-light bg-gradient mb-3">
      <p>GRAPH</p>
    </div>
    <div class="border rounded p-3 bg-light bg-gradient mb-3">
      <p>Subject Handles</p>
    </div>
    <div class="border rounded p-3 bg-light bg-gradient mb-3">
      <p>Recent Activities</p>
    </div>
  </div>
</div>
