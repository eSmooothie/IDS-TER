<!-- content -->
<div class="w-full col-span-7 p-2 space-y-3">
    <!-- NAV -->
    <div class="px-3 bg-gray-100 rounded-md mb-3 space-y-3 py-4">
        <p class=" text-lg font-bold mb-3 uppercase"><?php
            $name = strtolower($type);
            echo "$type questionnaire";
        ?></p>
        <div class=" space-x-2">
            <a href="<?php echo "$base_url/admin/questionaire";?>" 
                class=" px-5 py-2.5 font-medium bg-blue-300 hover:bg-blue-400 rounded-md">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
            <a href="<?php echo "$base_url/admin/questionaire/$id/$name/add";?>"
                class=" px-5 py-2.5 font-medium bg-blue-300 hover:bg-blue-400 rounded-md">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Question</a>
        </div>
        
    </div>
    <!-- QUESTIONS -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <table class="mb-3 min-w-full border border-gray-300">
            <thead class=" bg-gray-300">
                <tr>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">#</th>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">Question</th>
                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white border-b hover:bg-gray-200 ">
                <?php
                $counter = 1;
                    foreach($questions as $key => $value){
                        $questionId = $value['ID'];
                        $question = $value['QUESTION'];
                        ?>
                        <tr class="bg-white border-b hover:bg-gray-200 odd:bg-white even:bg-gray-100">
                            <th scope="row" class="py-4 px-6 text-sm text-left font-medium text-gray-900 whitespace-nowrap"><?php
                                echo $counter;
                            ?></th>
                            <td class="py-4 px-6 text-sm  whitespace-nowrap uppercase"><?php
                                echo $question;
                            ?></td>
                            <td class="py-4 px-6 text-sm  whitespace-nowrap uppercase flex justify-between">
                                <a href="<?php echo "$base_url/admin/questionaire/$id/$name/modify/$questionId";?>" class="text-blue-600 hover:text-blue-900">Modify</a>
                                <a href="<?php echo "$base_url/admin/questionaire/$id/$name/remove/$questionId";?>" class="text-red-600 hover:text-red-900">Remove</a>
                            </td>
                        </tr>
                        <?php
                        $counter++;
                    }
                ?>
                
            </tbody>
        </table>
    </div>
</div>
