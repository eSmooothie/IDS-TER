<!-- content -->
<div class="w-full p-2" id="studentsColContainer">
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <a href="<?php echo "$baseUrl/admin/student"; ?>" class="hover:bg-blue-400 rounded-md bg-blue-300 p-2">
      <i class="fas fa-arrow-left"></i> Back
    </a>
  </div>
  <!-- Server message -->
  <div id="server_message">
  </div>
  <!-- Bulk -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-3 text-xl font-bold">Bulk</p>
    <form class="flex items-center space-x-6" id="bulk" method="post">
      <label class="block">
        <span class="sr-only">Upload CSV file</span>
        <input type="file" class="block w-full text-sm rounded-full text-black bg-gray-300
          file:mr-4 file:py-2 file:px-4 file:text-black
          file:rounded-full file:border-0
          file:text-sm file:font-semibold
          file:bg-blue-300 file:cursor-pointer
          hover:file:bg-blue-100" 
          accept=".csv" id="formFile" name="bulkEnroll"/>
      </label>
      <button type="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2">Submit</button>
    </form>
  </div>
  <!-- Individual -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-3 text-xl font-bold">Individual</p>
    <form class="" id="individual" method="post">
      <!-- Student ID -->
      <div class="grid grid-cols-3 mb-3 w-1/5">
        <label for="inputStudentId" class="">Student ID</label>
        <div class="ml-3 col-span-2 w-52">
          <input name="id" type="text" class=" border border-black rounded-md px-3 py-1" id="inputStudentId" 
          placeholder="ex. 2018-1234" pattern="^\d{4}(-)(\d{1,4})$" required>
        </div>
      </div>
      <!-- Student LN -->
      <div class="grid grid-cols-3 mb-3 w-1/5">
        <label for="inputStudentLn" class="">Last name</label>
        <div class="ml-3 col-span-2 w-52">
          <input name="ln" type="text" class=" border border-black rounded-md px-3 py-1" id="inputStudentLn" 
          placeholder="" required>
        </div>
      </div>
      <!-- Student FN -->
      <div class="grid grid-cols-3 mb-3 w-1/5">
        <label for="inputStudentFn" class="">First name</label>
        <div class="ml-3 col-span-2 w-52">
          <input name="fn" type="text" class=" border border-black rounded-md px-3 py-1" id="inputStudentFn" 
          placeholder="" required>
        </div>
      </div>
      <!-- Section -->
      <div class="grid grid-cols-3 mb-3 w-1/5">
        <label for="inputStudentFn" class="">Section</label>
        <div class="ml-3 col-span-2 w-52">
          <select name="section" class=" form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700
          bg-white bg-clip-padding bg-no-repeat border border-solid border-black rounded-md transition ease-in-out m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="" required>
            <option selected value="">Select Section</option>
            <?php
              foreach($sections as $key => $value){
                $id = $value['ID'];
                $gradeLv = $value['GRADE_LV'];
                $name = $value['NAME'];
                ?>
                <option value="<?php echo "$name";?>"><?php echo $name?></option>
                <?php
              }
            ?>
          </select>
        </div>
      </div>
      <button type="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2 ">Submit</button>
    </form>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>