<div class="w-full col-span-7 p-2">
  <!-- NAV -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="mb-3">
      <table class="mb-3 min-w-full">
        <thead class="">
          <tr class="">
            <th class=""></th>
            <th class=""></th>
          </tr>
        </thead>
        <tbody class=" text-sm">
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">School Year</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo "{$school_year['SY']}"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Semester</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo "{$school_year['SEMESTER']}";?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Department</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo "{$department['NAME']}"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">is Lecturer</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo ($personal_data['IS_LECTURER'])? "Yes":"No"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">is Supervisor</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo ($is_supervisor)? "Yes" : "No"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Total Evaluated</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo $done_evaluated_counter."/".$num_teachers_to_rate; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Status</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo ($is_cleared)? "CLEARED":"NOT CLEARED"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Mode</td>
            <td class="py-1 px-6 font-medium tracking-wider text-left text-gray-700 uppercase">Supervisor</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mb-3">
        <a href="<?php echo "$base_url/user/teacher"; ?>" class="hover:bg-blue-400 rounded-md px-5 bg-blue-300 p-2">RATE AS A PEER</a>
    </div>
  </div>
  <!-- EVALUATION -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr>
          <th  scope="col" class="py-3 px-6 text-base font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
          <?php
            echo ($is_principal)?"<th scope=\"col\" class=\"py-3 px-6 text-base font-medium tracking-wider text-left text-gray-700 uppercase\">Position</th>":"";
            ?>
          <th scope="col" class="py-3 px-6 text-base font-medium tracking-wider text-left text-gray-700 uppercase">Name</th>
          <th scope="" class="py-3 px-6 text-base font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- <img src="https://via.placeholder.com/100" alt=""
        class="d-block mx-auto rounded-circle"
        style="height:100px; width:100px;"></a> -->
        <?php
          foreach ($to_rate as $key => $value) {
            $is_done = $value['is_done'];
            $position = (!empty($value['position']))? $value['position']:"";
            $teacher = $value['teacher'];

            $path = ($is_done)?"#":"$base_url/evaluate/supervisor/{$teacher['ID']}";
            ?>
            <tr class="odd:bg-white even:bg-gray-200">
              <th scope="row" class="py-1 px-6 text-sm font-medium whitespace-nowrap text-left"><?php echo "{$teacher['ID']}"; ?></th>
              <?php
                if($is_principal){
                  ?><td class="py-2 px-6 text-sm font-medium whitespace-nowrap"><?php echo "$position"; ?></td><?php
                }
                ?>
              <td class="py-2 px-6 text-sm font-medium whitespace-nowrap"><?php echo "{$teacher['LN']}, {$teacher['FN']}"; ?></td>
              <td class="py-2 px-6 text-sm font-medium whitespace-nowrap text-center">
                <a <?php echo ($is_done)?"":"target=\"_blank\""; ?> href="<?php echo "$path"; ?>" 
                class="py-1 px-2 rounded-lg <?php echo ($is_done)? "bg-green-300": "bg-blue-300"; ?>">
                <?php echo ($is_done)?"Done":"Evaluate"; ?></a>
              </td>
            </tr>
            <?php
          }
          ?>

      </tbody>
    </table>
  </div>
</div>

<script>
// refresh the page when active
  document.addEventListener("visibilitychange", function() {
     if (!document.hidden){
         location.reload();
     }
  });
</script>
