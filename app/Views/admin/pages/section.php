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
      <button type="button" name="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSection">
        <i class="fas fa-plus"></i>
        <span>Add Section</span>
      </button>
    </div>
    <div class="contaier-fluid row row-cols-lg-4 row-cols-md-3 ps-2 gy-3">
      <?php
        foreach ($gradeLevel as $lv => $sections) {
          ?>
          <div class="card me-3">
            <div class="card-body">
              <span class="card-title fs-3 text-primary">Grade <?php echo "$lv"; ?></span>
              <div class="">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col" class="col-1"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach ($sections as $key => $section) {
                        $id = $section['ID'];
                        $name = $section['NAME'];
                        ?>
                        <tr>
                          <td><?php echo "$name"; ?></td>
                          <td>
                            <a href="<?php echo "$baseUrl/admin/section/grade/$lv/$id"; ?>" class="d-flex">
                              <span>View</span>
                            </a>
                          </td>
                        </tr>
                        <?php
                      }
                     ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php
        }
       ?>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addSection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="newSection">
        <div class="modal-body">
          <div class="mb-3">
            <select class="form-select" aria-label="" name="gradeLevel" required>
              <option value="" selected>Select Grade level</option>
              <option value="7">Grade 7</option>
              <option value="8">Grade 8</option>
              <option value="9">Grade 9</option>
              <option value="10">Grade 10</option>
              <option value="11">Grade 11</option>
              <option value="12">Grade 12</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="sectionName" class="form-label">Name</label>
            <input type="text" class="form-control" id="sectionName" name="sectionName" placeholder="Section Name" required>
          </div>
          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="hasRNI" name="hasRNI" >
              <label class="form-check-label" for="hasRNI">Has Research and Immersion?</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="<?php echo "$baseUrl/assets/js/adminSection.js"; ?>" charset="utf-8"></script>
