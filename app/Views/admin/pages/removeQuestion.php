<!-- content -->
<div class="w-full p-2">
    <!-- NAV -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <p class=" text-lg font-bold mb-3 uppercase"><?php
            echo "$type questionnaire";
        ?></p>
        <a href="<?php 
            $name = strtolower($type);
            echo "$base_url/admin/questionaire/$id/$name";
        ?>" class=" text-blue-600 hover:text-blue-700">
        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
    </div>
    <!-- QUESTION -->
    <div class="p-3 bg-gray-100 rounded-md mb-3">
        <form id="modifyQuestion">
            <div class="mb-5">
                <p>
                    Are you sure you want to remove question "<b class="text-red-500 uppercase"><?php echo "{$question['QUESTION']}";?></b>"?
                </p>
                <input type="hidden" name="id" value="<?php echo "{$question['ID']}";?>">
            </div>
            <div class="">
                <input type="submit" class="hover:bg-red-400 rounded-full px-5 bg-red-300 p-2" value="Remove">
            </div>
        </form>
    </div>
</div>

<script>
    // do something

    $("#modifyQuestion").submit(function(e){
        e.preventDefault();
        let formData = $(this).serializeArray();

        console.log(formData);

        let path = "/admin/questionaire/remove";
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