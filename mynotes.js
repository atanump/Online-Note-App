$( document ).ready(function(){
    var activeNote = 0;
    var editMode = false;
    // Ajax call for load notes
    $.ajax({
        url: "loadnotes.php",
        type: "GET",
        success: function(data){
            $('#notes').html(data);
            clickonNote();
            clickonDelete();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#notes').html(errorMsg);
          }
    });

    // Ajax call for addnotes
    $('#addnotes').click(function(){
        $.ajax({
            url:"createnotes.php",
            success: function(data){
                if(data == 'error'){
                    $("#alertContent").text("There is an issu inserting new note in database");
                    $("#alert").fadeIn();
                }
                else{
                    activeNote = data;
                    $("#textarea").val("");
                    showHide(["#notepad", "#allnotes"],["#notes", "#addnotes","#edit","#done"]);
                    $("#textarea").focus();
                }
            },
            error: function(){
                $("#notes").html("<div class='alert alert-danger'>there is error, pls</div>");
            }
        });
    });



$("#textarea").keyup(function(){
    // Update note
    $.ajax({
        url:"updatenotes.php",
        type: "POST",
        data:{note:$(this).val(),id:activeNote},
        success: function(data){
            if(data == 'error'){
                $("#alertContent").text("There is an issu inserting new note in database");
                $("#alert").fadeIn();
            }
           
        },
        error: function(){
            $("#loginpmsg").html("<div class='alert alert-danger'>there is error, pls</div>");
        }
    });
})

$('#allnotes').click(function(){
    $.ajax({
        url:"loadnotes.php",
        success: function(data){
            if(data == 'error'){
                $("#alertContent").text("There is an issu inserting new note in database");
                $("#alert").fadeIn();
            }
            else{
                activeNote = data;
                $("#notes").html(data);
                clickonNote();
                clickonDelete();
                showHide(["#notes", "#addnotes","#edit"],["#notepad", "#allnotes"]);
            }
        },
        error: function(){
            $("#loginpmsg").html("<div class='alert alert-danger'>there is error, pls</div>");
        }
    });
});

$('#edit').click(function(){
    $(".noteheader").addClass("col-xs-7 col-sm-9 noteright");
    editMode = true;
    showHide(["#done",".delete"],[this]);
});

$('#done').click(function(){
    $(".noteheader").removeClass("col-xs-7 col-sm-9 noteright");
    editMode = false;
    showHide(["#edit"],[this,".delete"]);
});

function clickonNote(){
    $(".noteheader").click(function(){
        if(!editMode){
            activeNote = $(this).attr("id");
            $("#textarea").val($(this).find('.text').text());
            $("#textarea").focus();
            showHide(["#notepad", "#allnotes"],["#notes", "#addnotes","#edit","#done"]);
            
        }
    });
}
function clickonDelete(){
    $(".delete").click(function(){
        var deleteButton = $(this);
        $.ajax({
            url:"deletenotes.php",
            type: "POST",
            data:{id:deleteButton.prev().attr('id')},
            success: function(data){
                if(data == 'error'){
                    $("#alertContent").text("There is an issu inserting new note in database");
                    $("#alert").fadeIn();
                }
                else{
                    deleteButton.parent().remove();
                }
               
            },
            error: function(){
                $("#loginpmsg").html("<div class='alert alert-danger'>there is error, pls</div>");
            }
        });
    });
}


function showHide(array1, array2){
    for(i=0;i<array1.length;i++){
        $(array1[i]).show();
    }
    for(i=0;i<array2.length;i++){
        $(array2[i]).hide();
    }
}
});

