const tr = document.createElement("tr");
const th = document.createElement("th");
const td = document.createElement("td");

var pageNumber = 0;
var searchKeyword = ""; 

$(document).ready(
    function(){
        
    $("#filterBtn").on('click',function(){
        $("#filterContainer").toggle("fast");
        if($("#filterIcon").hasClass("fa-chevron-right")){
            $("#filterIcon").removeClass("fa-chevron-right");
            $("#filterIcon").addClass("fa-chevron-left");
        }else{
            $("#filterIcon").addClass("fa-chevron-right");
            $("#filterIcon").removeClass("fa-chevron-left");
        }
    });

    $('.searchStudent').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        searchKeyword = value;
        pageNumber = 0;
        loadStudent();
    });

    loadStudent();
});

function pagination(value){
    if(pageNumber + value < 0){
        return;
    }
    pageNumber = pageNumber + value;

    loadStudent();
}

function loadStudent(){
    const tableBody = document.getElementById("studentContainer");
    document.getElementById("pageNumber").innerHTML = "Page "+ (pageNumber + 1);
    // clear the table body first
    while(tableBody.firstChild){
        tableBody.removeChild(tableBody.firstChild);
    }

    let formData = {
        "pageNumber" : pageNumber,
        "keyword" : searchKeyword,
    };

    const baseUrl=window.location.origin;
    const url=baseUrl+"/list/student";
    // send get request
    $.ajax({type:'get',url:url,data:formData,})
    .done(function(data){
        studentData = data["data"];
        console.log(data);
        for (let index = 0; index < studentData.length; index++) {
            const element = studentData[index];
            let id = element["STUDENT_ID"];
            let fn = element["STUDENT_FN"];
            let ln = element["STUDENT_LN"];
            let section = element["SECTION_NAME"];
            let bg_status = element["STATUS"] == 1? "bg-green-300":"bg-gray-300";
            let status = element["STATUS"] == 1? "CLEARED":"NOT CLEARED";
            const nod = generateTableRow({
                id:id, 
                fn:fn, 
                ln:ln, 
                section:section, 
                status:status,
                bg_status:bg_status,
            });

            tableBody.append(nod);
        }
    }).fail(function(error){
        console.log(error);
    });
}

function generateTableRow({id,fn,ln,section,status, bg_status,} = {}){
    const studentContainer = tr.cloneNode();
    studentContainer.classList.add("bg-white");
    studentContainer.classList.add("border-b");
    studentContainer.classList.add("text-gray-500");
    studentContainer.classList.add("hover:bg-gray-200");

    const idContainer = th.cloneNode();
    idContainer.setAttribute("scope","row");
    idContainer.classList.add("py-4");
    idContainer.classList.add("px-6");
    idContainer.classList.add("text-sm");
    idContainer.classList.add("font-medium");
    idContainer.classList.add("text-gray-900");
    idContainer.classList.add("whitespace-nowrap");
    idContainer.innerHTML = id;

    const fnContainer = td.cloneNode();
    fnContainer.classList.add("py-4");
    fnContainer.classList.add("px-6");
    fnContainer.classList.add("text-sm");
    fnContainer.classList.add("whitespace-nowrap");
    fnContainer.innerHTML = fn;

    const lnContainer = td.cloneNode();
    lnContainer.classList = fnContainer.classList;
    lnContainer.innerHTML = ln;

    const sectionContainer = td.cloneNode();
    sectionContainer.classList = fnContainer.classList;

    sectionContainer.innerHTML = (section == null)? "NO SECTION": section;
    
    const statusContainer = td.cloneNode();
    statusContainer.classList = fnContainer.classList;
    statusContainer.classList.add("text-center");
    statusContainer.classList.add(bg_status);
    statusContainer.innerHTML = status;

    const linkContainer = td.cloneNode();
    const baseUrl = window.location.origin;
    const link = "<a href=\""+ baseUrl +"/admin/student/view/"+ id +"\" class=\"text-blue-600 hover:text-blue-900\">View</a>";
    linkContainer.classList = fnContainer.classList;
    linkContainer.classList.add("text-center");
    linkContainer.innerHTML = link;
    

    studentContainer.appendChild(idContainer);
    studentContainer.appendChild(fnContainer);
    studentContainer.appendChild(lnContainer);
    studentContainer.appendChild(sectionContainer);
    studentContainer.appendChild(statusContainer);
    studentContainer.appendChild(linkContainer);

    return studentContainer;
}

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
        nod.classList.add("border", "rounded-md", "p-2", "border-black","mb-1");

        alert("Total enrolled student\nSuccess: "+ success.length +"\nFailed: "+ failed.length);
        
        for (let i = 0; i < success.length; i++) {
            const e = success[i];
            
            const copyNod = nod.cloneNode();
            copyNod.classList.add("bg-green-300","text-black");
            copyNod.innerHTML = e;

            container.appendChild(copyNod);
        }

        for (let i = 0; i < failed.length; i++) {
            const e = failed[i];
            
            const copyNod = nod.cloneNode();
            copyNod.classList.add("bg-red-300","text-black");
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
        nod.classList.add("border", "rounded-md", "p-2", "border-black","mb-1");
    
        if(message === "SUCCESS"){
            nod.classList.add("bg-green-300","text-black");
            nod.innerHTML = "(Success) " + studentData;
        }else{
            nod.classList.add("bg-red-300","text-black");
            nod.innerHTML = "(Failed) " + studentData;
        }
        container.prepend(nod);
        form.reset();
    };
    sendPostRequest(path, formData, done);
});
