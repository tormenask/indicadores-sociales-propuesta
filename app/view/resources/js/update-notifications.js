$(document).ready(function () {
    function load_unseen_notification() {
        view = 'load';
        var data = new FormData();
        data.append('view', view);
        $.ajax({
            type: "POST",
            url: "/siscali/app/view/modules/fetch.php",
            data: data,
            dataType: "json",
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#notif-menu').html(data.notification);
                if (data.unseen_notification > 0) {
                    $('.count').html(data.unseen_notification);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest, textStatus, errorThrown);
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }

    load_unseen_notification();

    $(document).on('click', '#notif', function () {
        $('.count').html('');
        load_unseen_notification('yes');
    });

    setInterval(function () {
        load_unseen_notification();
    }, 5000);
});
   