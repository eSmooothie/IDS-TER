<div class="w-full p-2 col-span-7">
  <!-- ACCOUNT INFORMATION -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-lg font-bold">Account Information</p>
    <table class="mb-3 min-w-1/2">
      <thead>
        <tr>
          <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"></th>
          <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="py-1 px-6 text-sm text-left font-medium whitespace-nowrap">Name:</td>
          <td class="py-1 px-6 text-sm text-left font-medium whitespace-nowrap"><p class="m-0 ps-2"><?php echo "{$student_data['FN']} {$student_data['LN']}"; ?></p></td>
        </tr>
        <tr>
          <td class="py-1 px-6 text-sm text-left font-medium whitespace-nowrap">ID #:</td>
          <td class="py-1 px-6 text-sm text-left font-medium whitespace-nowrap"><p class="m-0 ps-2"><?php echo "{$student_data['ID']}"; ?></p></td>
        </tr>
        <tr>
          <td class="py-1 px-6 text-sm text-left font-medium whitespace-nowrap">Grade Lv. & Section:</td>
          <td class="py-1 px-6 text-sm text-left font-medium whitespace-nowrap"> <p class="m-0 ps-2"><?php echo "{$student_section['GRADE_LV']} - {$student_section['NAME']}"; ?></p></td>
        </tr>
      </tbody>
    </table>
    <p class="text-red-500 text-xs uppercase">
      If the above information is falsely represented please do contact the admin.
    </p>
  </div>

  <div class=" flex flex-col">
    <!-- CHANGE PASSWORD -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
      <p class=" text-lg font-bold mb-3">Change Password</p>
      <form id="changePassword" class=" ">
        <div class="mb-3 flex flex-col">
          <label for="oldPassword">Old Password</label>
          <input type="password" name="oldPass" required id="oldPassword" 
          class=" " placeholder="" value="">
        </div>
        <div class="mb-3 flex flex-col">
          <label for="newPassword">New Password</label>
          <input type="password" name="newPass" required id="newPassword" 
          class=" " placeholder="" value="">
        </div>
        <div class="mb-3 flex flex-col">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" name="confirmPass" required id="confirmPassword" 
          class=" " placeholder="" value="">
        </div>
        <div class="mb-3">
          <p class="bg-red-500 text-black rounded-lg px-3 py-1 hidden" id="errMessage"></p>
        </div>
        <div class=" flex justify-end">
          <button type="submit" name="button" 
          class=" hover:text-black hover:bg-blue-400 py-2 px-9 rounded-md bg-blue-500 text-white font-medium w-64">Change Password</button>
        </div>
      </form>
    </div>
    <!-- TODO: UPLOAD PROFILE PICTURE -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
      <p class=" text-yellow-400 mb-4 text-lg font-bold"><i class="fas fa-exclamation-triangle"></i> Upload Profile Picture</p>
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
        <div class="relative bottom-0">
          <button type="submit" name="button" class=" hover:text-black hover:bg-blue-400 py-2 px-9 
          rounded-md bg-blue-500 text-white font-medium  w-64">Upload Profile Picture</button>
        </div>
      </form>
    </div>
  </div>

</div>

<script src="<?php echo "$base_url/assets/js/studentSettings.js"; ?>" charset="utf-8"></script>
