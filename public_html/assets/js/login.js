function sendPostRequest(path,
  formData,
  done = function(data){},
  fail = function(xhr, textStatus, errorMessage){}
){
  var baseUrl = "http://dev-ter-ids:9094/";
  var url = baseUrl + path;
  $.ajax({
    type: 'post',
    url: url,
    data: formData,
  }).done(done)
  .fail(fail);
}

$("#adminLogin").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = 'admin/login';
  done = function(data){
    console.log();
    var isSuc = data['data'];
    if(isSuc){
      window.location.href = "http://dev-ter-ids:9094/admin/dashboard";
    }else{
      $("#adminLogin").get(0).reset()
      $("#errorMessage").removeClass("d-none");
    }
  };
  sendPostRequest(path, formData, done);
});
