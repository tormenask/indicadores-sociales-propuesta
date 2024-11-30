$(document).ready(function () {
    var URLhash = window.location.hash;
    if (URLhash !== "") {
        var destino = $(URLhash);
        scroll(destino);
    }
    $('a[href^="#"]').click(function () {
        var destino = $(this.hash);
        scroll(destino);
    });
    function scroll(destino) {
        $('html, body').animate({scrollTop: destino.offset().top - 200}, 500);
    }
});
