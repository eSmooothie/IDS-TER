<div class="w-full col-span-7 p-2">
  <!-- USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <table class="mb-3 min-w-full">
      <thead class="">
        <tr>
          <th class=""></th>
          <th class=""></th>
        </tr>
      </thead>
      <tbody class=" text-sm">
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6 uppercase">ID Number:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo "{$personal_data['ID']}"; ?></td>
        </tr>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6 uppercase">Name:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo "{$personal_data['FN']} {$personal_data['LN']}"; ?></td>
        </tr>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6 uppercase">Mobile Number:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo (empty($personal_data['MOBILE_NO']))? "None":"{$personal_data['MOBILE_NO']}"; ?></td>
        </tr>
        <tr>
          <td class="py-1 px-6 font-medium whitespace-nowrap w-6 uppercase">Department:</td>
          <td class="py-1 px-6 font-medium whitespace-nowrap"><?php echo "{$department_data['NAME']}"; ?></td>
        </tr>
      </tbody>
    </table>
    <p class=" text-xs text-red-600 uppercase">If the above information is falsely represented please do contact the admin.</p>
  </div>

  <div class="flex flex-col">
    <!-- CHANGE PASSWORD -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
      <p class=" font-bold text-lg">Change Password</p>
      <form id="changePassword" class="">
        <div class=" flex flex-col mb-3">
          <label for="oldPassword">Old Password</label>
          <input type="password" name="oldPass" required id="oldPassword" 
          class="  " placeholder="" value="">
        </div>
        <div class=" flex flex-col mb-3">
          <label for="newPassword">New Password</label>
          <input type="password" name="newPass" required id="newPassword" 
          class="  " placeholder="" value="">
        </div>
        <div class=" flex flex-col mb-3">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" name="confirmPass" required id="confirmPassword" 
          class="  " placeholder="" value="">
        </div>
        <div class=" mb-5">
          <p class="bg-red-500 text-black rounded-lg px-3 py-1 hidden" id="errMessage"></p>
        </div>
        <div class="flex justify-end">
          <button type="submit" name="button" 
          class=" hover:text-black hover:bg-blue-400 py-2 px-9 rounded-md 
          bg-blue-500 text-white font-medium w-64">Change Password</button>
        </div>
      </form>
    </div>
    <!-- TODO: UPLOAD PROFILE PIC -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
      <p class=" text-yellow-400 mb-5"><i class="fas fa-exclamation-triangle"></i> Upload Profile Picture</p>
      <form id="uploadPicture" class=" flex justify-between">
        <div class="">
          <label class="block">
            <input type="file" class="block text-sm rounded-full text-black bg-gray-300
              file:mr-4 file:py-2 file:px-4 file:text-black
              file:rounded-full file:border-0
              file:text-sm file:font-semibold
              file:bg-blue-300 file:cursor-pointer
              hover:file:bg-blue-100" 
              accept="image/*" id="formFile" name="profilePicture"/>
          </label>
        </div>
        <div class="">
          <button type="submit" name="button" class=" hover:text-black hover:bg-blue-400 py-2 px-9 
          rounded-md bg-blue-500 text-white font-medium  w-64">Upload Profile Picture</button>
        </div>
      </form>
    </div>
  </div>


</div>

<script src="<?php echo "$base_url/assets/js/teacherSettings.js"; ?>" charset="utf-8"></script>
