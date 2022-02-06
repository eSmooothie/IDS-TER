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
    console.log("docs ready");

    load_rating();
});

var computing_interval = null

$(document).ajaxStart(function(){
    console.log("Loading...");
    let text = "Computing";
    var start = 1;
    computing_interval = setInterval(function(){
        for(let i = 0; i < start; i++){
            text += ".";
        }
        document.getElementById("rating_loading_msg").innerHTML = text;
        
        start += 1;
        if(start == 4){
            start = 1;
        }
        text = "Computing";
    },500);
});

$(document).ajaxStop(function(){
    console.log("Done.");
    clearInterval(computing_interval);
    document.getElementById("rating_loading").classList.add("hidden");
});

function load_rating(){
    var school_year = 1;
    var method = 'get';
    var path = '/teacher/rating/breakdown/'+ school_year;

    const tr = document.createElement("tr");
    const th = document.createElement("th");
    const td = document.createElement("td");
    const tbody = document.getElementById("teacherRating");
    
    var done = function(data, textStatus, xhr ){
        // console.log(data);

        let student_rating = data['student_rating'];
        let peer_rating = data['peer_rating'];
        let supervisor_rating = data['supervisor_rating'];

        let all_rating = {};
        

        for(let i = 1; i <= 21; i++){
            all_rating[i] = {"STUDENT":null, "PEER":null, "SUPERVISOR":null};
        }

        // STUDENT
        let question_no = 1;
        for (const key in student_rating['RATING']) {
            if (Object.hasOwnProperty.call(student_rating['RATING'], key)) {
                const value = student_rating['RATING'][key];
                
                all_rating[question_no]["STUDENT"] = round(value['avg']);
            }
            question_no += 1;
        }

        // PEER
        question_no = 1;
        for (const key in peer_rating['RATING']) {
            if (Object.hasOwnProperty.call(peer_rating['RATING'], key)) {
                const value = peer_rating['RATING'][key];
                
                all_rating[question_no]["PEER"] = round(value['avg']);
            }
            question_no += 1;
        }

        // SUPERVISOR
        question_no = 1;
        for (const key in supervisor_rating['RATING']) {
            if (Object.hasOwnProperty.call(supervisor_rating['RATING'], key)) {
                const value = supervisor_rating['RATING'][key];
                
                all_rating[question_no]["SUPERVISOR"] = round(value['avg']);
            }
            question_no += 1;
        }

        // console.log(all_rating);
        // display rating
        for(let i = 1; i <= 21; i++){
            let student = all_rating[i]["STUDENT"];
            let peer = all_rating[i]["PEER"];
            let supervisor = all_rating[i]["SUPERVISOR"];

            let ctr = tr.cloneNode();
            ctr.classList.add("text-gray-600");

            let cth = th.cloneNode();
            cth.classList.add("py-1", "px-6", "text-sm", "font-medium", "whitespace-nowrap", "text-left");
            cth.innerHTML = i;

            let student_td = td.cloneNode();
            student_td.classList.add("py-1", "px-6", "text-sm", "font-medium", "whitespace-nowrap");
            student_td.innerHTML = (student !== null)? student:"";

            let peer_td = td.cloneNode();
            peer_td.classList.add("py-1", "px-6", "text-sm", "font-medium", "whitespace-nowrap");
            peer_td.innerHTML = (peer !== null)?peer:"";
            
            let supervisor_td = td.cloneNode();
            supervisor_td.classList.add("py-1", "px-6", "text-sm", "font-medium", "whitespace-nowrap");
            supervisor_td.innerHTML = (supervisor !== null)? supervisor:"";

            ctr.append(cth);
            ctr.append(student_td);
            ctr.append(peer_td);
            ctr.append(supervisor_td);

            tbody.append(ctr);
        }

        let studentOverall = round(student_rating['OVERALL']);
        let peerOverall = round(peer_rating['OVERALL']);
        let supervisorOverall = round(supervisor_rating['OVERALL']);

        let overall = round(data['overall']);

        document.getElementById("studentOverall").innerHTML = studentOverall;
        document.getElementById("peerOverall").innerHTML = peerOverall;
        document.getElementById("supervisorOverall").innerHTML = supervisorOverall;

        document.getElementById("Overall").innerHTML = overall;


        document.getElementById("teacherOverall").classList.remove("hidden");
    }
    var fail = function(xhr,textStatus,errorMessage){
        console.log(xhr);
    }

    sendRequest(path, null, done, fail, method);
}

function round(num){
    return Number.parseFloat(num * 10).toFixed(2);
}