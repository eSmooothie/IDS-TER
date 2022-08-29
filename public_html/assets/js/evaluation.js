

$(document).ready(function(){

  $("#evaluation").one('submit', function(e){
    var formData = $(this).serializeArray();
    
    console.log(formData);
  
    var path = "/evaluate/submit";
    var done = function(data){
      // console.log(data);
      window.location.reload();
    };

    sendRequest(path, formData, done);
  });

});


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







// TODO: Fixed when evaluation is already on the process of submitting submit.