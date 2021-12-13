$(document).ready(
    function(){
        var loading=$('#loading').modal('hide');
        $(document).ajaxStart(
            function(){
                loading.modal('show');
            }).ajaxStop(function(){});
        $('.searchStudent').on('keyup',function(){
            var value=$(this).val().toLowerCase();
            $(".tbodyStudents tr").filter(function(){
                $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value)>-1)
                });
            });
        $("#filterBtn").on('click',function(){
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
                $("#studentsColContainer").addClass("col");}
            });
        });

function sendPostRequest(
    path,
    formData,
    done=function(data){},
    fail=function(xhr,textStatus,errorMessage){console.log(xhr);}
    ){
        var baseUrl=window.location.origin;
        var url=baseUrl+path;
        $.ajax({type:'post',url:url,data:formData,}).done(done).fail(fail);
    }

$("#bulk").submit(function(e){
    e.preventDefault();
  
    var form = document.getElementById('bulk');

    var formData=new FormData(form);

    var path="/admin/student/add/csv";

    var baseUrl=window.location.origin;
    var url=baseUrl+path;

    var done=function(data){
        // window.location.reload();
        // console.log(data);

        const container = document.getElementById("server_message");

        let success = data['studentList']['success'];
        let failed = data['studentList']['fail'];

        const nod = document.createElement('div');
        nod.classList.add("border", "rounded", "p-2", "bg-gradient","mb-1");

        alert("Total enrolled student\nSuccess: "+ success.length +"\nFailed: "+ failed.length);
        
        for (let i = 0; i < success.length; i++) {
            const e = success[i];
            
            const copyNod = nod.cloneNode();
            copyNod.classList.add("bg-success","text-white");
            copyNod.innerHTML = e;

            container.appendChild(copyNod);
        }

        for (let i = 0; i < failed.length; i++) {
            const e = failed[i];
            
            const copyNod = nod.cloneNode();
            copyNod.classList.add("bg-danger","text-white");
            copyNod.innerHTML = e;

            container.appendChild(copyNod);
        }
    };
    var fail=function(xhr,textStatus,errorMessage){
        console.log(xhr);
    };
    
    $.ajax({
        type:'post',
        url:url,
        data:formData,
        cache:false,
        contentType:false,
        processData:false,
    }).done(done).fail(fail);
});

$("#individual").submit(function(e){
    e.preventDefault();

    let formData = $(this).serializeArray();

    console.log(formData);

    var path = "/admin/student/add/individual";
    var done = function(data){
        // window.location.reload();
        console.log(data);

        const container = document.getElementById("server_message");
        const form = document.getElementById("individual");

        let message = data['message'];
        let studentData = data['data'];

        const nod = document.createElement('div');
        nod.classList.add("border", "rounded", "p-2", "bg-gradient","mb-1");
    
        if(message === "SUCCESS"){
            nod.classList.add("bg-success","text-white");
            nod.innerHTML = "(Success) " + studentData;
        }else{
            nod.classList.add("bg-danger","text-white");
            nod.innerHTML = "(Failed) " + studentData;
        }
        container.prepend(nod);
        form.reset();
    };
    sendPostRequest(path, formData, done);
});

$(document).ready(function(){
  $('.searchStudent').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $(".tbodyStudents tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
      });
});
