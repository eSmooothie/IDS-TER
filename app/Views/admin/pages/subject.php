<!-- content -->
<div class="w-full col-span-7 p-2 space-y-3">
  <!-- NAV -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <p class=" text-xl font-bold">Subjects</p>
  </div>
  <!-- ADD NEW SUBJECT -->
  <div class="p-3 bg-gray-100 rounded-md mb-3 space-y-2">
    <div class="">
      <p class="text-lg font-medium">
        Add new subject
      </p>
    </div>
    <form class="space-y-5" id="addNewSubject">
      <div class="">
        <label for="subjectName" class="block">Subject Name</label>
        <input required type="text" class="w-1/2" name="subjectName" id="subjectName">
      </div>
      <div class="">
        <button type="submit" class="hover:bg-blue-400 rounded-md px-5 bg-blue-300 py-2.5">Submit</button>
      </div>
    </form>
  </div>
  <!-- LIST OF ALL SUBJECT -->
  <div class="p-3 bg-gray-100 rounded-md mb-3">
    <div class="mb-3">
      <input type="text" name="" class="w-full" id="searchSubject" placeholder="Search subject">
    </div>
    <div class="">
      <table class="mb-3 min-w-full border border-gray-100">
        <thead class="border bg-gray-300">
          <tr>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">ID</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Description</th>
            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Action</th>
          </tr>
        </thead>
        <tbody id="subjectTbody">
          <?php
            foreach ($subjects as $key => $value) {
              $id = $value['ID'];
              $name = $value['DESCRIPTION'];
              ?>
              <tr class="bg-white border-b hover:bg-gray-200 odd:bg-white even:bg-gray-200">
                <th scope="row" class="py-4 px-6 text-sm text-left font-medium text-gray-900 whitespace-nowrap"><?php echo "$id"; ?></th>
                <td class="py-4 px-6 text-sm  whitespace-nowrap uppercase"><?php echo "$name"; ?></td>
                <!-- TODO: ADD ACTION PAGE -->
                <td class="py-4 px-6 text-sm font-medium text-left whitespace-nowrap grid grid-cols-2">
                  <a href="#" class="text-blue-600 hover:text-blue-700">Edit</a>
                </td>
              </tr>
              <?php
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="<?php echo "$base_url/assets/js/adminSubject.js"; ?>" charset="utf-8"></script>
