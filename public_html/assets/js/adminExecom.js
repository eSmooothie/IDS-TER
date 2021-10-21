function sendRequest(
  path = null,
  formData = null,
  done = function(data){},
  fail = function(xhr,textStatus,errorMessage){},
  method = 'post'
    ){
    var baseUrl = "http://dev-ter-ids:9094/";
    var url = baseUrl + path;

    $.ajax({
      type:method,
      url:url,
      data:formData,
    }).done(done).fail(fail);
}

$("#changeTeacher").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = "admin/execom/update";
  var done = function(data){
    window.location.reload();
  };

  sendRequest(path, formData, done);
});
