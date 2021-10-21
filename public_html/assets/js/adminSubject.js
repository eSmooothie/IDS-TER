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
  $('#searchSubject').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $("#subjectTbody tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$('#addNewSubject').submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();
  // console.log(formData);
  var path = "admin/subject/add";
  var done = function(data){
    window.location.reload();
  };
  sendRequest(path, formData, done);
});
