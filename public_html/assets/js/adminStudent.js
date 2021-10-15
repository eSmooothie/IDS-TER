$(document).ready(function(){var loading=$('#loading').modal('hide');$(document).ajaxStart(function(){console.log("loading");loading.modal('show');}).ajaxStop(function(){});$('.searchStudent').on('keyup',function(){var value=$(this).val().toLowerCase();$(".tbodyStudents tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)});});$("#filterBtn").on('click',function(){$("#filterContainer").toggle("fast");if($("#filterIcon").hasClass("fa-chevron-right")){$("#filterIcon").removeClass("fa-chevron-right");$("#filterIcon").addClass("fa-chevron-left");$("#studentsColContainer").removeClass("col");$("#studentsColContainer").addClass("col-7");}else{$("#filterIcon").addClass("fa-chevron-right");$("#filterIcon").removeClass("fa-chevron-left");$("#studentsColContainer").removeClass("col-7");$("#studentsColContainer").addClass("col");}});});function sendPostRequest(path,formData,done=function(data){},fail=function(xhr,textStatus,errorMessage){console.log(xhr);}){var baseUrl="http://dev-ter-ids:9094/";var url=baseUrl+path;$.ajax({type:'post',url:url,data:formData,}).done(done).fail(fail);}
$("#addNewStudents").submit(function(e){e.preventDefault();var form=document.getElementById('addNewStudents');var formData=new FormData(form);var path="admin/student/add/csv";var baseUrl="http://dev-ter-ids:9094/";var url=baseUrl+path;var done=function(data){window.location.reload();};var fail=function(xhr,textStatus,errorMessage){console.log(xhr);};$.ajax({type:'post',url:url,data:formData,cache:false,contentType:false,processData:false,}).done(done).fail(fail);});

$(document).ready(function(){
  $('.searchStudent').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $(".tbodyStudents tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
      });
});
