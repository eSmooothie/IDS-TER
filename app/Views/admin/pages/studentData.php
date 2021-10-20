<!-- content -->
<div class="col ps-3">
  <!-- content -->
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <div class="mb-2">
      <span class="fs-4"><?php echo "{$studentData['LN']}, {$studentData['FN']}"; ?></span>
    </div>
    <div class="" style="width:20vw;">
      <span class="mb-2 text-white bg-primary border ps-2 pe-2 border-primary rounded-pill"><small><?php echo "{$studentData['ID']}"; ?></small></span>
      <span class="mb-2 text-white border ps-2 pe-2 <?php echo ($studentData['IS_ACTIVE'])? "border-primary bg-primary":"border-secondary bg-secondary"; ?> rounded-pill">
        <small><?php echo ($studentData['IS_ACTIVE'])? "Active":"In Active"; ?></small></span>
        <?php
        $currStatus = $status[0];
        $latestSection = $sections[0];
         ?>
      <span class="mb-2 text-white border ps-2 pe-2 <?php echo ($currStatus['STATUS'])? "border-success bg-success":"border-secondary bg-secondary"; ?> rounded-pill">
        <small><?php echo ($currStatus['STATUS'])? "Cleared":"Not cleared"; ?></small></span>
      <span class="mb-2 text-white bg-primary border ps-2 pe-2 border-primary rounded-pill"><small>Grade <?php echo "{$latestSection['GRADE_LV']}"; ?></small></span>
      <span class="mb-2 text-white bg-primary border ps-2 pe-2 border-primary rounded-pill">
        <a class="mb-2 text-white" href="<?php echo $baseUrl."/admin/section/grade/{$latestSection['GRADE_LV']}/{$latestSection['SECTION_ID']}"; ?>">
          <small><?php echo "{$latestSection['NAME']}"; ?></small>
        </a>
      </span>
      <span class="text-white bg-primary border ps-2 pe-2 border-primary rounded-pill"><small><?php echo "{$latestSection['S.Y']}"; ?></small></span>
    </div>
  </div>
  <div class="border rounded p-3 bg-light bg-gradient mb-3">
    <p>History</p>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col" class="col-1">School Year</th>
          <th scope="col" class="col-1">Grade</th>
          <th scope="col">Section</th>
          <th scope="col">Total Subject</th>
          <th scope="col">Total Rated</th>
          <th scope="col">Cleared</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row"></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="bg-success"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
