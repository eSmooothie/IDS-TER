<!-- content -->
<!-- Filter -->
<div class=" w-72 p-2" id="filterContainer" style="display:none;">
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class="text-center font-bold"><span class=" text-xs"><i class="fa fa-filter" aria-hidden="true"></i></span> Filter</p>
    <form class="">
      <div class="border border-gray-300 mb-3 rounded-md text-xs px-2 py-1">
        <p>School Year</p>
        checklist
      </div>
      <div class="border border-gray-300 mb-3 rounded-md text-xs px-2 py-1">
        <p>Section</p>
      </div>
      <div class="border border-gray-300 mb-3 rounded-md text-xs px-2 py-1">
        <p>Order by</p>
      </div>
    </form>
  </div>
</div>
<div class="w-full p-2" id="studentsColContainer">
  
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <button type="button" name="button" class="hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300" id="filterBtn">
      <i id="filterIcon" class="fas fa-chevron-right"></i> Filter</button>
    <a href="<?php echo "$base_url/admin/student/add"; ?>" class=" ml-5 hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300">
      <i class="fas fa-plus"></i> Add students</a>
  </div>
 
  <!-- table -->
  <div class="p-3 bg-gray-100 rounded-md mb-10">
    <!-- SEARCH -->
    <div class="mb-3">
        <label class="relative block">
          <span class="sr-only">Search</span>
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <i class="fas fa-search"></i>
          </span>
          <input class="placeholder:italic placeholder:text-gray-400 block 
          bg-white w-full border border-gray-300 
          rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none 
          focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm searchStudent
          " placeholder="Search for student..." type="text" name="search"/>
        </label>
    </div>
    <div class="flex justify-between items-center">
      <button id="prevBtn" class="hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300" onclick="pagination(-1);">Prev</button>
      <p class="m-0" id="pageNumber">Page </p>
      <button id="nextBtn" class="hover:bg-blue-400 pt-2 pb-2 pl-9 pr-9 rounded-md bg-blue-300" onclick="pagination(1);">Next</button>
    </div>
    <p class="mb-3 text-xxs">Load 20 student per page</p>
    <table class="mb-3 min-w-full">
      <thead class="border bg-gray-300">
        <tr class="">
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">ID</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Last name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">First name</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Section</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Status</th>
          <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody id="studentContainer" class="tbodyStudents">
      </tbody>
    </table>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminStudent.js"; ?>" charset="utf-8"></script>
