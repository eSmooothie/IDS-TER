<div class="w-full p-2">
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
  <!-- tabular -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">School Year</th>
        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Download Link</th>
      </thead>
      <tbody class="text-gray-600">
        <?php
          foreach ($sy as $key => $value) {
            $id = $value['ID'];
            $sy = $value['SY'];
            $sem = $value['SEMESTER'];
            ?>
            <tr>
              <th scope="row" class="py-1 px-6 text-sm font-medium whitespace-nowrap text-left"><?php echo "$sy:$sem"; ?></th>
              <td class="py-1 px-6 text-sm font-medium whitespace-nowrap text-center">
                <a target="_blank" href="<?php echo "$baseUrl/download/individual/$id"; ?>" class="text-blue-600 hover:text-blue-700">Download</a>
              </td>
            </tr>
            <?php
          }
          ?>
      </tbody>
    </table>
  </div>
</div>
