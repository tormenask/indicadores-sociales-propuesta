//track where mouse was clicked
var initX;
var mouseClicked = false;
var s = 1;
var width = 350;
var height = 420;
var rotated = 90;
var projection = d3.geo.mercator()
        .center([-76.5, 3.45])
        .translate([height / 2, width / 2])
        .scale(120000);
var svg = d3.select("div#mapa").append("svg")
        .attr("width", width)
        .attr("height", height)
        //track where user clicked down
        .on("mousedown", function () {
            d3.event.preventDefault();
            initX = d3.mouse(this)[0];
            mouseClicked = true;
        })
        .on("mouseup", function () {
            if (s !== 1)
                return;
            rotated = rotated + ((d3.mouse(this)[0] - initX) * 360 / (s * width));
            mouseClicked = false;
        });
//for tooltip 
var offsetL = document.getElementById('mapa').offsetLeft + 10;
var offsetT = document.getElementById('mapa').offsetTop + 10;
var path = d3.geo.path().projection(projection);
var tooltip = d3.select("div#mapa")
        .append("div")
        .attr("class", "tooltip hidden");
//need this for correct panning
var g = svg.append("g");
d3.json("/sis/views/resources/geojson/comunas.geojson", function (json) {
    g.append("g")
            .attr("class", "boundary")
            .selectAll("boundary")
            .data(json.features)
            .enter().append("path")
            .attr("name", function (d) {
                return d.properties['NOMBRE'];
            })
            .attr("id", function (d) {
                return d.properties['COMUNA'];
            })
            .on('click', function (d) {
                nombreComuna = d.properties['NOMBRE'];
                d3.select('.selected').classed('selected', false);
                d3.select(this).classed('selected', true);
                consultaIndicadores(nombreComuna);
            })
            .on("mousemove", showTooltip)
            .on("mouseout", function (d, i) {
                tooltip.classed("hidden", true);
            })
            .attr("d", path);
});
function showTooltip(d) {
    label = d.properties['NOMBRE'];
    var mouse = d3.mouse(svg.node())
            .map(function (d) {
                return parseInt(d);
            });
    tooltip.classed("hidden", false)
            .attr("style", "left:" + (mouse[0] + offsetL) + "px;top:" + (mouse[1] + offsetT) + "px")
            .html(label);
}

function consultaIndicadores(nombreComuna) {
    $("#panel_informacion_comunas").hide();
    $("#informacion_comuna").show();
    var data = new FormData();
    data.append('nombreComuna', nombreComuna);
    var url = "/sis/views/modules/consulta-indicadores/calidad-educativa/consultas-calidad-educativa.php";
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (resp) {
            $("#establecimientos_comuna").html(resp);
            $("#informacion_comuna").show();
        }
    });
}