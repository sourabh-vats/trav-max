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
});