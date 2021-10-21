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
      <a class="text-white text-decoration-none" href="<?php echo "$baseUrl/admin/department/view/{$teacherData['DEPARTMENT_ID']}"; ?>">
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
    <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}"; ?>" class="text-decoration-none">
      <i class="fas fa-arrow-circle-left"></i>
      Back
    </a>
    <a href="#" class="ms-3 text-decoration-none"><i class="fas fa-download"></i> Download Evaluation PDF</a>
  </div>
</div>
<!-- profile info -->
<div class="border rounded p-1 bg-info text-white bg-gradient mb-3 <?php echo (empty($formMessage))? "d-none":"d-block"; ?>">
  <p class="m-0"><?php echo "{$formMessage['message']}"; ?></p>
</div>
<div class="border rounded p-3 bg-light bg-gradient mb-3">
  <p><i class="fas fa-user-edit"></i> Profile Information</p>
  <!-- Profile Info -->
  <form id="profileInformation">
    <!-- ID -->
    <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
    <!-- FN -->
    <div class="mb-3">
      <label for="firstName" class="form-label">First Name</label>
      <input type="text" name="fn" class="form-control" id="firstName" placeholder="<?php echo "{$teacherData['FN']}"; ?>">
    </div>
    <!-- LN -->
    <div class="mb-3">
      <label for="lastName" class="form-label">Last Name</label>
      <input type="text" name="ln" class="form-control" id="lastName" placeholder="<?php echo "{$teacherData['LN']}"; ?>">
    </div>
    <!-- Mobile Number -->
    <div class="mb-3">
      <label for="mobileNumber" class="form-label">Mobile Number</label>
      <input type="text" name="mobileNumber" class="form-control" id="mobileNumber" placeholder="<?php echo "{$teacherData['MOBILE_NO']}"; ?>">
    </div>
    <!-- Is Lecturer -->
    <div class="form-check form-switch mb-3">
      <input name="isLecturer" class="form-check-input" type="checkbox" role="switch" id="isLecturer" <?php echo ($teacherData['IS_LECTURER'])? "checked":""; ?>>
      <label class="form-check-label" for="isLecturer">is lecturer?</label>
    </div>
    <div class="mb-3">
      <input type="submit" name="submit" class="btn btn-primary" value="Submit">
    </div>
  </form>
</div>
<!-- password -->
<div class="border rounded p-1 bg-info text-white bg-gradient mb-3 <?php echo (empty($passwordFormMessage))? "d-none":"d-block"; ?>">
  <p class="m-0"><?php echo "{$passwordFormMessage['message']}"; ?></p>
</div>
<div class="border rounded p-3 bg-light bg-gradient mb-3">
  <p><i class="fas fa-key"></i> Change Password</p>
  <!-- Change Password -->
  <form id="changePassword">
    <!-- ID -->
    <input type="hidden" name="id" value="<?php echo "{$teacherData['ID']}"; ?>">
    <!-- old pass -->
    <div class="mb-3">
      <label for="oldPassword" class="form-label">Old Password</label>
      <input type="password" name="oldPassword" class="form-control" id="oldPassword">
    </div>
    <!-- new pass -->
    <div class="mb-3">
      <label for="newPassword" class="form-label">New Password</label>
      <input type="password" name="newPassword" class="form-control" id="newPassword">
    </div>
    <!-- re-enter password -->
    <div class="mb-3">
      <label for="confirmPassword" class="form-label">Confirm New Password</label>
      <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
    </div>
    <div class="mb-3">
      <input type="submit" name="submit" class="btn btn-primary" value="Submit">
    </div>
  </form>
</div>
<!-- subject -->
<div class="border rounded p-1 bg-info text-white bg-gradient mb-3
<?php echo (empty($subjectFormMessage))? "d-none":"d-block"; ?>">
  <p class="m-0"><?php echo "{$subjectFormMessage['message']}"; ?></p>
</div>
<div class="border rounded p-3 bg-light bg-gradient mb-3">
  <div class="d-flex justify-content-between">
    <p><i class="fas fa-edit"></i> Subject Handles</p>
    <button type="button" class="btn btn-primary" name="button" id="submitSubject" value="<?php echo "{$teacherData['ID']}"; ?>">Submit</button>
  </div>
  <div class="d-flex">
    <!-- table for all subject -->
    <div class="w-100 me-1">
      <div class="d-flex justify-content-between">
        <p>List of All Subjects</p>
        <input type="text" id="searchSubject" class="form-control w-50" placeholder="Search">
      </div>
      <div class="overflow-auto"  style="max-height:50vh;">
        <table class="table table-striped border">
          <thead>
            <tr>
              <th scope="col" class="col-1">ID</th>
              <th scope="col">Description</th>
              <th scope="col" class="col-1"></th>
            </tr>
          </thead>
          <tbody id="listOfSubject">
            <?php
            foreach ($subjects as $key => $value) {
              $id = $value['ID'];
              $desc = $value['DESCRIPTION'];
              ?>
              <tr id="<?php echo "$id"; ?>">
                <th scope="row"><?php echo "$id"; ?></th>
                <td><?php echo "$desc"; ?></td>
                <td>
                  <button type="button" name="button" class="btn btn-primary"
                    onclick="addSubject(this);">
                    <i class="fas fa-plus"></i>
                  </button>
                </td>
              </tr>
              <?php
            }
             ?>
          </tbody>
        </table>
      </div>

    </div>

    <!-- teacher subject -->
    <?php
      $display = "";
      if(empty($currSySubject)){
        $display = "No assigned subject ever since.";
      }else if($currSySubject['ID'] != $currSY['ID']){
        $display = "This is school year {$currSySubject['SY']}:{$currSySubject['SEMESTER']} subjects."
        ." If it is still the same for school year {$currSY['SY']}:{$currSY['SEMESTER']} click \"SUBMIT\""
        ." otherwise edit it for current school year.";
      }else{
        $display = "{$currSySubject['SY']}:{$currSySubject['SEMESTER']} subjects";
      }
     ?>
    <div class="w-100 ms-1">
      <p>My Subjects (<small class="text-danger">
        <?php echo $display; ?>
      </small>)</p>
      <div class="overflow-auto" style="max-height:50vh;">
        <table class="table table-striped border">
          <thead>
            <tr>
              <th scope="col" class="col-1">ID</th>
              <th scope="col">Description</th>
              <th scope="col" class="col-1"></th>
            </tr>
          </thead>
          <tbody id="mySubjects">
            <?php
              foreach ($teacherSubjects as $key => $value) {
                $id = $value['ID'];
                $desc = $value['DESCRIPTION'];
                ?>
                <tr id="<?php echo "$id"; ?>">
                  <th scope="row"><?php echo "$id"; ?></th>
                  <td><?php echo "$desc"; ?></td>
                  <td>
                    <button type="button" name="button" class="btn btn-danger"
                      onclick="removeSubject(this);">
                      <i class="fas fa-times"></i>
                    </button>
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
</div>
</div>
<div class="mb-5 mt-5">
</div>

<script src="<?php echo "$baseUrl/assets/js/adminTeacherEdit.js"; ?>" charset="utf-8"></script>
