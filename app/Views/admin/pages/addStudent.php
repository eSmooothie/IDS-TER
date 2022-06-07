<!-- content -->
<div class="w-full p-2 col-span-7 space-y-3" id="studentsColContainer">
  <div class="p-3 bg-gray-100 rounded-md">
    <a href="<?php echo "$base_url/admin/student"; ?>" class="hover:bg-blue-400 rounded-md bg-blue-500 px-4 py-2">
      <i class="fas fa-arrow-left"></i>
      <span class="font-medium">Back</span>
    </a>
  </div>
  <!-- Server message -->
  <div id="server_message">
  </div>
  <!-- Bulk -->
  <div class="p-3 bg-gray-100 rounded-md">
    <p class=" text-xl font-bold">Bulk</p>
    <p class="mb-3 text-sm">
      <span class="font-medium">Note:</span>  
      The CSV file must follow the following format 
      <span class=" font-medium italic">STUDENT_ID,STUDENT_LN,STUDENT_FN</span>.
      <span class=" text-blue-600 hover:cursor-pointer" data-tooltip-target="tooltip-example-csv" data-tooltip-placement="bottom">see example</span>
    </p>
    <div id="tooltip-example-csv" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 tooltip space-y-2">
        <span>Example CSV content:</span>
        <div class=" space-x-0 border border-gray-300 rounded-md p-2">
          <p>2018-1322,Dela Cruz,Juan</p>
          <p>2018-3333,Rizal,Pepe</p>
          <p>2018-2513,Sanchez,Maria</p>
        </div>
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <form class="flex items-center justify-between" id="bulk" method="post">
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
      <button type="submit" class="hover:bg-blue-400 rounded-md px-5 bg-blue-500 py-2 font-medium">Submit</button>
    </form>
  </div>
  <!-- Individual -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="mb-3 text-xl font-bold">Individual</p>
    <form class=" space-y-2" id="individual" method="post">
      <!-- Student ID -->
      <div class="space-y-1">
        <label for="inputStudentId" class="">Student ID</label>
        <div class="">
          <input name="id" type="text" class=" border border-black px-3 py-1 w-1/2" id="inputStudentId" 
           pattern="^\d{4}(-)(\d{1,4})$" required>
           <p>Example: <span class=" font-medium">2018-1322</span></p>
        </div>
      </div>
      <!-- Student LN -->
      <div class="space-y-1">
        <label for="inputStudentLn" class="">Last name</label>
        <div class="">
          <input name="ln" type="text" class=" border border-black  px-3 py-1 w-1/2" id="inputStudentLn" 
           required>
          <p>Example: <span class=" font-medium">Dela Cruz</span></p>
        </div>
      </div>
      <!-- Student FN -->
      <div class="space-y-1">
        <label for="inputStudentFn" class="">First name</label>
        <div class="">
          <input name="fn" type="text" class=" border border-black  px-3 py-1 w-1/2" id="inputStudentFn" 
           required>
          <p>Example: <span class=" font-medium">Juan</span></p>
        </div>
      </div>
      <!-- Section -->
      <div class="space-y-1">
        <label for="inputStudentFn" class="">Section</label>
        <div class="">
          <select name="section" class=" form-select appearance-none block w-1/2 px-3 py-1.5 text-base font-normal text-gray-700
          bg-white bg-clip-padding bg-no-repeat border border-solid border-black transition ease-in-out m-0
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
      <div class=" flex justify-end">
        <button type="submit" class="hover:bg-blue-400 rounded-md px-5 bg-blue-500 py-2 font-medium">Submit</button>
      </div>
      
    </form>
  </div>
</div>
<script src="<?php echo "$base_url/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>