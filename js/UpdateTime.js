setTimeout(refresh, 5000);

function refresh() {
    $.ajax({
        type: 'post',
        url: './refresh.php',
        dataType: 'json',
        success: function (response) {
            console.log(1);
            $(document).ready(
                function () {
                    $('div.approximateTime').html(response.timeAproximate);
                    $('div.accurateTime').html(response.time);
                }
            );
        }
    });
    setTimeout(refresh, 5000);
}
