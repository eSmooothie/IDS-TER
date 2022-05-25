<div class="w-full col-span-7 p-2">
  <!-- working area -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-4 text-lg font-bold uppercase">Ratings</p>
    <div class="grid grid-cols-9  gap-x-5">
      <a href="<?php echo "$base_url/user/teacher/analytics/rating"; ?>" 
      class=" border border-blue-300 text-center col-span-3 py-2 rounded-md hover:bg-blue-400 bg-blue-300">
        <i class="fas fa-star-half-alt"></i>
        Rating</a>
      <a href="<?php echo "$base_url/user/teacher/analytics/comment"; ?>" 
      class=" border border-blue-300 text-center col-span-3 py-2 rounded-md hover:bg-blue-400 bg-blue-300">
        <i class="far fa-comments"></i>
        Comments</a>
      <a href="<?php echo "$base_url/user/teacher/analytics/download"; ?>" 
      class=" border border-blue-300 text-center col-span-3 py-2 rounded-md hover:bg-blue-400 bg-blue-300">
        <i class="fas fa-download"></i>
        Download</a>
    </div>
  </div>
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-xs">TIME SERIES GRAPH HERE (SOON)</p>
  </div>
  <!-- tabular -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-lg font-bold mb-3">Tabular Data</p>
    <div class="">
      <!-- TODO: CHANGE TABLE DATA BASED IN SY -->
      <select id="select_sy" class="mb-3 min-w-full">
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
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><span>Question #</span></th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Student</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Peer</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Supervisor</th>
      </thead>
      <tbody id="teacherRating">
        <tr class="text-gray-600" id="rating_loading">
          <th colspan="4" class="py-1 px-6 text-sm font-bold whitespace-nowrap" id="rating_loading_msg">Computing.</th>
        </tr>
      </tbody>
      <tfoot id="teacherOverall" class="hidden">
        <tr class=" font-bold uppercase">
          <th scope="row" class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left">Overall</th>
          <td id="studentOverall" class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"></td>
          <td id="peerOverall" class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"></td>
          <td id="supervisorOverall" class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"></td>
        </tr>
        <tr>
          <th colspan="3" class=" uppercase text-left py-1 px-6 text-sm font-bold whitespace-nowrap">rating</th>
          <th id="Overall" class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/tchrRating.js";?>"></script>