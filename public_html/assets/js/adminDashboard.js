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

$("#newSchoolYear").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  // console.log(formData);

  var path = "admin/schoolyear/new";
  var done = function(data){
    if(data['data'] == null){
      $("#errMessage").html(data['message']);
    }else{
      window.location.reload();
    }
  };
  sendRequest(path, formData, done);
});
