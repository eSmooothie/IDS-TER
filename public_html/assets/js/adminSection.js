var toEnroll = [];

$(document).ready(function(){
  // do something

  // search
  $('.searchStudent').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $(".tbodyStudents tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

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

function remove(element){
  var value = element.value;
  var trData = document.getElementById(value);
  var toAllStudentBody = document.getElementById('tbodyStudentsE');
  trData.children[3].innerHTML = "<button onclick=\"add(this);\" class=\"btn btn-primary studentDataE\" type=\"button\" name=\"button\" value=\""+value+"\">"+
    "<i class=\"fas fa-plus\"></i>"+
    "</button>";
  toAllStudentBody.prepend(trData);

  let index = toEnroll.indexOf(value);
  if(index > -1){
    toEnroll.splice(index,1);
  }
}

function add(element){
  var value = element.value;
  var trData = document.getElementById(value);
  var toEnrollTbody = document.getElementById('tbodyEnrollee');
  trData.children[3].innerHTML = "<button onclick=\"remove(this);\" class=\"btn btn-danger removeEnrollee\" type=\"button\" name=\"button\" value=\""+value+"\">"+
    "<i class=\"fas fa-times\"></i>"+
    "</button>";
  toEnrollTbody.append(trData);
  toEnroll.push(value);
}

$("#bulkEnroll").submit(function(e){
  e.preventDefault();
  var form = document.getElementById('bulkEnroll');
  var formData = new FormData(form);
  // console.log(formData);

  let baseUrl = window.location.origin;
  let apiPath = "/admin/section/student/enroll/csv";
  let url = baseUrl + apiPath;

  $.ajax({
    type: 'post',
    url: url,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
      // do something
      // console.log(data);

      window.location.reload();
    },
    error: function(xhr, textStatus, errorMessage){
      // do something
      // console.log(xhr.responseJSON);
      $("#ServerErrContainer").removeClass("d-none");
      document.getElementById('ServerErrMessage').innerHTML = xhr.responseJSON['message'];
    }
  });
});

$("#enroll").on("click",function(){

  if(toEnroll.length > 0){
    var path = "admin/section/student/enroll";
    var formData = {
                    'enrollee':toEnroll,
                    'id': $(this).val(),
                    };
    var done = function(data){
      // console.log(data);
      window.location.reload();
    }
    sendPostRequest(path, formData, done);
  }

});

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
