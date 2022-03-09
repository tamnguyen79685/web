
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.select-all').click(function(){
        if(this.checked) {
            $('.sub_ck').each(function(){
                this.checked=true;
            });
        }else{
            $('.sub_ck').each(function(){
                this.checked=false;
            });
        }
    });
    $('.delete-all').click(function(){
        var allVals = [];
        $(".sub_ck:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        if(allVals.length <=0)
        {
            alert("Please select row.");
        }else {
            var record=$(this).attr('record');
            var check=confirm('Are you sure you want to delete?');
            if(check==true){
                var join_selected_values = allVals.join(",");
                $.ajax({
                    url:'/admin/delete-all/'+record,
                    type: 'GET',
                    data:{
                        ids:join_selected_values,
                        check:check
                    },
                    success:function(resp){
                        if(resp['status']==true){
                            $(".sub_ck:checked").each(function() {
                                $(this).parents("tr").remove();
                            });
                            // alert(resp['success_message']);
                        }
                    },
                    error:function(){
                        alert('ERROR');
                    }
                });
            }
        }
    });
    $('#appendgradeid').change(function(){
        var grade_id=$(this).val();
        // alert(grade_id);
        $.ajax({
            url:'/admin/append/class',
            type:'POST',
            data:{
                grade_id:grade_id,
            },
            success:function(resp){
                // console.log(resp['getgrades']['class']);
                var aaa;
                resp['getgrades']['class'].forEach(function(obj){
                    // alert(obj['name']);
                    aaa+='<option value="'+obj['id']+'">'+obj['name']+'</option>'
                }),
                $('#appendclasseslevel').html(

                        '<div class="form-group">'+
                            '<div class="form-group">'+
                                '<label for="exampleInputEmail1">Classes</label>'+
                                '<select name="class_id" class="form-control select2" required>'+
                                    aaa
                                +'</select>'+
                            '</div>'+
                        '</div>'
                        // alert(obj['name']);

                );
            },
            error:function(err){
                alert('ERROR');
            }
        });
    });
    $('#current_password').keyup(function(){
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
            error: function () {
                alert("error");
            },
        });
    });
    $('.status-teacher').click(function () {
        var status=$(this).text();
        var id=$(this).attr('data-id');
        $.ajax({
            url:'/admin/status/teacher',
            type: 'POST',
            data:{
                id:id,
                status:status
            },
            success:function(resp){
                if(resp['status']=="Inactive"){
                    $('#teacher-'+id).html('<a  href="javascript:void(0)" style="color:green">Active</a>');
                }else{
                    $('#teacher-'+id).html('<a  href="javascript:void(0)" style="color:red">Inactive</a>')
                }

            },
            error:function(){
                alert('ERROR');
            }
        });
    });
    $('.status-student').click(function () {
        var status=$(this).text();
        var id=$(this).attr('data-id');
        $.ajax({
            url:'/admin/status/student',
            type: 'POST',
            data:{
                id:id,
                status:status
            },
            success:function(resp){
                if(resp['status']=="Inactive"){
                    $('#student-'+id).html('<a  href="javascript:void(0)" style="color:green">Active</a>');
                }else{
                    $('#student-'+id).html('<a  href="javascript:void(0)" style="color:red">Inactive</a>')
                }

            },
            error:function(){
                alert('ERROR');
            }
        });
    });
    $('.status-subject').click(function () {
        var status=$(this).text();
        var id=$(this).attr('data-id');
        $.ajax({
            url:'/admin/status/subject',
            type: 'POST',
            data:{
                id:id,
                status:status
            },
            success:function(resp){
                if(resp['status']=="Inactive"){
                    $('#subject-'+id).html('<a  href="javascript:void(0)" style="color:green">Active</a>');
                }else{
                    $('#subject-'+id).html('<a  href="javascript:void(0)" style="color:red">Inactive</a>')
                }

            },
            error:function(){
                alert('ERROR');
            }
        });
    });
    $('.status-grade').click(function () {
        var status=$(this).text();
        var id=$(this).attr('data-id');
        $.ajax({
            url:'/admin/status/grade',
            type: 'POST',
            data:{
                id:id,
                status:status
            },
            success:function(resp){
                if(resp['status']=="Inactive"){
                    $('#grade-'+id).html('<a  href="javascript:void(0)" style="color:green">Active</a>');
                }else{
                    $('#grade-'+id).html('<a  href="javascript:void(0)" style="color:red">Inactive</a>')
                }

            },
            error:function(){
                alert('ERROR');
            }
        });
    });
    $('.status-class').click(function () {
        var status=$(this).text();
        var id=$(this).attr('data-id');
        $.ajax({
            url:'/admin/status/class',
            type: 'POST',
            data:{
                id:id,
                status:status
            },
            success:function(resp){
                if(resp['status']=="Inactive"){
                    $('#class-'+id).html('<a  href="javascript:void(0)" style="color:green">Active</a>');
                }else{
                    $('#class-'+id).html('<a  href="javascript:void(0)" style="color:red">Inactive</a>')
                }

            },
            error:function(){
                alert('ERROR');
            }
        });
    });
});
var loadfile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
};
// var loadfile1 = function (event) {
//     var output = document.getElementById("output1");
//     output.src = URL.createObjectURL(event.target.files[0]);
// };
