$("#imagenPng").click(function () {
    var nombreIndicador = ($("#nombreIndicador").text()).trim();
    $("#loadingPng").show();
    var container = document.getElementById("graf");
    $("#loadingPng").css("display", "inline");
    html2canvas(container).then(function (canvas) {
        var link = document.createElement("a");
        document.body.appendChild(link);
        link.download = "" + nombreIndicador + ".png";
        link.href = canvas.toDataURL();
        link.target = "_blank";
        $("#loadingPng").hide();
        link.click();
    });
});
