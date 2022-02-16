$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $('#current_password').keyup(function(){
        var current_password=$(this).val();
        $.ajax({
            type: "POST",
            url:'/admin/check-update-pwd',
            data:{
                current_password:current_password
            },
            success: function(resp){
                if (resp['status'] == false) {
                    $("#chkpwd").html(
                        "<font color=red>Current Password is incorrect</font>"
                    );
                } else {
                    $("#chkpwd").html(
                        "<font color=green>Current Password is correct</font>"
                    );
                }
            },
            error:function(){
                alert('error');
            }
        })
    });

});


var loadfile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
};
