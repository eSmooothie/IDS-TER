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

$(".evaluation").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();
  console.log(formData);
  var path = "evaluate/submit";
  var done = function(data){
    console.log(data);
  };

  sendRequest(path, formData, done);
});
