<!-- content -->
<div class="col ps-3">
  <!-- content -->
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p class="fw-bold fs-5"><?php echo "{$department['NAME']}"; ?></p>
    <div class="">
      <a href="<?php echo "$baseUrl/admin/department/view/{$department['ID']}/edit"; ?>" class="me-2"><i class="fas fa-edit"></i> Edit</a>
      <a href="<?php echo "$baseUrl/admin/department/view/{$department['ID']}"; ?>" class="ms-3 text-decoration-none">
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
          <th scope="col" class="col-2">Link</th>
        </tr>
      </thead>
      <tbody>

          <?php

            foreach ($school_year as $key => $value) {
              $id = $value['ID'];
              $sy = $value['SY'];
              $sem = $value['SEMESTER'];
              ?>
              <tr>
                <td><?php echo "$sy : $sem"; ?></td>
                <td>
                  <a href="<?php echo "$baseUrl/download/department/$id/{$department['ID']}/{$department['NAME']}"; ?>" target="_blank"><i class="fas fa-download"></i> Download</a>
                </td>
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
