function sendRequest(
  path = null,
  formData = null,
  done = function(data){},
  fail = function(xhr,textStatus,errorMessage){},
  method = 'post'
    ){
    var baseUrl = window.location.origin;
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

  var path = "/evaluate/submit";
  var done = function(data){
    window.location.reload();
  };

  sendRequest(path, formData, done);
});

// TODO: Fixed when evaluation is already on the process of submitting submit.