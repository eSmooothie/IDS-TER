<!-- content -->
<div class="w-full p-2">
    <!-- NAV -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <p class=" text-lg font-bold mb-3 uppercase"><?php
            $name = strtolower($type);
            echo "$type questionnaire";
        ?></p>
        <div class="grid grid-cols-10">
            <a href="<?php echo "$base_url/admin/questionaire/$id/$name";?>" class=" text-blue-600 hover:text-blue-700">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
            </a>
        </div>
    </div>

    <!-- OPTION -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <form id="addQuestion">
            <div class="grid grid-cols-9 mb-5 items-center">
                <label for="question" class="">Question:</label>
                <input type="hidden" name="type" value="<?php echo "$id";?>">
                <input type="text" name="question" class="col-span-3" id="question" required>
            </div>
            <div class="">
                <input type="submit" class="hover:bg-blue-400 rounded-full px-5 bg-blue-300 p-2" value="Submit">
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