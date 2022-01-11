function sendRequest(
  path,
  formData,
  done = function(data){},
  fail = function(xhr, textStatus, errorMessage){},
){
  var baseUrl = window.location.origin;
  var url = baseUrl  + path;
  $.ajax({
    type:"post",
    url:url,
    data:formData,
  }).done(done).fail(fail);
}


$("#changePassword").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();
  var newPassword = formData[1]['value'];
  var confirmPassword = formData[2]['value'];
  var path = "/user/student/update/password";
  $("#errMessage").removeClass("hidden");
  if(newPassword.localeCompare(confirmPassword) != 0){
    // display error
    $("#errMessage").removeClass("bg-green-300");
    $("#errMessage").addClass("bg-red-500");
    $("#errMessage").html("Confirm password not match.");
    $("#confirmPassword").val("");
  }else{
    $("#errMessage").html("");
    var done = function(data){
      var d = data['data'];
      if(d == null){
        $("#errMessage").removeClass("bg-green-300");
        $("#errMessage").addClass("bg-red-500");
        $("#errMessage").html(data['message']);
        $("#confirmPassword").val("");
        $("#newPassword").val("");
        $("#oldPassword").val("");
      }else{
        $("#errMessage").removeClass("bg-red-500");
        $("#errMessage").addClass("bg-green-300");
        $("#errMessage").html(data['message']);
        $("#confirmPassword").val("");
        $("#newPassword").val("");
        $("#oldPassword").val("");
      }
    };
    sendRequest(path, formData, done);
  }
});
