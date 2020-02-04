var app = angular.module("myApp", []);

//Define Global Notification function
function GlobalSuccessNotification(message) {
    // var positionArrays = ["toast-top-full-width", "toast-top-full-width", "toast-top-full-width",
    //     "toast-bottom-full-width", "toast-bottom-center",
    //     "toast-top-full-width", "toast-top-full-width"
    // ];
    // var ran = Math.floor(Math.random() * 8);
    // toastr.options = {
    //     "closeButton": true,
    //     "debug": false,
    //     "newestOnTop": false,
    //     "progressBar": true,
    //     "positionClass": positionArrays[ran],
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "60000",
    //     "hideDuration": "1000",
    //     "timeOut": "5000",
    //     "extendedTimeOut": "1000",
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "escapeHtml": true,
    //     "hideMethod": "fadeOut"
    // }
    // toastr["success"](message, "Notification");
    swal("Notification", message, "success");        
}

//Define Global Notification function
function GlobalInfoNotification() {
    // toastr.options = {
    //     "closeButton": true,
    //     "debug": false,
    //     "newestOnTop": false,
    //     "progressBar": true,
    //     "positionClass": "toast-top-right",
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "60000",
    //     "hideDuration": "1000",
    //     "timeOut": "5000",
    //     "extendedTimeOut": "1000",
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "escapeHtml": true,
    //     "hideMethod": "fadeOut"
    // }
    // toastr["info"]("Welcome to SalesForce Application", "Notification");
    swal("Notification", message, "info");        
}

//Define Global Warning Notification
function GlobalWarningNotification(message) {
    // var positionArrays = ["toast-top-full-width", "toast-top-full-width", "toast-top-full-width",
    //     "toast-bottom-full-width", "toast-bottom-center",
    //     "toast-top-full-width", "toast-top-full-width"
    // ];
    // var ran = Math.floor(Math.random() * 8);
    // toastr.options = {
    //     "closeButton": true,
    //     "debug": false,
    //     "newestOnTop": false,
    //     "progressBar": true,
    //     "positionClass": positionArrays[ran],
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "30000",
    //     "hideDuration": "10000",
    //     "timeOut": "50000",
    //     "extendedTimeOut": "1000",
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "hideMethod": "fadeOut"
    // }
    // toastr["warning"](message, "Warning Notification")
    swal("Notification", message, "warning");        
}

//Define Global Error Notification
function GlobalErrorNotification(message) {
    swal("Notification", message, "error");    
}
//Define Show Global Ajax Loader
function ShowGlobalLoader() {
    // $('.preloader').fadeIn(600);
    NProgress.start();
}
//Define Hide Global Ajax Loader
function HideGlobalLoader() {
    // $('.preloader').fadeOut(300);
    NProgress.done();
}

//Global Validation Alert
function GlobalValidationAlert(titleMain, textMain) {
    swal(titleMain, textMain, "warning");
}

//Global Validation Alert
function GlobalErrorAlert(titleMain, textMain) {
    swal(titleMain, textMain, "error");
}

//Global Confirmation Dialog
function GlobalConfirmationDialog(inputTitle, inputText, confirmText, cancelText, successCallback, cancelCallback) {
    swal({
        title: inputTitle,
        text: inputText,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        closeOnConfirm: true,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            successCallback();
        } else {
            if (cancelCallback != null) {
                cancelCallback();
            }
        }
    });
}

// Initiate ProTip
$(document).ready(function() {
    $.protip();
});