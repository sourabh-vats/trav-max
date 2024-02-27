$(document).ready(function () {
    if ($("#user_role").val() == "partner") {
        $.ajax('/api/get_partnership', {
            dataType: 'json',
            type: 'POST', // http method
            data: {
                userId: $("#user_id").val()
            }, // data to submit
            success: function (response, status, xhr) {
                if (response.status == "success") {
                    if (response.data.type == "") {
                        window.location.replace("/signup/choose_partnership?package=" + response.data.package_id);
                    } else if (response.data.plan == "") {
                        window.location.replace("/signup/choose_payment_plan?plan=" + response.data.type + "&package=" + response.data.package_id);
                    } else {
                        window.location.replace("/signup/confirm_plan?package=" + response.data.package_id + "&plan=" + response.data.type + "&payment_plan=" + response.data.plan);
                    }
                } else if (response.status == "fail") {
                    window.location.replace("/signup/select_package");
                } else {
                    console.log("Some error happend. Please come back.");
                }
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    $.ajax('/api/get_user_info', {
        dataType: 'json',
        type: 'POST', // http method
        data: {
            userId: $("#user_id").val()
        }, // data to submit
        success: function (response, status, xhr) {
            if (response.status == "200") {
                data = response.data;
                if(data.booking.status == "Paid"){
                    $("#booking_amount_card").show();
                    $("#booking_amount").html(data.booking.amount);
                }else{
                    $("#booking_amount_card").hide();
                }
            } else {
                console.log("Some error happend. Please come back.");
            }
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log(errorMessage);
        }
    });
});

$(".download").click(function () {
    // Download image from URL
    var url = $(this).attr('data-url');
    var filename = $(this).attr('data-filename');
    downloadImage(url, filename);
});

function downloadImage(url, filename) {
    // Construct the a element
    var link = document.createElement("a");
    link.download = filename;
    link.target = "_blank";

    // Construct the uri
    link.href = url;
    document.body.appendChild(link);
    link.click();

    // Cleanup the DOM
    document.body.removeChild(link);
    delete link;
}