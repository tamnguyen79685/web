$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $(".confirmdelete").click(function () {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    "/admin/delete-" + record + "/" + recordid;
            }
        });
    });
    $('.updatequestion').click(function(){
        // alert(1);
        var recordid=$(this).attr('recordid');
        var grade_id=$(this).attr('gradeid');
        var exam_id=$(this).attr('examid');
        $.ajax({
            url:'admin/update-question',
            type:'post',
            data:{
                recordid:recordid,
                examid:exam_id
            },
            success:function(resp){
                if(resp['status']==true){
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                "/admin/questions/grade/" + grade_id + "/exam/" + exam_id;
                        }
                    });
                }
            },
            error:function(){
                alert('ERROR');
            }
        })
    })
    $(".select-all").click(function () {
        if (this.checked) {
            $(".sub_ck").each(function () {
                this.checked = true;
            });
        } else {
            $(".sub_ck").each(function () {
                this.checked = false;
            });
        }
    });
    $(".delete-all").click(function () {
        var allVals = [];
        $(".sub_ck:checked").each(function () {
            allVals.push($(this).attr("data-id"));
        });
        if (allVals.length <= 0) {
            alert("Please select row.");
        } else {
            var record = $(this).attr("record");
            var check = confirm("Are you sure you want to delete?");
            if (check == true) {
                var join_selected_values = allVals.join(",");
                $.ajax({
                    url: "/admin/delete-all/" + record,
                    type: "GET",
                    data: {
                        ids: join_selected_values,
                        // check:check
                    },
                    success: function (resp) {
                        if (resp["status"] == true) {
                            $(".sub_ck:checked").each(function () {
                                $(this).parents("tr").remove();
                            });
                            // alert(resp['success_message']);
                        }
                    },
                    error: function () {
                        alert("ERROR");
                    },
                });
            }
        }
    });

    $(".sub_ck").click(function () {
        var allquestion_ids = [];
        // var allsubject_ids = [];
        $(".sub_ck:checked").each(function () {
            allquestion_ids.push($(this).attr("data-id"));
            // allsubject_ids.push($(this).attr('data-subject'));
        });
        if (allquestion_ids.length == 0) {
            alert("You must select at least 1 question");
        } else {
            $(".trythis").change(function () {
                var alls=allquestion_ids.join(",");
                var grade_id = $(this).children(':selected').attr("data-grade");
                var subject_id=$(this).children(':selected').attr('data-subject');
                var exam_id = $(this).children(':selected').attr("data-examid");
                $('.submit-question').click(function(){
                    $.ajax({
                        url: "admin/choose-question",
                        type: "post",
                        data: {
                            allquestion_ids: alls,
                            exam_id: exam_id,
                            // grade_id:grade_id
                        },
                        success: function (resp) {
                            if(resp['status']==true){
                                alert('Insert Successfully Questions in the Exam');
                                window.location.href =
                                    "/admin/questions/subject/" + subject_id+"/grade/"+grade_id;
                            }
                        },
                        error: function () {
                            alert("ERROR");
                        },
                    });
                })

            });
        }
    });
    $("#appendgradeid").change(function () {
        var grade_id = $(this).val();
        // alert(grade_id);
        $.ajax({
            url: "/admin/append/class",
            type: "POST",
            data: {
                grade_id: grade_id,
            },
            success: function (resp) {
                // console.log(resp['getgrades']['class']);
                var answer;
                resp["getgrades"]["class"].forEach(function (obj) {
                    // alert(obj['name']);
                    answer +=
                        '<option value="' +
                        obj["id"] +
                        '">' +
                        obj["name"] +
                        "</option>";
                }),
                    $("#appendclasseslevel").html(
                        '<div class="form-group">' +
                            '<div class="form-group">' +
                            '<label for="exampleInputEmail1">Classes</label>' +
                            '<select name="class_id" class="form-control select2" required>' +
                            answer +
                            "</select>" +
                            "</div>" +
                            "</div>"
                        // alert(obj['name']);
                    );
            },
            error: function (err) {
                alert("ERROR");
            },
        });
    });

    $("#current_password").keyup(function () {
        var current_password = $(this).val();
        // alert(current_password);
        $.ajax({
            type: "POST",
            url: "/admin/check-update-pwd",
            data: {
                current_password: current_password,
            },
            success: function (resp) {
                // alert(resp);
                if (resp["status"] == false) {
                    $("#chkpwd").html(
                        "<font color=red>Current Password is incorrect</font>"
                    );
                } else {
                    $("#chkpwd").html(
                        "<font color=green>Current Password is correct</font>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    $(".status-question-exam").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/questions-exam",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#question-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#question-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-teacher").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/teacher",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#teacher-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#teacher-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-answer").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/answer",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "False") {
                    $("#answer-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">True</a>'
                    );
                } else {
                    $("#answer-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">False</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-exam").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/exam",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#exam-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#exam-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-student").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/student",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#student-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#student-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-subject").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/subject",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#subject-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#subject-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-grade").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/grade",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#grade-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#grade-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".status-class").click(function () {
        var status = $(this).text();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "/admin/status/class",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function (resp) {
                if (resp["status"] == "Inactive") {
                    $("#class-" + id).html(
                        '<a  href="javascript:void(0)" style="color:green">Active</a>'
                    );
                } else {
                    $("#class-" + id).html(
                        '<a  href="javascript:void(0)" style="color:red">Inactive</a>'
                    );
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
});
var loadfile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
};
