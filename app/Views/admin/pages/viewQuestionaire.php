<!-- content -->
<div class="w-full p-2">
    <!-- NAV -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <p class=" text-lg font-bold mb-3 uppercase"><?php
            $name = strtolower($type);
            echo "$type questionnaire";
        ?></p>
        <div class="grid grid-cols-10">
        <a href="<?php echo "$baseUrl/admin/questionaire";?>" class=" text-blue-600 hover:text-blue-700"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
        <a href="<?php echo "$baseUrl/admin/questionaire/$id/$name/add";?>"
            class="text-blue-600 hover:text-blue-700"
        ><i class="fa fa-plus" aria-hidden="true"></i> Add Question</a>
        </div>
        
    </div>
    <!-- QUESTIONS -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        
        <table class="mb-3 min-w-full">
            <thead class="border bg-gray-300">
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
                        <tr class="bg-white border-b hover:bg-gray-200 ">
                            <th scope="row" class="py-4 px-6 text-sm text-left font-medium text-gray-900 whitespace-nowrap"><?php
                                echo $counter;
                            ?></th>
                            <td class="py-4 px-6 text-sm  whitespace-nowrap uppercase"><?php
                                echo $question;
                            ?></td>
                            <td class="py-4 px-6 text-sm  whitespace-nowrap uppercase flex justify-between">
                                <a href="<?php echo "$baseUrl/admin/questionaire/$id/$name/modify/$questionId";?>" class="text-blue-600 hover:text-blue-900">Modify</a>
                                <a href="<?php echo "$baseUrl/admin/questionaire/$id/$name/remove/$questionId";?>" class="text-blue-600 hover:text-blue-900">Remove</a>
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
