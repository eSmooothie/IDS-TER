function sendPostRequest(path,
  formData,
  done = function(data){},
  fail = function(xhr, textStatus, errorMessage){
    console.log(xhr);
  }
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

$("#newSection").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = "admin/section/new";
  var done = function(data){
    // console.log(data);
    window.location.reload();
  }

  sendPostRequest(path, formData, done);
});
