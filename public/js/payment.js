$(document).ready(function () {
    // Call api to get payment details
    $.ajax({
        url: '/api/get_remaining_payment',
        type: 'GET',
        success: function (response) {
            if (response.status == 200) {
                $("#readonly_amount").val(response.data.remaining_amount);
                $("#amount").val(response.data.remaining_amount);
                if (response.data.type == "none") {
                    $("#type_of_remaining_amount").text("No remaining amount");
                }else{
                    $("#type_of_remaining_amount").text("Remaining amount for " + response.data.type + " payment");
                }
            } else {
                alert('Error occured while fetching payment details');
            }
        },
        error: function (response) {
            alert('Error occured while fetching payment details');
        }
    });
});