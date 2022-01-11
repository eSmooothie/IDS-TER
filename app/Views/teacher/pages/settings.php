<div class="w-full p-2">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full text-xs">
      <thead class="">
        <tr>
          <th class=""></th>
          <th class=""></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6">ID Number:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo "{$myData['ID']}"; ?></td>
        </tr>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6">Name:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo "{$myData['FN']} {$myData['LN']}"; ?></td>
        </tr>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6">Mobile Number:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo (empty($myData['MOBILE_NO']))? "":"{$myData['MOBILE_NO']}"; ?></td>
        </tr>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6">Department:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo "{$myDept['NAME']}"; ?></td>
        </tr>
      </tbody>
    </table>
    <p class=" text-xs text-red-600">If the above information is falsely represented please do contact the admin.</p>
  </div>
  <!-- CHANGE PASSWORD -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" font-bold text-lg">Change Password</p>
    <form id="changePassword" class="w-1/2">
      <div class="grid grid-cols-3 items-center mb-3">
        <label for="oldPassword">Old Password</label>
        <input type="password" name="oldPass" required id="oldPassword" 
        class=" col-span-2" placeholder="Old password" value="">
      </div>
      <div class="grid grid-cols-3 items-center mb-3">
        <label for="newPassword">New Password</label>
        <input type="password" name="newPass" required id="newPassword" 
        class=" col-span-2" placeholder="New password" value="">
      </div>
      <div class="grid grid-cols-3 items-center mb-3">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" name="confirmPass" required id="confirmPassword" 
        class=" col-span-2" placeholder="Confirm password" value="">
      </div>
      <div class=" mb-5">
        <p class="bg-red-500 text-black rounded-lg px-3 py-1 hidden" id="errMessage"></p>
      </div>
      <div class="">
        <button type="submit" name="button" class=" border hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300">Submit</button>
      </div>
    </form>
  </div>
  <!-- TODO: UPLOAD PROFILE PIC -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-yellow-400 mb-5"><i class="fas fa-exclamation-triangle"></i> Upload Profile Picture</p>
    <form id="uploadPicture">
      <div class="mb-5">
        <label class="block">
          <input type="file" class="block w-1/5 text-sm rounded-full text-black bg-gray-300
            file:mr-4 file:py-2 file:px-4 file:text-black
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-blue-300 file:cursor-pointer
            hover:file:bg-blue-100" 
            accept="image/*" id="formFile" name="profilePicture"/>
        </label>
      </div>
      <div class="mb-3">
        <button type="submit" name="button" class=" border hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300">Submit</button>
      </div>
    </form>
  </div>

</div>

<script src="<?php echo "$baseUrl/assets/js/teacherSettings.js"; ?>" charset="utf-8"></script>
