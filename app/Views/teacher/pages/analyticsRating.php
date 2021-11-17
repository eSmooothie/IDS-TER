<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- working area -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p class="mb-1 fw-bold fs-5">Rating</p>
      <div class="">
        <a href="<?php echo "$baseUrl/user/teacher/analytics/rating"; ?>" class="text-decoration-none">
          <i class="fas fa-star-half-alt"></i>
          Rating</a>
        <a href="<?php echo "$baseUrl/user/teacher/analytics/comment"; ?>" class="text-decoration-none ms-3">
          <i class="far fa-comments"></i>
          Comments</a>
        <a href="<?php echo "$baseUrl/user/teacher/analytics/download"; ?>" class="text-decoration-none ms-3">
          <i class="fas fa-download"></i>
          Download</a>
      </div>
    </div>
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <div class="d-flex justify-content-between mb-2">
        <div class="">
          <span>Show:</span>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="student_rating">
          <label class="form-check-label" for="student_rating">
            Student
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="peer_rating">
          <label class="form-check-label" for="peer_rating">
            Peer
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="supervisor_rating">
          <label class="form-check-label" for="supervisor_rating">
            Supervisor
          </label>
        </div>
      </div>
      <div class="border p-2">
        <p>TIME SERIES GRAPH HERE (SOON)</p>
      </div>
    </div>
    <!-- tabular -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p>Tabular Data</p>
      <div class="mb-2">
        <select id="select_sy" class="form-select">
          <?php
            foreach ($schoolyears as $key => $value) {
              ?>
                <option value="<?php echo "{$value['ID']}"; ?>">
                  <?php echo "{$value['SY']}:{$value['SEMESTER']}"; ?>
                </option>
              <?php
            }
           ?>
        </select>
      </div>
      <table class="text-center table table-striped table-hover border rounded">
        <thead class="">
          <th scope="col" class="col-1"><span style="font-size:14px;">Question #</span></th>
          <th scope="col">Student</th>
          <th scope="col">Peer</th>
          <th scope="col">Supervisor</th>
        </thead>
        <tbody>
          <?php
            $ratings = [];
            $n = 1; // question number
            foreach ($studentRating["RATING"] as $key => $value) {
              // code...
              $ratings[$n]["STUDENT"] = round($value["avg"] * 10, 2);
              $n += 1;
            }
            $n = 1;
            foreach ($peerRating["RATING"] as $key => $value) {
              // code...
              $ratings[$n]["PEER"] = round($value["avg"] * 10, 2);
              $n += 1;
            }
            $n = 1;
            foreach ($supervisorRating["RATING"] as $key => $value) {
              // code...
              $ratings[$n]["SUPERVISOR"] = round($value["avg"] * 10, 2);
              $n += 1;
            }

            for ($i = 1 ; $i < $n ; $i++) {
              ?>
              <tr>
                <th scope="row"><?php echo "$i"; ?></th>
                <td><?php echo (!empty($ratings[$i]["STUDENT"]))? "{$ratings[$i]["STUDENT"]}":""; ?></td>
                <td><?php echo "{$ratings[$i]["PEER"]}"; ?></td>
                <td><?php echo "{$ratings[$i]["SUPERVISOR"]}"; ?></td>
              </tr>
              <?php
            }
           ?>
        </tbody>
        <tfoot>
          <?php
            $studentOverall = round($studentRating["OVERALL"] * 10, 2);
            $peerOverall = round($peerRating["OVERALL"] * 10, 2);
            $supervisorOverall = round($supervisorRating["OVERALL"] * 10, 2);

           ?>
          <tr>
            <th scope="row">Overall</th>
            <td><?php echo "$studentOverall"; ?></td>
            <td><?php echo "$peerOverall"; ?></td>
            <td><?php echo "$supervisorOverall"; ?></td>
          </tr>
          <tr>
            <th colspan="3" class="border"></th>
            <th><?php echo round($totalOverall * 10, 2);  ?></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
