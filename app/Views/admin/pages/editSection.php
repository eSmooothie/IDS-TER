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
    <div class="mb-3">
      <div class="border rounded p-3 bg-light bg-gradient">
        <div class="">
          <p class="m-0 fs-3 fw-bold"><?php echo "${sectionData['NAME']}"; ?>
            <small style="font-size:small;"><?php echo "(${schoolyear['S.Y']}:${schoolyear['SEMESTER']})"; ?>
            </small>
          </p>
          <span class="d-flex align-items-center">
            <span class="text-muted">Grade 7</span>
            <span class="ms-2 me-2" style="font-size:5px;"><i class="fas fa-circle"></i></span>
            <span class="text-success"><?php echo count($students); ?> Students</span>
            <span class="ms-2 me-2" style="font-size:5px;"><i class="fas fa-circle"></i></span>
            <span class=""><a href="<?php echo "$baseUrl/admin/section/grade/${sectionData['GRADE_LV']}/${sectionData['ID']}"; ?>"><span class="me-1"><i class="fas fa-arrow-circle-left"></i></span>Back</a></span>
            <span class="ms-2 me-2" style="font-size:5px;"><i class="fas fa-circle"></i></span>
            <span class=""><a href="#"><span class="me-1"><i class="fas fa-history"></i></span>History</a></span>
          </span>
        </div>
      </div>
    </div>
    <div class="contaier-fluid">
      <div class="">
        <ul>
          <li>Enroll student to this section (bulk(csv) or individual)</li>
          <li>Edit subjects</li>
          <li>Edit section name</li>
          <li>Edit section grade lv</li>
        </ul>
      </div>
      <!-- Display Message -->
      <div class="">
        <div class="d-none text-dark w-100 border border-success p-2 rounded" style="background-color:#a2ff83;">
          <p class="m-0">Succ Message</p>
        </div>
        <div class="d-none text-dark w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
          <p class="m-0">Error Message</p>
        </div>
      </div>
        <div id="ServerErrContainer" class="d-none mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
          <p class="m-0" id="ServerErrMessage"></p>
        </div>
      <?php
          if($enrolledStudent){
            ?>
            <div class="text-dark mb-3 w-100 border border-success p-2 rounded" style="background-color:#a2ff83;">
              <p class="m-0">Successfully Enrolled</p>
              <ul>
                <?php
                  foreach ($enrolledStudent as $key => $value) {
                    ?>
                    <li><?php echo "$value"; ?></li>
                    <?php
                  }
                 ?>
              </ul>
            </div>
            <?php
          }
       ?>
      <?php
          if($invalidRows){
            ?>
            <div class="text-dark mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
              <p class="m-0">Invalid lines</p>
              <ul>
                <?php
                foreach ($invalidRows as $key => $value) {
                  $lineNum = $value['key'] + 1;
                  $line = $value['line'];
                  ?>
                  <li><?php echo "Line $lineNum: $line" ?></li>
                  <?php
                }
                 ?>
              </ul>
            </div>
            <?php
          }
       ?>
      <?php
          if($invalidStudentId){
             ?>
             <div class="text-dark mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
               <p class="m-0">Invalid student id (Does not exist in the database)</p>
               <ul>
                 <?php
                 foreach ($invalidStudentId as $key => $value) {
                   ?>
                   <li><?php echo "$value[0]" ?></li>
                   <?php
                 }
                  ?>
               </ul>
             </div>
             <?php
           }
       ?>
      <?php
          if($removeStudent){
              ?>
              <div class="text-dark mb-3 w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
                <p class="m-0">These students already enrolled in this school year.</p>
                <ul>
                  <?php
                  foreach ($removeStudent as $key => $value) {
                    ?>
                    <li><?php echo "$value" ?></li>
                    <?php
                  }
                   ?>
                </ul>
              </div>
              <?php
            }
       ?>
        <!-- message -->
        <?php if($enrollStudentStatus){

          if(!empty($enrollStudentStatus['enrolled'])){
            ?>
            <div class="w-100 border border-success p-2 rounded" style="background-color:#a2ff83;">
              <p class="m-0"><?php echo "Enrolled"; ?></p>
              <ul>
                <?php
                foreach ($enrollStudentStatus['enrolled'] as $key => $value) {
                  ?>
                  <li><?php echo $value; ?></li>
                  <?php
                }
                 ?>
              </ul>

            </div>

          <?php
        }
        if(!empty($enrollStudentStatus['remove'])){
          ?>
          <div class="w-100 border border-danger p-2 rounded" style="background-color:#f67f7b;">
            <p class="m-0">These students already enrolled in this school year.</p>
            <ul>
              <?php
              foreach ($enrollStudentStatus['remove'] as $key => $value) {
                ?>
                <li><?php echo $value; ?></li>
                <?php
              }
               ?>
            </ul>

          </div>

          <?php
        }
      } ?>

      <!-- Enroll new  student -->
      <div class="border rounded p-3 bg-light bg-gradient">
        <p class="fs-3">Enroll students</p>
        <!-- Bulk -->
        <form id="bulkEnroll" >
          <div class="">
            <label for="" class="form-label fs-5">Bulk</label>
          </div>
          <div class="mb-3">
            <span class="fw-bold d-block">Note: CSV format comma separated</span>
            <span class="fw-bold d-block">Example: 2018-000,LN,FN</span>
            <input type="hidden" name="sectionId" value="<?php echo "$id"; ?>">
            <input name="csvFile" class="form-control form-control-sm mb-3" type="file" accept=".csv" style="width:20rem;">
            <button type="submit" name="button" class="btn btn-primary">Submit</button>
          </div>
        </form>
        <!-- Indi -->
        <div class="">
          <label for="" class="form-label fs-5">Individual</label>
        </div>
        <div id="individual" class="d-flex flex-row border rounded p-2">
          <!-- List of student -->
          <div class="col me-1">
            <div class="d-flex justify-content-between">
              <p class="fs-5">List of Students</p>
              <div class="">
                <input type="text" name="" value="" class="form-control searchStudent" placeholder="Search">
              </div>
            </div>
            <div class="overflow-auto"  style="height:50vh;">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">LAST NAME</th>
                    <th scope="col">FIRST NAME</th>
                    <th scope="col" class="col-1"></th>
                  </tr>
                </thead>
                <tbody id="tbodyStudentsE" class="tbodyStudents">
                  <?php
                    foreach ($allStudents as $key => $student) {
                      $id = $student['ID'];
                      $ln = $student['LN'];
                      $fn = $student['FN'];
                      ?>
                      <tr id="<?php echo "$id"; ?>">
                        <th scope="row"><?php echo "$id"; ?></th>
                        <td><?php echo "$ln"; ?></td>
                        <td><?php echo "$fn"; ?></td>
                        <td>
                          <button onclick="add(this);" class="btn btn-primary studentDataE" type="button" name="button" value="<?php echo "$id"; ?>">
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
          <!-- To Enroll -->
          <div class="col ms-1">
            <p class="fs-5">To Enroll</p>
            <div class="overflow-auto"  style="height:50vh;">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">LAST NAME</th>
                    <th scope="col">FIRST NAME</th>
                    <th scope="col" class="col-1"></th>
                  </tr>
                </thead>
                <tbody id="tbodyEnrollee">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-primary mt-3 mb-3" name="button" id="enroll" value="<?php echo "${sectionData['ID']}"; ?>">Enroll</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="" style="height:10vh;">
</div>
<script src="<?php echo "$baseUrl/assets/js/adminSection.js"; ?>" charset="utf-8"></script>
