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

$("#changeName").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = "/admin/department/change/name";
  var done = function(data){
    window.location.reload();
  };
  var fail = function(xhr, textStatus, errMessage){
  };
  sendRequest(path, formData, done, fail);
});

$("#assignChairperson").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = "/admin/department/change/chairperson";
  var done = function(data){
    window.location.reload();
  };
  var fail = function(xhr, textStatus, errMessage){
  };
  sendRequest(path, formData, done, fail);
});
