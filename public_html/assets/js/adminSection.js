var toEnroll = [];

$(document).ready(function(){
  // do something
  var updateSectionSubject = document.getElementById('updateSectionSubject');
  if(updateSectionSubject != null){
    updateSectionSubject.addEventListener("click",function(){
      var sectionSubjectTbody = document.getElementById('sectionSubjectTbody');
      var subjectTr = sectionSubjectTbody.children;
      var teachers = [];
      var subjects = [];
      for (var indx in subjectTr) {
        if (subjectTr.hasOwnProperty(indx)) {
          const teacherId = subjectTr[indx].id;
          const subjectId = subjectTr[indx].children[2].children[0].id;
          teachers.push(teacherId);
          subjects.push(subjectId);
        }
      }

      var formData = {
        'sectionId' : this.value,
        'teachers[]' : teachers,
        'subjects[]' : subjects,
      }

      var path = "/admin/section/subject/update";
      var done = function(data){
        // console.log(data);
        window.location.reload();
      };
      sendPostRequest(path, formData, done);
    });
  }


  // search
  $('.searchStudent').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $(".tbodyStudents tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  $('.searchSubject').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $(".tbodySubjects tr").filter(function() {
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

function changeEditContainer(container){
  var container1 = document.getElementById('enrollStudentContainer');
  var container2 = document.getElementById('editSubjectContainer');
  var container3 = document.getElementById('editSectionContainer');

  if(container == 1){
    container1.classList.remove("d-none");
    container2.classList.remove("d-block");
    container3.classList.remove("d-block");

    container1.classList.add("d-block");
    container2.classList.add("d-none");
    container3.classList.add("d-none");
  }else if(container == 2){
    container1.classList.remove("d-block");
    container2.classList.remove("d-none");
    container3.classList.remove("d-block");

    container1.classList.add("d-none");
    container2.classList.add("d-block");
    container3.classList.add("d-none");
  }else if(container == 3){
    container1.classList.remove("d-block");
    container2.classList.remove("d-block");
    container3.classList.remove("d-none");

    container1.classList.add("d-none");
    container2.classList.add("d-none");
    container3.classList.add("d-block");
  }
}

function appendSubject(element){
  var subjectId = element.id;
  var cloneTrNode = element.parentElement.parentElement.cloneNode(true);
  cloneTrNode.children[2].innerHTML = "<button id="+ subjectId +" type=\"button\" name=\"button\" "
                                  + "class=\"btn btn-danger\" onclick=\"removeSubject(this);\">"
                                  + "<i class=\"fas fa-times\"></i></button>";

  var sectionSubjectTbody = document.getElementById('sectionSubjectTbody');

  sectionSubjectTbody.prepend(cloneTrNode);

  var message = document.getElementById('SystemMessageSubject');
  var subjectName = cloneTrNode.children[0].innerHTML;
  message.innerHTML = "Add "+ subjectName;

  setTimeout(function(){
    message.innerHTML = "";
  }, 5000);
}

function removeSubject(element){
  var subjectId = element.value;
  var trData = element.parentElement.parentElement;
  trData.children[2].innerHTML = "<button id=\""+ subjectId +"\" type=\"button\" name=\"button\" "
                                  + "class=\"btn btn-primary\" onclick=\"appendSubject(this);\">"
                                  + "<i class=\"fas fa-plus\"></i></button>";

  var sectionSubjectTbody = document.getElementById('sectionSubjectTbody');
  sectionSubjectTbody.removeChild(trData);

  var message = document.getElementById('SystemMessageSubject');
  var subjectName = trData.children[0].innerHTML;
  message.innerHTML = "Remove "+ subjectName;

  setTimeout(function(){
    message.innerHTML = "";
  }, 5000);
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
