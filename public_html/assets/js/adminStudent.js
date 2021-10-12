$(document).ready(function(){
  // do something


  // search
  $('.searchStudent').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $(".tbodyStudents tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  $("#filterBtn").on('click', function(){
    $("#filterContainer").toggle("fast");
    if($("#filterIcon").hasClass("fa-chevron-right")){
      $("#filterIcon").removeClass("fa-chevron-right");
      $("#filterIcon").addClass("fa-chevron-left");
      $("#studentsColContainer").removeClass("col");
      $("#studentsColContainer").addClass("col-7");
    }else{
      $("#filterIcon").addClass("fa-chevron-right");
      $("#filterIcon").removeClass("fa-chevron-left");
      $("#studentsColContainer").removeClass("col-7");
      $("#studentsColContainer").addClass("col");
    }
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
