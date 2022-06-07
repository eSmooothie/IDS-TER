$(document).ready(function(e){
  $("#start_yr").change(function(e){
    var start_yr = $(this).val().split("-");
    var month = parseInt(start_yr[1]) + 9;
    
    var from = start_yr[0];
    if(month > 12){
      month = month - 12;
      start_yr[0] = (parseInt(start_yr[0]) + 1).toString();
    }

    start_yr[1] = (month > 9)? month.toString(): "0"+month.toString();

    var to = start_yr[0];
    var end_yr = start_yr.join("-");
    $("#end_yr").val(end_yr);

    check_new_schoolyear(from, to);
  });


  $("#form-new-sy").submit(function(e){
    e.preventDefault();
    var formData = $(this).serializeArray();
    var path = "/admin/new/schoolyear";
    var done = function(data){
      var status_code = data['status_code'];
      if(status_code == 500){
        var err_msg = data['err_message'];

        for (const key in err_msg) {
          if (Object.hasOwnProperty.call(err_msg, key)) {
            const msg = err_msg[key];
            var err_dom = "<p class=\" bg-red-400 px-2 py-3\"><span class=\" font-medium\">Error:</span> "+key+": "+msg+"</p>";
            $("#modal-new-sy-note").after(err_dom);
          }
        }

        $("#form-new-sy").trigger("reset");
      }else{
        window.location.reload();
      }
    };
    sendRequest({
      path:path,
      formData:formData,
      done:done,
    });
  });

  let warnings_len = parseInt($('.sys-msg').length);
  if (warnings_len > 3) {
    $('.sys-msg:gt(2)').hide();
    $('.show-more').removeClass("hidden").addClass("block");
    $('.show-more').text("Show more ("+ (warnings_len - 3).toString() + ")")
  }

  $('.show-more').on('click', function() {
    //toggle elements with class .ty-compact-list that their index is bigger than 2
    $('.sys-msg:gt(2)').toggle();
    //change text of show more element
    let text = "Show more ("+ (warnings_len - 3).toString() +")";
    $(this).text() === text ? $(this).text('Show less') : $(this).text(text);
  });
});

$(document).ajaxStart(function(){
  $("#loading").removeClass("hidden").addClass("block");
});

$(document).ajaxStop(function(){
  $("#loading").removeClass("block").addClass("hidden");
});

function check_new_schoolyear(start_yr, end_yr){
  // check current school year if already exist or not.
  var data = {
    "start_yr" : start_yr,
    "end_yr" : end_yr
  };
  var path = "/admin/check/schoolyear";
  var done = function(data){
    var matches = data['matches'];

    if(matches.length > 0){
      var latest_school_year_match = matches[matches.length - 1];

      var latest_semester = parseInt(latest_school_year_match['SEMESTER']);
      $("#semester").attr('min', latest_semester + 1);
      $("#semester").val(latest_semester + 1);

      $("#retain-student-sec").removeClass("hidden").addClass("flex");
    }else{
      $("#semester").attr('min', 1);
      $("#semester").val(1);
    }
  }
  var fail = function(err,xhr,textStatus){
    console.log(xhr,textStatus);
  }
  
  sendRequest({
    path : path,
    formData : data,
    method : 'get',
    global : false,
    done: done,
    fail: fail
  });
}

function sendRequest({
  path = null,
  formData = null,
  done = function(data){},
  fail = function(xhr,textStatus,errorMessage){},
  method = 'post',
  global = true,
}){
    var baseUrl = window.location.origin;
    var url = baseUrl + path;

    $.ajax({
      type:method,
      url:url,
      data:formData,
      global:global,
    }).done(done).fail(fail);
}


