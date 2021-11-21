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
      <span class="mb-2 text-white bg-primary border ps-2 pe-2 border-primary rounded-pill me-2">
        <a class="text-white text-decoration-none" href="<?php echo ($teacherData['DEPARTMENT'])? "$baseUrl/admin/department/view/{$teacherData['DEPARTMENT_ID']}":"#"; ?>">
          <small class="text-uppercase">
            <?php echo ($teacherData['DEPARTMENT'])?"{$teacherData['DEPARTMENT']}":"No Department"; ?>
             department
          </small>
        </a>
      </span>
      <?php
      if($teacherData['ON_LEAVE']){
        ?>
        <span class="mb-2 text-white bg-danger border ps-2 pe-2 border-danger rounded-pill">
          <small class="text-uppercase">ON LEAVE</small>
        </span>
        <?php
      }
       ?>
    </div>
  </div>
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <div class="">
      <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class="text-decoration-none"><i class="fas fa-cog"></i> Edit</a>
      <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}/downloads"; ?>" class="ms-3 text-decoration-none"><i class="fas fa-download"></i> Download Evaluation PDF</a>
    </div>
  </div>
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>GRAPH</p>
  </div>
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>Subject Handles</p>
    <table class="table table-striped table-hover border">
      <thead>
        <tr>
          <th scope="col">School Year</th>
          <th scope="col">Subject</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($subjectHandles as $key => $subject) {
            $subjectName = $subject['SUBJECT_NAME'];
            $year = $subject['YEAR'];
            $semester = $subject['SEMESTER'];
            ?>
            <tr>
              <td><?php
              echo "$year : $semester";
              ?></td>
              <td>
                <?php
                echo "$subjectName";
                ?>
              </td>
            </tr>
            <?php
          }
            ?>
      </tbody>
    </table>
  </div>
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>Last 30 Days Activity</p>
    <table class="table table-striped table-hover" style="font-size:small;">
      <thead>
        <tr class="text-center">
          <th scope="col">Activity</th>
          <th scope="col" class="">Date</th>
        </tr>
      </thead>
      <tbody id="activities">
      </tbody>
    </table>
  </div>
</div>

<script src="<?php echo "$baseUrl/assets/js/adminViewTeacher.js"; ?>" charset="utf-8"></script>
