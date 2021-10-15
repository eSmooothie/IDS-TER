$(document).ready(function(){
  $('.searchTeacher').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $(".tBodyTeacher tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
