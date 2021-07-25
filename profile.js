// Ajax call for updateusernameform form
$("#updateusernameform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    $.ajax({
        url: "updateusername.php",
        type:"POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updateusernamemsg").html(data);
            }
            else{
                location.reload();
            }
        },
        error: function(){
            $("#updateusernamemsg").html("<div class='alert alert-danger'>There is an error in Ajax call</div>");
        }
    });

});


// Ajax call for updateusernameform form
$("#updatepasswordform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    //console.log(datatopost);
    $.ajax({
        url: "updatepassword.php",
        type:"POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updatepasswordmsg").html(data);
            }
            
        },
        error: function(){
            $("#updatepasswordmsg").html("<div class='alert alert-danger'>there is error, pls</div>");
        }
    });
    this.reset();

});


// Ajax call for updateusernameform form
$("#updateemailform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    //console.log(datatopost);
    $.ajax({
        url: "updateemail.php",
        type:"POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updateemailmsg").html(data);
            }
            
        },
        error: function(){
            $("#updateemailmsg").html("<div class='alert alert-danger'>there is error, pls</div>");
        }
    });
    this.reset();

});