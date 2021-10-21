<!-- content -->
<div class="col ps-3">
<!-- content -->
  <div class="bg-light border bg-gradient p-3 rounded">
    <div class="d-flex">
      <p>Departments</p>
    </div>
    <div class="">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" >ID</th>
            <th scope="col" >NAME</th>
            <th scope="col" >CHAIRPERSON</th>
            <th scope="col" class="col-1"></th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($department as $key => $value) {
              $id = $value['ID'];
              $name = $value['NAME'];
              $chairperson = $value['CHAIRPERSON'];
              ?>
              <tr>
                <th scope="row"><?php echo "$id"; ?></th>
                <td class="text-uppercase"><?php echo "$name"; ?></td>
                <td><a href="<?php echo "$baseUrl/admin/teacher/view/{$chairperson['ID']}"; ?>">
                  <?php echo (empty($chairperson))?"":"{$chairperson['LN']}, {$chairperson['FN']}"; ?></a></td>
                <td><a href="<?php echo "$baseUrl/admin/department/view/$id"; ?>">View</a></td>
              </tr>
              <?php
            }
           ?>

        </tbody>
      </table>
    </div>
  </div>
</div>
