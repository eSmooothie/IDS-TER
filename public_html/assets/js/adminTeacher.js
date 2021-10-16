function sendRequest(
  method = 'post',
  path = null,
  formData = null,
  done = function(data){},
  fail = function(xhr,textStatus,errorMessage){}
    ){
    var baseUrl = "http://dev-ter-ids:9094/";
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

  $("#addNewTeacher").submit(function(e){
    e.preventDefault();
    var formData = $(this).serializeArray();

    var method = 'post';
    var path = '/admin/teacher/add';
    var done = function(data, textStatus, xhr ){
      var statusCode = xhr.status;
      if(statusCode == 202){
        var response = xhr.responseJSON;
        var message = response['message'];
        $("#errContainer").removeClass("d-none");
        $("#errMessage").html(message);
      }else{
        window.location.reload();
      }
    }
    var fail = function(xhr,textStatus,errorMessage){

    }
    sendRequest(method, path, formData, done,fail);
  });

});
