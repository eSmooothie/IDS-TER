var toEnroll = [];
var rawdata_enrollee = {};
// set the modal menu element
const confirmation_enrollee_modal_target = document.getElementById('confirmation-enrollee-modal');

// options with default values
const options = {
    placement: 'center-center',
    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
    onHide: () => {
        console.log('modal is hidden');
    },
    onShow: () => {
        console.log('modal is shown');
    },
    onToggle: () => {
        console.log('modal has been toggled');
    }
};

var confirmation_enrollee_modal;

var to_enroll_students_formdata;

$(document).ready(function () {
    confirmation_enrollee_modal = new Modal(confirmation_enrollee_modal_target, options);

    var updateSectionSubject = document.getElementById('updateSectionSubject');
    if (updateSectionSubject != null) {
        updateSectionSubject.addEventListener("click", function () {
            var sectionSubjectTbody = document.getElementById('sectionSubjectTbody');
            var subjectTr = sectionSubjectTbody.children;
            var teachers = [];
            var subjects = [];
            for (var indx in subjectTr) {
                if (subjectTr.hasOwnProperty(indx)) {
                    const teacherId = subjectTr[indx].id;
                    const subjectId = subjectTr[indx].children[2].children[0].id;
                    teachers.push(teacherId);
                    subjects.push(subjectId);
                }
            }
            var formData = {
                'sectionId': this.value,
                'teachers[]': teachers,
                'subjects[]': subjects,
            }
            var path = "/admin/section/subject/update";
            var done = function (data) {
                window.location.reload();
            };
            sendPostRequest(path, formData, done);
        });
    }
    $('.searchStudent').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $(".tbodyStudents tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $('.searchSubject').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $(".tbodySubjects tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function sendPostRequest(path, formData, done = function (data) {}, fail = function (xhr, textStatus, errorMessage) {
    console.log(xhr);
}) {
    var baseUrl = window.location.origin;
    var url = baseUrl + path;
    $.ajax({
        type: 'post',
        url: url,
        data: formData,
    }).done(done).fail(fail);
}

function changeEditContainer(container) {
    var container1 = document.getElementById('enrollStudentContainer');
    var container2 = document.getElementById('editSubjectContainer');
    var container3 = document.getElementById('editSectionContainer');
    if (container == 1) {
        var path = window.location.origin + window.location.pathname + "?stab=enroll";
        window.location.replace(path);
    } else if (container == 2) {
        var path = window.location.origin + window.location.pathname + "?stab=subject";
        window.location.replace(path);
    } else if (container == 3) {
        var path = window.location.origin + window.location.pathname + "?stab=profile";
        window.location.replace(path);
    }
}

function appendSubject(element) {
    var subjectId = element.id;
    var cloneTrNode = element.parentElement.parentElement.cloneNode(true);
    cloneTrNode.children[2].innerHTML = "<button id=" + subjectId + " type=\"button\" name=\"button\" " +
        "class=\"bg-red-300 px-4 py-3 rounded-md\" onclick=\"removeSubject(this);\">" +
        "<i class=\"fas fa-times\"></i></button>";
    var sectionSubjectTbody = document.getElementById('sectionSubjectTbody');
    sectionSubjectTbody.prepend(cloneTrNode);
    var message = document.getElementById('SystemMessageSubject');
    var subjectName = cloneTrNode.children[0].innerHTML;
    message.classList.remove("hidden");
    message.innerHTML = "Added " + subjectName;
    setTimeout(function () {
        message.classList.add("hidden");
        message.innerHTML = "";
    }, 2000);
}

function removeSubject(element) {
    var subjectId = element.value;
    var trData = element.parentElement.parentElement;
    trData.children[2].innerHTML = "<button id=\"" + subjectId + "\" type=\"button\" name=\"button\" " +
        "class=\"bg-blue-300 px-4 py-3 rounded-md\" onclick=\"appendSubject(this);\">" +
        "<i class=\"fas fa-plus\"></i></button>";
    var sectionSubjectTbody = document.getElementById('sectionSubjectTbody');
    sectionSubjectTbody.removeChild(trData);
}

function remove(element) {
    var value = element.value;
    var trData = document.getElementById(value);
    var toAllStudentBody = document.getElementById('tbodyStudentsE');
    trData.children[3].innerHTML = "<button onclick=\"add(this);\" class=\"bg-blue-300 px-4 py-3 rounded-md studentDataE\" type=\"button\" name=\"button\" value=\"" + value + "\">" + "<i class=\"fas fa-plus\"></i>" + "</button>";
    toAllStudentBody.prepend(trData);
    let index = toEnroll.indexOf(value);
    delete rawdata_enrollee[value];
    if (index > -1) {
        toEnroll.splice(index, 1);
    }
}

function add(element) {
    var value = element.value;
    var trData = document.getElementById(value);
    var toEnrollTbody = document.getElementById('tbodyEnrollee');
    trData.children[3].innerHTML = "<button onclick=\"remove(this);\" class=\"bg-red-300 px-4 py-3 rounded-md removeEnrollee\" type=\"button\" name=\"button\" value=\"" + value + "\">" + "<i class=\"fas fa-times\"></i>" + "</button>";
    toEnrollTbody.append(trData);

    rawdata_enrollee[value] = {
        'fn':trData.children[2].textContent,
        'ln':trData.children[1].textContent,
        'id':value
    }

    toEnroll.push(value);
}
$("#editSectionForm").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serializeArray();
    var path = "/admin/section/update";
    var done = function (data) {
        window.location.reload();
    };
    sendPostRequest(path, formData, done);
});

$("#removeSectionForm").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serializeArray();
    var path = "/admin/section/remove";
    var done = function (data) {
        const isMatch = data['data'];
        // console.log(isMatch);
        if (isMatch) {
            window.location.href = "/admin/section";
        } else {
            document.getElementById('feedback').classList.remove('hidden');
        }
    }
    sendPostRequest(path, formData, done);
});

$("#bulkEnroll").submit(function (e) {
    e.preventDefault();
    var form = document.getElementById('bulkEnroll');
    var formData = new FormData(form);
    let baseUrl = window.location.origin;
    let apiPath = "/admin/section/student/enroll/csv";
    let url = baseUrl + apiPath;
    $.ajax({
        type: 'post',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            window.location.reload();
        },
        error: function (xhr, textStatus, errorMessage) {
            $("#ServerErrContainer").removeClass("hidden");
            document.getElementById('ServerErrMessage').innerHTML = xhr.responseJSON['message'];
        }
    });
});

$("#enroll").on("click", function () {
    if (toEnroll.length > 0) {
        
        var formData = {
            'enrollee': toEnroll,
            'id': $(this).val(),
        };
        
        $("#list-of-students-to-enroll").empty();

        var list_of_student_to_enroll_element = document.getElementById('list-of-students-to-enroll');
       
        for (const key in rawdata_enrollee) {
            if (Object.hasOwnProperty.call(rawdata_enrollee, key)) {
                const student = rawdata_enrollee[key];
                var li = document.createElement("li");
                li.innerHTML = student.ln + ", " + student.fn + " (" + student.id + ")";

                list_of_student_to_enroll_element.append(li);
            }
        }

        confirmation_enrollee_modal.toggle();
        // toggle the modal
       

        to_enroll_students_formdata = formData;
        // console.log(formData);
    }
});


$(".confirmation-enrollment-modal-close").on('click',function(e){
    e.preventDefault();
    confirmation_enrollee_modal.toggle();
});

$(".confirmation-enrollment-modal-accept").on('click',function(e){
    e.preventDefault();
    var path = "/admin/section/student/enroll";
    var done = function (data) {
        // console.log(data);
        window.location.reload();
    }
    // console.log(to_enroll_students_formdata);
    sendPostRequest(path, to_enroll_students_formdata, done);
});

$("#newSection").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serializeArray();
    var path = "/admin/section/new";
    var done = function (data) {
        window.location.reload();
    }
    sendPostRequest(path, formData, done);
});
