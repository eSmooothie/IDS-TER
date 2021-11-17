<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- working area -->

    <div class="bg-light bg-gradient border rounded mb-3 p-3">
      <div class="mb-3" style="font-size:x-small;">
        <p class="mb-0">School Year: <?php echo "{$sy['SY']}:{$sy['SEMESTER']}"; ?></p>
        <p class="mb-0">Department: <?php echo "{$myDept['NAME']}"; ?></p>
        <p class="mb-0">Is Lecturer: <?php echo ($myData['IS_LECTURER'])? "True":"False"; ?></p>
        <p class="mb-0">Is Supervisor: <?php echo ($isSupervisor)? "True" : "False"; ?></p>
        <p class="mb-0">Total Evaluated: <?php echo $evaluatedCounter; ?></p>
        <p class="mb-0">Status: <?php echo ($isCleared)? "CLEARED":"NOT CLEARED"; ?></p>
        <p class="mb-0">Mode: Peer</p>
      </div>
      <div class="">
        <?php if($isSupervisor){
          $as = "";
          if($isChairperson){
            $as = "chairperson";
          }else if($isPrincipal){
            $as = "principal";
          }
          ?>
          <a href="<?php echo "$baseUrl/user/teacher/rate/supervisor"; ?>" class="btn btn-primary">As a <?php echo "$as"; ?></a>
          <?php
        } ?>
      </div>
    </div>
    <table class="table table-striped table-hover bg-light bg-gradient border rounded mb-3 p-3">
      <thead>
        <tr>
          <th scope="col" class="col-2">ID</th>
          <th scope="col">Name</th>
          <th scope="" class="col-1">Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- <img src="https://via.placeholder.com/100" alt=""
        class="d-block mx-auto rounded-circle"
        style="height:100px; width:100px;"></a> -->
        <?php
          foreach ($peer as $key => $value) {
            $isDone = $value['isDone'];
            $teacher = $value['teacher'];

            $path = ($isDone)?"#":"$baseUrl/evaluate/peer/{$teacher['ID']}";
            ?>
            <tr class="">
              <th scope="row"><?php echo "{$teacher['ID']}"; ?></th>
              <td class=""><?php echo "{$teacher['LN']}, {$teacher['FN']}"; ?></td>
              <td><a <?php echo ($isDone)?"":"target=\"_blank\""; ?> href="<?php echo "$path"; ?>" class="btn <?php echo ($isDone)?"btn-success":"btn-primary"; ?>"><?php echo ($isDone)?"Done":"Evaluate"; ?></a></td>
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
