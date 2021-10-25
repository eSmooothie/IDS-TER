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
      <div class="border">
        <p>TIME SERIES GRAPH HERE</p>
      </div>
    </div>
    <!-- tabular -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p>Tabular</p>
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
          <tr>
            <th scope="row">1</th>
            <td>s</td>
            <td>p</td>
            <td>s</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th scope="row">Overall</th>
            <td>os</td>
            <td>op</td>
            <td>os</td>
          </tr>
          <tr>
            <th colspan="3" class="border"></th>
            <th>TTL</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
