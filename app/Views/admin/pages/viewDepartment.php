<!-- content -->
<div class="col ps-3">
<!-- content -->
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <p class="fw-bold fs-5"><?php echo "{$department['NAME']}"; ?></p>
    <div class="">
      <a href="<?php echo "$baseUrl/admin/department/view/{$department['ID']}/edit"; ?>" class="me-2"><i class="fas fa-edit"></i> Edit</a>
      <a href="<?php echo "$baseUrl/admin/department/view/{$department['ID']}/download"; ?>"><i class="fas fa-download"></i> Download</a>
    </div>
  </div>
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <div class="">
      <select class="form-select" name="">
        <?php
        foreach ($school_year as $key => $value) {
          $id = $value['ID'];
          $sy = $value['SY'];
          $sem = $value['SEMESTER'];

          ?>
          <option value="<?php echo "$id"; ?>"><?php echo "$sy:$sem"; ?></option>
          <?php
        }
         ?>
      </select>
    </div>
  </div>
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <p>Chairperson</p>
    <table class="table table-striped table-hover border">
      <thead>
        <th scope="col" class="col-1">ID</th>
        <th scope="col">Last Name</th>
        <th scope="col">First Name</th>
        <th scope="col" class="col-1">
        </th>
      </thead>
      <tbody>
        <tr>
          <th scope="row"><?php echo "{$chairperson['ID']}"; ?></th>
          <td><?php echo "{$chairperson['LN']}"; ?></td>
          <td><?php echo "{$chairperson['FN']}"; ?></td>
          <td><a href="<?php echo "$baseUrl/admin/teacher/view/{$chairperson['ID']}"; ?>">View</a></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="bg-light bg-gradient rounded border p-3 mb-3">
    <p>Teachers</p>
    <table class="table table-striped table-hover border">
      <thead>
        <th scope="col" class="col-1">ID</th>
        <th scope="col">Last Name</th>
        <th scope="col">First Name</th>
        <th scope="col"></th>
        <th scope="col" class="col-1">
        </th>
      </thead>
      <tbody>
        <?php
        foreach ($teachers as $key => $value) {
          $id = $value['ID'];
          $fn = $value['FN'];
          $ln = $value['LN'];
          $onLeave = $value['ON_LEAVE'];
          ?>
          <tr class="<?php echo ($onLeave)? "text-danger":""; ?>">
            <th scope="row"><?php echo "$id"; ?></th>
            <td><?php echo "$ln"; ?></td>
            <td><?php echo "$fn"; ?></td>
            <td><?php echo ($onLeave)? "ON LEAVE":""; ?></td>
            <td><a href="<?php echo "$baseUrl/admin/teacher/view/$id"; ?>">View</a></td>
          </tr>
          <?php
        }
         ?>
      </tbody>
    </table>
  </div>
</div>
