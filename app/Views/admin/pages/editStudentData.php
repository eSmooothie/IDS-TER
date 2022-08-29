<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3">
  <!-- CURRENT USER INFO -->
  <div class="p-3 bg-gray-100 rounded-md space-y-2">
    <span class=" text-sm">student > <?php echo $studentData['ID']; ?> > view > edit</span>
    <div class="">
      <span class=" text-xl font-bold"><?php echo "{$studentData['LN']}, {$studentData['FN']}"; ?></span>
    </div>
    <div class="">
      
    </div>
  </div>
  <div class="p-3 bg-gray-100 rounded-md">
    <a href="<?php echo "$base_url/admin/student/{$studentData['ID']}/view";?>" class=" text-blue-700">
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
    </a>
  </div>
  <!-- CONTENT -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div>
        <button id="_student_reset_password" class=" bg-red-400 hover:bg-red-500 rounded-md px-3 py-1.5 font-medium"
        type="button" data-modal-toggle="reset-password-confirmation-modal">
            Reset Password
        </button>
    </div>    
    
  </div>
</div>

<div id="reset-password-confirmation-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="reset-password-confirmation-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to reset the password?</h3>
                <button data-modal-toggle="reset-password-confirmation-modal" type="button" data-student-id="<?php echo $studentData['ID']; ?>" id="confirm-reset" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes, I'm sure
                </button>
                <button data-modal-toggle="reset-password-confirmation-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo "$base_url/assets/js/adminStudent_edit.js"; ?>" charset="utf-8"></script>