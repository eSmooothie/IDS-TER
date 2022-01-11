var toEnroll = [];
$(document).ready(function () {
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
        container1.classList.remove("hidden");
        container2.classList.remove("block");
        container3.classList.remove("block");
        container1.classList.add("block");
        container2.classList.add("hidden");
        container3.classList.add("hidden");
    } else if (container == 2) {
        container1.classList.remove("block");
        container2.classList.remove("hidden");
        container3.classList.remove("block");
        container1.classList.add("hidden");
        container2.classList.add("block");
        container3.classList.add("hidden");
    } else if (container == 3) {
        container1.classList.remove("block");
        container2.classList.remove("block");
        container3.classList.remove("hidden");
        container1.classList.add("hidden");
        container2.classList.add("hidden");
        container3.classList.add("block");
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
        var path = "/admin/section/student/enroll";
        var formData = {
            'enrollee': toEnroll,
            'id': $(this).val(),
        };
        var done = function (data) {
            // console.log(data);
            window.location.reload();
        }
        sendPostRequest(path, formData, done);
    }
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
