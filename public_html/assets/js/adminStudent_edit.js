$(document).ready(function(){
    $("#confirm-reset").on("click", function(e){
        e.preventDefault();

        var student_id = $(this).data('studentId');
        
        $.ajax({
            type: 'POST',
            url: window.location.origin + "/admin/student/reset_password",
            data: {
                'student_id' : student_id,
            },
            async: false,
            cache: false,
            timeout: 30000,
        })
        .fail(function(xhr, textStatus, errorMessage){return true;})
        .done(function(data){
            alert("Done! New password ids_student_"+student_id);
        });

    });
});