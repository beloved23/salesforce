$(function() {
    $('#uploadFile').change(function() {
        var file = this.files[0];
        var imagetype = file.type;
        var extentions = ['image/jpeg', "image/png", "image/jpg", "image/gif"];
        if (extentions.indexOf(imagetype) != -1) {
            var filereader = new FileReader();
            filereader.readAsDataURL(this.files[0]);
            FileUploadAjaxCall();
        } else {
            GlobalValidationAlert("Invalid file selected");
            return false;
        }
    });

});

function FileUploadAjaxCall() {
    $.ajax({
        url: app_url + 'picture/upload',
        type: 'POST',
        data: new FormData($('#uploadMedia').get(0)),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            alert(JSON.stringify(data));
        },
        error: function(error) {
            alert(JSON.stringify(error));
        }
    });
}