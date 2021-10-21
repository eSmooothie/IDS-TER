<body>
  <div class="container-fluid row">
    <div class="border bg-light bg-gradient col-12 p-3 rounded mb-3 mt-2">
      <div class="d-sm-flex flex-row justify-content-evenly">
        <div class="col text-center">
          <p class="fs-3 fw-bold mb-1"><?php echo "{$school_year['SY']}:{$school_year['SEMESTER']}"; ?></p>
          <span class="">School Year</span>
        </div>
        <div class="col text-center">
          <p class="fs-3 fw-bold mb-1"><?php echo "$countStudent"; ?></p>
          <span class="">Students</span>
        </div>
        <div class="col text-center">
          <p class="fs-3 fw-bold mb-1"><?php echo "$countTeacher"; ?></p>
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
        <button data-bs-toggle="modal" data-bs-target="#newSchoolYearModal" type="button" name="button" class="btn btn-primary rounded-pill w-100 mb-3">New School Year</button>
      </div>
    </div>
    <!-- to do -->
    <div class="col-12 lh-2 p-3 bg-info bg-gradient text-dark rounded border mb-3">
      <p class="fw-bold mb-0">To do after creating a new school year</p>
      <p class="mb-1">Set up the following:</p>
      <ul>
        <li>
          <a href="<?php echo "$baseUrl/admin/teacher"; ?>" class="text-dark">Teacher</a>
          - Update teachers subject handle.
        </li>
        <li>
          <a href="<?php echo "$baseUrl/admin/section"; ?>" class="text-dark">Section</a>
          - Enroll students and assign subjects
        </li>
        <li>
          <a href="<?php echo "$baseUrl/admin/department"; ?>" class="text-dark">Department</a>
          - Assign a chairperson for each department
        </li>
        <li>
          <a href="<?php echo "$baseUrl/admin/execom"; ?>" class="text-dark">Execom</a>
          - Assign a person for each position
        </li>
      </ul>
    </div>
    <!-- Content -->
    <div class="col-12 border rounded bg-light bg-gradient mb-5">
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
        <!-- Department -->
        <div class="col-sm-3 col-12">
          <a href="<?php echo $baseUrl; ?>/admin/department" class="btn btn-outline-primary w-100" style="">
            <div class="text-start">
              <div class="d-flex align-items-center">
                <span class="fs-2"><i class="fas fa-users"></i></span>
                <p class="ms-3 mb-0 fw-bold fs-2">Department</p>
              </div>
              <span>Manage IDS Departments</span>
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
        <!-- Activit log -->
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

  <!-- Modal -->
  <div class="modal fade" id="newSchoolYearModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="" id="newSchoolYear">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">New Teacher</h5>
          <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <!-- do something -->
            <div class="mb-3">
              <label for="from">From: </label>
              <input type="month" min="2018-01" name="from"
              value="" id="from" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="to">To: </label>
              <input type="month" min="2018-01" name="to"
              value="" id="to" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="to">Semester: </label>
              <input type="number" min="1" max="4" name="semester"
              id="to" class="form-control" required>
            </div>
            <div class="mb-3 text-danger text-center">
              <p><small id="errMessage"></small></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<script src="<?php echo "$baseUrl/assets/js/adminDashboard.js"; ?>" charset="utf-8"></script>
