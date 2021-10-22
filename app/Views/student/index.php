<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- working area -->
    <div class="bg-light bg-gradient border rounded p-3 mb-3">
      <div class="mb-3" style="font-size:x-small;">
        <p class="mb-0">School Year: <?php echo "{$sy['SY']}:{$sy['SEMESTER']}"; ?></p>
        <p class="mb-0">Section: <?php echo "{$mySection['NAME']}"; ?></p>
        <p class="mb-0">Has Research and Immersion: <?php echo ($mySection['HAS_RNI'])? "Yes":"No"; ?></p>
        <p class="mb-0">Total Evaluated: <?php echo "$ttlEvaluated"; ?></p>
        <p class="mb-0">Status: <?php echo ($isCleared)? "True":"False"; ?></p>
        <p class="mb-0">Mode: Student</p>
      </div>
    </div>
    <div class="bg-light bg-gradient border rounded p-3 mb-3">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" class="col-2">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Subject</th>
            <th scope="" class="col-1">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($subjects as $key => $value) {
              $isDone = $value['isDone'];
              $subject = $value['subject'];
              $teacher = $value['teacher'];

              $path = ($isDone)?"#":"$baseUrl/evaluate/student/{$teacher['ID']}/{$subject['ID']}";
              ?>
              <tr>
                <th scope="row"><?php echo "{$teacher['ID']}"; ?></th>
                <td><?php echo "{$teacher['LN']}, {$teacher['FN']}"; ?></td>
                <td><?php echo "{$subject['DESCRIPTION']}"; ?></td>
                <td><a <?php echo ($isDone)?"":"target=\"_blank\""; ?> href="<?php echo "$path"; ?>" class="btn <?php echo ($isDone)?"btn-success":"btn-primary"; ?>"><?php echo ($isDone)?"Done":"Evaluate"; ?></a></td>
              </tr>
              <?php
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
