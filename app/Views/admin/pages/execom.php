<!-- content -->
<div class="col ps-3">
<!-- content -->
  <div class="bg-light bg-gradient rounded border mb-3 p-3">
    <p class="fw-bold fs-4">Executive Committee</p>
    <div class="">
      <a href="#">
        <i class="fas fa-history"></i>
        History</a>
    </div>
  </div>
  <div class="bg-light bg-gradient rounded border mb-3 p-3">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th scope="col">Position</th>
          <th scope="col">Assign</th>
          <th scope="col" class="col-1"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($execom as $key => $value) {
          $id = $value['ID'];
          $pos = $value['POSITION'];
          $assign = $value['ASSIGN'];
          ?>
          <tr>
            <th scope="row"><?php echo "$pos"; ?></th>
            <td><a href="<?php echo "$baseUrl/admin/teacher/view/{$assign['ID']}"; ?>">
              <?php echo (empty($assign))?"":"{$assign['LN']}, {$assign['FN']}"; ?>
            </a></td>
            <td><a href="<?php echo "$baseUrl/admin/execom/change/$id"; ?>">Change</a></td>
          </tr>
          <?php
        }
         ?>

      </tbody>
    </table>
  </div>
</div>
