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

    $('#select_sy').on('change', function(){
        let school_year_id = $(this).find(":selected").val();
        get_comments(school_year_id);
    });
    
    get_comments($('#select_sy').find(":selected").val());
});

var computing_interval = null

$(document).ajaxStart(function(){
    console.log("Fetching comments...");
    let text = "Retrieving Comments";
    var start = 1;
    computing_interval = setInterval(function(){
        for(let i = 0; i < start; i++){
            text += ".";
        }
        document.getElementById("loading_msg").innerHTML = text;
        
        start += 1;
        if(start == 4){
            start = 1;
        }
        text = "Retrieving Comments";
    },500);
});

$(document).ajaxStop(function(){
    console.log("Done.");
    clearInterval(computing_interval);
    document.getElementById("loading_msg").classList.add("hidden");
});

function get_comments(school_year_id){
    var method = 'get';
    var path = '/teacher/comments/'+ school_year_id;
    

    
    var done = function(data, textStatus, xhr ){
        // console.log(data);
        var comments = data['comments'];
        
        const comment_container = document.getElementById('commentContainer');
        
        let total_child = comment_container.children.length - 1;
        
        while(total_child > 0){
            comment_container.removeChild(comment_container.lastChild);
            total_child -= 1;
        }

        for(let i = 0; i < comments.length; i++){
            const comment = comments[i]['COMMENT'];
            
            const div = document.createElement('div');
            div.className = "border border-gray-600 mb-4 p-3 rounded-lg";
            const span = document.createElement("span");
            span.classList.add("mb-5");
            
            span.innerHTML = comment;

            div.appendChild(span);
            comment_container.appendChild(div);
        }

        if (comments.length == 0){
            const div = document.createElement('div');
            div.className = "border border-gray-600 mb-4 p-3 rounded-lg";
            const span = document.createElement("span");
            span.classList.add("mb-5");
            
            span.innerHTML = "NO COMMENTS";

            div.appendChild(span);
            comment_container.appendChild(div);
        }
    }
    var fail = function(xhr,textStatus,errorMessage){}

    sendRequest(path, null, done, fail, method);
}   

function round(num){
    return Number.parseFloat(num * 10).toFixed(2);
}