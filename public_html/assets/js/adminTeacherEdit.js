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

$(document).ready(function(){
  //do something
  $('#searchSubject').on('keyup',function(){
    var value=$(this).val().toLowerCase();
    $("#listOfSubject tr").filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
    });
  });
});

$("#profileInformation").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = "admin/teacher/editProfileInfo";
  var done = function(data){
      window.location.reload();
  }
  sendRequest(path,formData,done);
});

$("#changePassword").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();

  var path = "admin/teacher/editPassword";
  var done = function(data){
      // console.log(data);
      window.location.reload();
  }

  sendRequest(path,formData,done);
});

function addSubject(e){
  var parentNode = e.parentNode.parentNode;
  var cloneNode = parentNode.cloneNode(true);
  var buttonElement = cloneNode.children[2];
  buttonElement.innerHTML = "<button type=\"button\" name=\"button\" class=\"btn btn-danger\""+
    "onclick=\"removeSubject(this);\">" +
    "<i class=\"fas fa-times\"></i></button>";

  var mySubjects = document.getElementById('mySubjects');
  mySubjects.append(cloneNode);
}

function removeSubject(e){
  var parentNode = e.parentNode.parentNode;

  var mySubjects = document.getElementById('mySubjects');
  mySubjects.removeChild(parentNode);
}
