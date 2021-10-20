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


<!-- Modal -->
<div class="modal fade" id="addTeacherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Teacher</h5>
        <button type="button" class="btn-close resetAddTeacherForm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="" id="addNewTeacher">
        <div class="modal-body">
          <!-- Do Something -->
          <div class="mb-3">
            <!-- ID -->
            <div class="mb-3 row">
              <label for="" class="col-sm-4 col-form-label">ID<span class="text-danger">*</span></label>
              <div class="col-sm-8">
                <input name="id" type="text" class="form-control" id="teacherId" placeholder="2021-XXXX" required>
              </div>
            </div>
            <!-- FN -->
            <div class="mb-3 row">
              <label for="" class="col-sm-4 col-form-label">First Name<span class="text-danger">*</span></label>
              <div class="col-sm-8">
                <input name="fn" type="text" class="form-control" id="teacherFn" placeholder="First Name" required>
              </div>
            </div>
            <!-- LN -->
            <div class="mb-3 row">
              <label for="" class="col-sm-4 col-form-label">Last Name<span class="text-danger">*</span></label>
              <div class="col-sm-8">
                <input name="ln" type="text" class="form-control" id="teacherLn" placeholder="Last Name" required>
              </div>
            </div>
            <!-- Password -->
            <div class="mb-3 row">
              <label for="" class="col-sm-4 col-form-label">Password<span class="text-danger">*</span></label>
              <div class="col-sm-8">
                <input name="password" type="password" class="form-control" id="teacherPassword" placeholder="Password" required>
              </div>
            </div>
            <!-- Mobile Number -->
            <div class="mb-3 row">
              <label for="" class="col-sm-4 col-form-label">Mobile Number</label>
              <div class="col-sm-8">
                <input name="mobileNumber" type="text" class="form-control" id="teacherCellNo" placeholder="09xxxxxxxxx">
              </div>
            </div>
            <!-- Department -->
            <div class="mb-5 row">
              <label for="" class="col-sm-4 col-form-label">Department<span class="text-danger">*</span></label>
              <div class="col-sm-8">
                <select class="form-select" name="department" required>
                  <option value="" selected>Select a department</option>
                  <?php
                  foreach ($departmentData as $key => $value) {
                    $id = $value['ID'];
                    $name = $value['NAME'];
                    ?>
                    <option value="<?php echo "$id"; ?>"><?php echo "$name"; ?></option>
                    <?php
                  }
                   ?>
                </select>
              </div>
            </div>
            <!-- Is Lecturer -->
            <div class="mb-3">
              <div class="form-check form-switch d-flex align-items-center">
                <input name="isLecturer" class="form-check-input" type="checkbox" role="switch" style="height:25px;width:60px;">
                <label class="form-check-label ms-2" for="">is a lecturer?<span class="text-danger">*</span></label>
              </div>
            </div>
            <!-- message -->
            <div class="mb-3 d-none" id="errContainer">
              <div class="p-2 border border-danger bg-danger text-white rounded-pill text-center">
                <p id="errMessage" class="m-0">XXX</p>
              </div>
            </div>
          </div>
          <div class="">
            <p class="text-end"><small>Field with <span class="text-danger">*</span> is required.</small></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary resetAddTeacherForm" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminTeacher.js"; ?>" charset="utf-8"></script>
