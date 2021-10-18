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
    <div class="mb-3">
      <div class="border rounded p-3 bg-light bg-gradient">
        <div class="">
          <p class="m-0 fs-3 fw-bold"><?php echo "${sectionData['NAME']}"; ?>
            <small style="font-size:small;"><?php echo "(${schoolyear['S.Y']}:${schoolyear['SEMESTER']})"; ?>
            </small>
          </p>
          <span class="d-flex align-items-center">
            <span class="text-muted">Grade <?php echo $sectionData['GRADE_LV']; ?></span>
            <span class="ms-2 me-2" style="font-size:5px;"><i class="fas fa-circle"></i></span>
            <span class="text-success"><?php echo count($students); ?> Students</span>
            <span class="ms-2 me-2" style="font-size:5px;"><i class="fas fa-circle"></i></span>
            <span class=""><a href="<?php echo "$baseUrl/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}/edit"; ?>"><span class="me-1"><i class="fas fa-cog"></i></span>Option</a></span>
            <span class="ms-2 me-2" style="font-size:5px;"><i class="fas fa-circle"></i></span>
            <span class=""><a href="#"><span class="me-1"><i class="fas fa-history"></i></span>History</a></span>
          </span>
        </div>
      </div>
    </div>
    <div class="contaier-fluid row row-cols-md-2 ps-2 gy-3 ">
      <!-- Students -->
      <div class="col-6">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th colspan="3" class="text-center">Students</th>
            </tr>
            <tr>
              <th scope="col" class="col-2">ID</th>
              <th scope="col" class="">Name</th>
              <th scope="col" class="col-1">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($students as $key => $student) {
              $id = $student['ID'];
              $fn = $student['FN'];
              $ln = $student['LN'];
              $status = $student['STATUS'];
              $isActive = $student['IS_ACTIVE']
              ?>
              <tr>
                <th scope="row"><?php echo "$id"; ?></th>
                <td><a href="<?php echo ($isActive)? "$baseUrl/admin/student/view/$id":"#"; ?>"
                  class="<?php echo ($isActive)? "":"text-muted"; ?>"><?php echo "$ln, $fn"; ?></a></td>
                <td class="<?php echo ($status)? "bg-success":"bg-secondary"; ?>"></td>
              </tr>
              <?php
            } ?>

          </tbody>
        </table>
      </div>
      <!-- Subject Teacher -->
      <div class="col-6">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th colspan="3" class="text-center">Section Subjects</th>
            </tr>
            <tr>
              <th scope="col" class="">Subject</th>
              <th scope="col" class="">Teacher</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($subjects as $key => $value) {
                $subjectData = $value['subject'];
                $teacherData = $value['teacher'];
                ?>
                <tr>
                  <td><a href="#"><?php echo $subjectData['DESCRIPTION']; ?></a></td>
                  <td class=""><a href="#"><?php echo "{$teacherData['LN']}, {$teacherData['FN']}"; ?></a></td>
                </tr>
                <?php
              }
             ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="" style="height:10vh;">
</div>
