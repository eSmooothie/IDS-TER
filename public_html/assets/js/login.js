function sendPostRequest(path,formData,done=function(data){},fail=function(xhr,textStatus,errorMessage){})
{var baseUrl="http://dev-ter-ids:9094/";var url=baseUrl+path;$.ajax({type:'post',url:url,data:formData,}).done(done).fail(fail);}

$("#adminLogin").submit(function(e){
  e.preventDefault();
  var formData=$(this).serializeArray();
  var path='admin/login';
  done=function(data){
    console.log();
    var isSuc=data['data'];
    if(isSuc){window.location.href="http://dev-ter-ids:9094/admin/dashboard";}
    else{$("#adminLogin").get(0).reset()
    $("#errorMessage").removeClass("d-none");}
  };
  sendPostRequest(path,formData,done);
});

$("#userLogin").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();
  // console.log(formData);

  var path = "user/login";
  var done = function(data){
    console.log(data);
    var msg = data['message'];
    var i = data['data'];
    if(i == null){
      $("#errMsg").html(msg);
      $("#userLogin")[0].reset();
    }else{
      // redirect
      if(i){
        window.location.href = "http://dev-ter-ids:9094/user/teacher";
      }else{
        window.location.href = "http://dev-ter-ids:9094/user/student";
      }
    }
  };
  sendPostRequest(path, formData, done);
});
