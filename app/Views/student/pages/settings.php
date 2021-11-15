<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- star code -->
    <div class="bg-light bg-gradient mb-3 p-3 border rounded">
      <p class="fw-bold">Account Information</p>
      <p class="mb-1">ID number: <?php echo "{$myData['ID']}"; ?></p>
      <p class="mb-1">Name: <?php echo "{$myData['FN']} {$myData['LN']}"; ?></p>
      <p class="mb-1">Year level: <?php echo "{$mySection['GRADE_LV']}"; ?></p>
      <p class="mb-1">Section: <?php echo "{$mySection['NAME']}"; ?></p>
      <p class="mb-1 text-danger" style="font-size: x-small;">
        If the information above is false. Please do contact the admin.
      </p>
    </div>
    <div class="bg-light bg-gradient mb-3 p-3 border rounded">
      <p class="fw-bold">Change Password</p>
      <form id="changePassword">
        <div class="mb-3">
          <label for="oldPassword">Old Password</label>
          <input type="password" name="oldPass" required id="oldPassword" class="form-control" placeholder="Old password" value="">
        </div>
        <div class="mb-3">
          <label for="newPassword">New Password</label>
          <input type="password" name="newPass" required id="newPassword" class="form-control" placeholder="New password" value="">
        </div>
        <div class="mb-3">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" name="confirmPass" required id="confirmPassword" class="form-control" placeholder="Confirm password" value="">
        </div>
        <div class="">
          <p class="text-danger" style="font-size:x-small;" id="errMessage"></p>
        </div>
        <div class="mb-3">
          <button type="submit" name="button" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <div class="bg-light bg-gradient border rounded p-3 mb-3">
      <p class="fw-bold text-warning"><i class="fas fa-exclamation-triangle"></i> Upload Profile Picture</p>
      <form id="uploadPicture">
        <div class="mb-3">
          <label for="formFile" class="form-label">Upload Profile Picture:</label>
          <input class="form-control" type="file" id="formFile" name="profilePicture">
        </div>
        <div class="mb-3">
          <button type="submit" name="button" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- stop code -->
    <div class="mb-5"></div>
  </div>
</div>

<script src="<?php echo "$baseUrl/assets/js/studentSettings.js"; ?>" charset="utf-8"></script>
