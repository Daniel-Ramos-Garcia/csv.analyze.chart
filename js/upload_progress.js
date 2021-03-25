function upload_csv() 
{
    $('#output_comment').html('');
    $("#output_comment").empty();
    
    $('#myForm').ajaxForm({
        
        beforeSubmit: function() {
            horizontalNoTitle();

        },

        uploadProgress: function(event, position, total, percentComplete) {
            console.log(percentComplete);
        },
        
        success: function() {
            console.log('success');
            loadingOut(loading);
        },

        complete: function(xhr) {
            if(xhr.responseText)
            {
                document.getElementById("output_comment").innerHTML=xhr.responseText;
            }
        }
    }); 
}