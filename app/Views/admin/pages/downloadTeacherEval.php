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
        <a class="text-white text-decoration-none" href="<?php echo "$baseUrl/admin/department/view/{$teacherData['DEPARTMENT_ID']}"; ?>">
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
      <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}/edit"; ?>" class="text-decoration-none">
        <i class="fas fa-cog"></i>
        Edit
      </a>
      <a href="<?php echo "$baseUrl/admin/teacher/view/{$teacherData['ID']}"; ?>" class="ms-3 text-decoration-none">
        <i class="fas fa-arrow-circle-left"></i>
        Back
      </a>
    </div>
  </div>
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>Downloads</p>
    <table class="border table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">School Year</th>
          <th scope="col" class="col-1">Link</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($sy as $key => $value) {
            $id = $value['ID'];
            $sy = $value['SY'];
            $sem = $value['SEMESTER'];
            ?>
            <tr>
              <th scope="row"><?php echo "$sy:$sem"; ?></th>
              <td><a target="_blank" href="<?php echo "$baseUrl/download/individual/{$id}/{$teacherData['ID']}"; ?>">Download</a></td>
            </tr>
            <?php
          }
         ?>
      </tbody>
    </table>
  </div>
</div>
<div class="mb-5 mt-5">
</div>
