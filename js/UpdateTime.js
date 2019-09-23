setTimeout(refresh, 5000);

function refresh() {
    $.ajax({
        type: 'post',
        url: './refresh.php',
        dataType: 'json',
        success: function (response) {

            $(document).ready(
                function () {
                    if($('div.approximateTime').length)
                    {
                        $('div.approximateTime').html(response.timeAproximate);
                    }
                    if($('div.accurateTime').length)
                    {
                        $('div.accurateTime').html(response.time);
                    }

                }
            );
        }
    });
    setTimeout(refresh, 5000);
}
