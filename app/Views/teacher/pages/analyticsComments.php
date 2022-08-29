<div class="w-full col-span-7 p-2">
  <!-- working area -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-4 text-lg font-bold uppercase">Comments</p>
    <div class="grid grid-cols-9  gap-x-5">
    <a href="<?php echo "$base_url/user/teacher/analytics/rating"; ?>" 
      class=" border border-blue-300 text-center col-span-3 py-2 rounded-md hover:bg-blue-400 
      bg-blue-500 font-medium">
        <i class="fas fa-star-half-alt"></i>
        Rating</a>
      <a href="<?php echo "$base_url/user/teacher/analytics/comment"; ?>" 
      class=" border border-blue-300 text-center col-span-3 py-2 rounded-md hover:bg-blue-400 
      bg-blue-500 font-medium">
        <i class="far fa-comments"></i>
        Comments</a>
      <a href="<?php echo "$base_url/user/teacher/analytics/download"; ?>" 
      class=" border border-blue-300 text-center col-span-3 py-2 rounded-md hover:bg-blue-400 
      bg-blue-500 font-medium">
        <i class="fas fa-download"></i>
        Download</a>
    </div>
  </div>
  <!--  -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="w-full">
      <select id="select_sy" class="form-select w-full">
        <?php
          $is_selected = false;
          foreach ($all_school_years as $key => $value) {
            $id = $value['ID'];
            $sy = $value['SY'];
            $semester = $value['SEMESTER'];
            ?>
              <option <?php if(!$is_selected){ echo "selected"; $is_selected = true;}?> 
              value="<?php echo "$id"; ?>"><?php echo "$sy : $semester"; ?></option>
            <?php
          }
          ?>
          
      </select>
    </div>
  </div>
  <!-- COMMENTS -->
  <div class="p-3 bg-gray-100 rounded-md mb-3 " id="commentContainer">
  
    <p class="py-1 px-6 text-sm font-bold whitespace-nowrap" id="loading_msg">Retrieving Comments.</p>
    
  </div>
</div>
<script src="<?php echo "$base_url/assets/js/tchrComments.js";?>"></script>