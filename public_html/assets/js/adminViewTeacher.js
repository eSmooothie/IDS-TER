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


$(document).ready(function(){
  loadActivity();
});


function loadActivity(){
  var url = window.location.pathname;
  var splitUrl = url.split("/");
  var id = splitUrl[splitUrl.length - 1];
  // console.log(id);
  var path = "/admin/teacher/recentActivity/" + id;
  var done = function(data){
      // window.location.reload();
      // console.log(data);

      var tbody = document.getElementById('activities');

      var activities = data['data']['activities'];
      for (var i = 0; i < activities.length; i++) {
        const activity = activities[i];
        const evalId = activity['EVAL_INFO_ID'];
        const teacherId = activity['TEACHER_ID'];
        const fn = activity['FN'];
        const ln = activity['LN'];
        const date = activity['DATE_EVALUATED'];

        var trNod = document.createElement("tr");
        var activityNod = document.createElement("td");
        var dateNod = document.createElement("td");

        trNod.id = evalId;

        var message = "Done rated <b>"+ ln +", " + fn +"</b>";
        activityNod.innerHTML = message;
        dateNod.innerHTML = date;

        trNod.append(activityNod);
        trNod.append(dateNod);

        tbody.append(trNod);
      }

  }
  sendRequest(path,null,done);
}
