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
                <input type="submit" class="hover:bg-red-400 rounded-md px-5 bg-red-300 py-2.5 hover:cursor-pointer" value="Remove">
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