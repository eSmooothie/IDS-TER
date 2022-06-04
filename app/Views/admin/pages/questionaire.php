<!-- content -->
<div class="w-full p-2">
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <p class=" text-xl font-bold">Questionnaire</p>
    </div>
    <!-- NAV -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <div class="grid grid-cols-3 gap-9">
            <a href="<?php echo "$base_url/admin/questionaire/1/student"?>" class="block text-black bg-blue-300 hover:bg-blue-200 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Student
            </a>
            <a href="<?php echo "$base_url/admin/questionaire/2/peer"?>" class="block text-black bg-blue-300 hover:bg-blue-200 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Peer
            </a>
            <a href="<?php echo "$base_url/admin/questionaire/3/supervisor"?>" class="block text-black bg-blue-300 hover:bg-blue-200 focus:ring-4
     focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Supervisor
            </a>
        </div>
    </div>
</div>



<script src="<?php echo "$base_url/assets/js/adminSection.js"; ?>" charset="utf-8"></script>
