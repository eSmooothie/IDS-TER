function sendRequest(
  method = 'post',
  path = null,
  formData = null,
  done = function(data){},
  fail = function(xhr,textStatus,errorMessage){}
    ){
    var baseUrl = window.location.origin;
    var url = baseUrl + path;

    $.ajax({
      type:method,
      url:url,
      data:formData,
    }).done(done).fail(fail);
}

$(document).ready(function(){
  $('.searchTeacher').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $(".tBodyTeacher tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  $(".resetAddTeacherForm").on('click',function(){
    $("#addNewTeacher")[0].reset();
    if(!$("#errContainer").hasClass("hidden")){
      $("#errContainer").addClass("hidden");
    }
  });

  $("#addNewTeacher").submit(function(e){
    e.preventDefault();
    var formData = $(this).serializeArray();

    var method = 'post';
    var path = '/admin/teacher/add';
    var done = function(data, textStatus, xhr ){
     
      var statusCode = data["status_code"];
      if(statusCode == 400){
        var message = data['message'];
        $("#errContainer").removeClass("hidden");
        $("#errMessage").html(message);
      }else{
        if(!$("#errContainer").hasClass("hidden")){
          $("#errContainer").addClass("hidden");
        }
        window.location.reload();
      }
    }
    var fail = function(xhr,textStatus,errorMessage){

    }
    sendRequest(method, path, formData, done,fail);
  });

});
