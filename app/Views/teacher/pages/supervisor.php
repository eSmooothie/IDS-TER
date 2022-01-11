<div class="w-full p-2">
  <!-- NAV -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="mb-8">
      <table class="mb-3 min-w-full">
        <thead class="">
          <tr class="">
            <th class=""></th>
            <th class=""></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">School Year</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo "{$sy['SY']}"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Semester</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo "{$sy['SEMESTER']}";?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Department</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo "{$myDept['NAME']}"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">is Lecturer</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo ($myData['IS_LECTURER'])? "Yes":"No"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">is Supervisor</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo ($isSupervisor)? "Yes" : "No"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Total Evaluated</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo $evaluatedCounter; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Status</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"><?php echo ($isCleared)? "CLEARED":"NOT CLEARED"; ?></td>
          </tr>
          <tr>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Mode</td>
            <td class="py-1 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Supervisor</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mb-3">
        <a href="<?php echo "$baseUrl/user/teacher"; ?>" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2">RATE AS A PEER</a>
    </div>
  </div>
  <!-- EVALUATION -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr>
          <th  scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
          <?php
          echo ($isPrincipal)?"<th scope=\"col\" class=\"py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase\">Position</th>":"";
            ?>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Name</th>
          <th scope="" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- <img src="https://via.placeholder.com/100" alt=""
        class="d-block mx-auto rounded-circle"
        style="height:100px; width:100px;"></a> -->
        <?php
          foreach ($teachers as $key => $value) {
            $isDone = $value['isDone'];
            $position = (isset($value['position']))? $value['position']:"";
            $teacher = $value['teacher'];

            $path = ($isDone)?"#":"$baseUrl/evaluate/supervisor/{$teacher['ID']}";
            ?>
            <tr class="">
              <th scope="row" class="py-1 px-6 text-sm font-medium whitespace-nowrap text-left"><?php echo "{$teacher['ID']}"; ?></th>
              <?php
                if($isPrincipal){
                  ?><td class="py-1 px-6 text-sm font-medium whitespace-nowrap"><?php echo "$position"; ?></td><?php
                }
                ?>
              <td class="py-1 px-6 text-sm font-medium whitespace-nowrap"><?php echo "{$teacher['LN']}, {$teacher['FN']}"; ?></td>
              <td class="py-1 px-6 text-sm font-medium whitespace-nowrap text-center">
                <a <?php echo ($isDone)?"":"target=\"_blank\""; ?> href="<?php echo "$path"; ?>" 
                class="py-1 px-2 rounded-lg <?php echo ($isDone)? "bg-green-300": "bg-blue-300"; ?>">
                <?php echo ($isDone)?"Done":"Evaluate"; ?></a>
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
