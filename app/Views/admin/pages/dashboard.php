<body>
  <div class="container-fluid row">
    <div class="border col-12 p-3 rounded mb-3">
      <div class="d-sm-flex flex-row justify-content-evenly">
        <div class="col text-center border">
          <p class="fs-3 fw-bold mb-1">XXXX XXXX Y</p>
          <span class="">School Year</span>
        </div>
        <div class="col text-center border">
          <p class="fs-3 fw-bold mb-1">XXX XXX</p>
          <span class="">Students</span>
        </div>
        <div class="col text-center border">
          <p class="fs-3 fw-bold mb-1">XXX XXX</p>
          <span class="">Teachers</span>
        </div>
      </div>
    </div>
    <!-- Quick access -->
    <div class="col-12 d-sm-flex">
      <div class="me-3">
        <a href="<?php echo $baseUrl; ?>" class="btn btn-primary rounded-pill w-100 mb-3">Log out</a>
      </div>
      <div class="me-3">
        <button type="button" name="button" class="btn btn-primary rounded-pill w-100 mb-3">New School Year</button>
      </div>
      <div class="me-3">
        <button type="button" name="button" class="btn btn-primary rounded-pill w-100">Enroll students</button>
      </div>
    </div>
    <!-- Content -->
    <div class="col-12 border rounded bg-light bg-gradient">
      <div class="container-fluid row row-cols-sm-4 p-3 g-3">
        <!-- Section -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/section" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fab fa-buromobelexperte"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Section</p>
              </div>
              <span>Manage IDS Sections</span>
            </div>
          </a>
        </div>
        <!-- Student -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/student" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fas fa-users"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Student</p>
              </div>
              <span>Manage IDS Students</span>
            </div>
          </a>
        </div>
        <!-- Teacher -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/teacher" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fas fa-user-tie"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Teacher</p>
              </div>
              <span>Manage IDS Teachers</span>
            </div>
          </a>
        </div>
        <!-- Subject -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/subject" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fas fa-journal-whills"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Subjects</p>
              </div>
              <span>Manage Subject</span>
            </div>
          </a>
        </div>
        <!-- Execom -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/execom" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fas fa-user-secret"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Exe Com</p>
              </div>
              <span>Manage Executive Committee</span>
            </div>
          </a>
        </div>
        <!-- Execom -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/activitylog" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fas fa-clipboard-list"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Activity Log</p>
              </div>
              <span>Activity Logs</span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
