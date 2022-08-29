<!-- content -->
<div class="w-full col-span-7 p-2 space-y-3">
    <!-- NAV -->
    <div class="px-3 py-5 bg-gray-100 rounded-md mb-3 space-y-4">
        <p class=" text-lg font-bold mb-3 uppercase"><?php
            $name = strtolower($type);
            echo "$type questionnaire";
        ?></p>
        <div class="">
            <a href="<?php echo "$base_url/admin/questionaire/$id/$name";?>" class=" px-5 py-2.5 font-medium bg-blue-300 hover:bg-blue-400 rounded-md">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
            </a>
        </div>
    </div>

    <!-- OPTION -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <form id="addQuestion" class=" space-y-4">
            <div>
                <p class=" font-medium">Add new question</p>
            </div>
            <div class="">
                <label for="question" class="block">Question:</label>
                <input type="hidden" name="type" value="<?php echo "$id";?>">
                <input type="text" name="question" class=" w-1/2" id="question" required>
            </div>
            <div class="">
                <input type="submit" class="hover:bg-blue-400 rounded-md px-5 bg-blue-300 py-2.5 hover:cursor-pointer" value="Submit">
            </div>
        </form>
    </div>
</div>

<script>
    // do something

    $("#addQuestion").submit(function(e){
        e.preventDefault();
        let formData = $(this).serializeArray();

        let path = "/admin/questionaire/add";
        let base_url=window.location.origin;
        let url=base_url+path;

        $.ajax({
            type:'post',
            url:url,
            data:formData,
        }).done(function(data){
            let path = window.location.pathname;
            let paths = path.split("/");
            let newPath = "/admin/questionaire/"+ paths[3] + "/" + paths[4];

            window.location.href = base_url + newPath;
            
        }).fail(function(xhr,textStatus,errorMessage){
            console.log(xhr);
        });
    });
</script>