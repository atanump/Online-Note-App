// Ajax call for signup form
$("#signupform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    $.ajax({
        url: "signup.php",
        type:"POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmsg").html(data);
            }
        },
        error: function(){
            $("#signupmsg").html("<div class='alert alert-danger'>There is an error in Ajax call!</div>");
        }
    });

});

// Ajax call for login form
$("#loginform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    $.ajax({
        url: "login.php",
        type:"POST",
        data: datatopost,
        success: function(data){
            if(data=='success'){
                window.location = "mainpage.php";
            }
            else{
                $('#loginmsg').html(data);
            }
        },
        error: function(){
            $("#loginpmsg").html("<div class='alert alert-danger'>There is an error in Ajax call!</div>");
        }
    });

});


// Ajax call for forgot password form
$("#forgotform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    $.ajax({
        url: "forgotpassword.php",
        type:"POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#forgotpasswordmsg").html(data);
            }
        },
        error: function(){
            $("#forgotpasswordmsg").html("<div class='alert alert-danger'>There is an error in Ajax call!</div>");
        }
    });

});

