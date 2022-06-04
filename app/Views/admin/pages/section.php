<!-- content -->
<div class="w-full p-2">
  <!-- NAV -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <button type="button" name="button" class=" ml-5 hover:bg-blue-400 pt-2 pb-2 
    pl-9 pr-9 rounded-md bg-blue-300"  data-modal-toggle="addSectionModal">
      <i class="fas fa-plus"></i>
      <span>Add Section</span>
    </button>
  </div>
  <!-- SECTIONS -->
  <div class="p-3 bg-gray-100 rounded-md mb-10 grid grid-cols-3 gap-9">
    <?php
      foreach ($gradeLevel as $lv => $sections) {
        ?>
        <div class="border border-black rounded-md p-5">
          <div class="">
            <p class=" text-lg font-bold uppercase text-center mb-3">Grade <?php echo "$lv"; ?></p>
            <table class="mb-3 min-w-full">
              <thead class="order bg-gray-300">
                <tr>
                  <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Name</th>
                  <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($sections as $key => $section) {
                    $id = $section['ID'];
                    $name = $section['NAME'];
                    ?>
                    <tr>
                      <td class="py-1 px-6 text-sm  whitespace-nowrap"><?php echo "$name"; ?></td>
                      <td class="py-1 px-6 text-sm font-medium text-center whitespace-nowrap">
                        <a href="<?php echo "$base_url/admin/section/grade/$lv/$id"; ?>" class="text-blue-600 hover:text-blue-900">
                          <span>View</span>
                        </a>
                      </td>
                    </tr>
                    <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php
      }
    ?>
  </div>
</div>

<!-- modal -->
<div id="addSectionModal" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
    <div class="relative px-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    New section
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                data-modal-toggle="addSectionModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <form class="" id="newSection">
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                <div class="mb-3 grid grid-cols-3">
                  <label for="selectGradeLv" class=" flex items-center">Grade Level</label>
                  <select id="selectGradeLv" class="form-select" aria-label="" name="gradeLevel" class=" col-span-2 w-full rounded-md" required>
                    <option value="" selected>Select Grade level</option>
                    <option value="7">Grade 7</option>
                    <option value="8">Grade 8</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                  </select>
                </div>
                <div class="mb-3 grid grid-cols-3">
                  <label for="sectionName" class=" flex items-center">Name</label>
                  <input type="text" class=" col-span-2 rounded-md" id="sectionName" name="sectionName" 
                  placeholder="Section Name" required>
                </div>
                <div class="mb-3 flex items-center">
                  <input class="mr-1" type="checkbox" role="switch" id="hasRNI" name="hasRNI" >
                  <label class="ml-3" for="hasRNI">Research and Immersion</label>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                  <button data-modal-toggle="addSectionModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Close</button>
                  <button data-modal-toggle="addSectionModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminSection.js"; ?>" charset="utf-8"></script>
