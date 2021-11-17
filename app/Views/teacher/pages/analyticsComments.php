<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- working area -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p class="mb-1 fw-bold fs-5">Comments</p>
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
    <!-- tabular -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p></p>
      <div class="mb-2">
        <select id="select_sy" class="form-select">
          <?php
            foreach ($schoolyears as $key => $value) {
              $id = $value['ID'];
              $sy = $value['SY'];
              $semester = $value['SEMESTER'];
              ?>
                <option value="<?php echo "$id"; ?>"><?php echo "$sy : $semester"; ?></option>
              <?php
            }
           ?>

        </select>
      </div>
    </div>
    <div class="bg-light bg-gradient rounded border mb-3 p-3" id="commentContainer">
      <?php
        foreach ($comments as $key => $value) {
            $hashId = password_hash($value["ID"], PASSWORD_DEFAULT);
            $comment = $value['COMMENT'];
          ?>
          <div class="border text-wrap p-2 rounded mb-3">
            <span><?php echo "$comment"; ?></span>
            <div class="d-flex justify-content-end mt-3">
              <span style="font-size:10px;">ID:<?php echo "$hashId"; ?></span>
            </div>
          </div>
          <?php
        }
       ?>
    </div>
    <div class="mb-5">
    </div>
  </div>
</div>
