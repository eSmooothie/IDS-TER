<div class="w-full p-3">
  <!-- working area -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-4 text-lg font-bold uppercase">Comments</p>
    <div class="grid grid-cols-9 text-blue-600">
      <a href="<?php echo "$baseUrl/user/teacher/analytics/rating"; ?>" class="">
        <i class="fas fa-star-half-alt"></i>
        Rating</a>
      <a href="<?php echo "$baseUrl/user/teacher/analytics/comment"; ?>" class="">
        <i class="far fa-comments"></i>
        Comments</a>
      <a href="<?php echo "$baseUrl/user/teacher/analytics/download"; ?>" class="">
        <i class="fas fa-download"></i>
        Download</a>
    </div>
  </div>
  <!--  -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="">
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
  <!-- COMMENTS -->
  <div class="p-3 bg-gray-100 rounded-md mb-3 " id="commentContainer">
    <?php
      foreach ($comments as $key => $value) {
          $hashId = password_hash($value["ID"], PASSWORD_DEFAULT);
          $comment = $value['COMMENT'];
        ?>
        <div class="border border-gray-600 mb-4 p-3 rounded-lg">
          <span class="mb-5"><?php echo "$comment"; ?></span>
        </div>
        <?php
      }
    ?>
  </div>
</div>
