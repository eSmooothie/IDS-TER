<div class="w-full p-2">
  <!-- working area -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-4 text-lg font-bold">Rating</p>
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
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><span>Question #</span></th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Student</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Peer</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Supervisor</th>
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
            <tr class="text-gray-600">
              <th scope="row" class="py-1 px-6 text-sm font-medium whitespace-nowrap text-left"><?php echo "$i"; ?></th>
              <td class="py-1 px-6 text-sm font-medium whitespace-nowrap"><?php echo (!empty($ratings[$i]["STUDENT"]))? "{$ratings[$i]["STUDENT"]}":"0"; ?></td>
              <td class="py-1 px-6 text-sm font-medium whitespace-nowrap"><?php echo "{$ratings[$i]["PEER"]}"; ?></td>
              <td class="py-1 px-6 text-sm font-medium whitespace-nowrap"><?php echo "{$ratings[$i]["SUPERVISOR"]}"; ?></td>
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
        <tr class=" font-bold uppercase">
          <th scope="row" class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left">Overall</th>
          <td class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"><?php echo "$studentOverall"; ?></td>
          <td class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"><?php echo "$peerOverall"; ?></td>
          <td class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"><?php echo "$supervisorOverall"; ?></td>
        </tr>
        <tr>
          <th colspan="3" class=" uppercase text-left py-1 px-6 text-sm font-bold whitespace-nowrap">rating</th>
          <th class="py-1 px-6 text-sm font-bold whitespace-nowrap text-left"><?php echo round($totalOverall * 10, 2);  ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
