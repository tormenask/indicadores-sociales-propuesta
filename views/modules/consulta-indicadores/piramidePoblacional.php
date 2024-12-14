<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" />-->
<link rel="stylesheet" href="sis/views/resources/lib/jquery-ui-themes-1.12.1/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidGridRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidAxisRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script src="sis/views/resources/jquery-number/jquery.number.min.js"></script>
<script>
    $(document).ready(function () {
        var ticks = ["0-4", "5-9", "10-14", "15-19", "20-24", "25-29", "30-34", "35-39", "40-44", "45-49", "50-54", "55-59", "60-64", "65-69", "70-74", "75-79", "80+", ""];
        var male = [7.76, 7.76, 8.03, 8.49, 8.90, 8.82, 8.23, 7.44, 6.48, 5.93, 5.80, 5.10, 3.87, 2.87, 1.97, 1.29, 1.25, 0];
        var female = [6.80, 6.86, 7.16, 7.62, 7.93, 7.93, 7.79, 7.47, 6.65, 6.32, 6.49, 5.94, 4.77, 3.64, 2.62, 1.91, 2.11, 0];
        var colors = ["#085586", "#f2665e", "#C57225", "#C57225"];
        var plotOptions = {title: '<div style="float:left; width:50%; text-align:center;">Hombres</div>\n\
                        <div style="float:right; width:50%; text-align:center;">Mujeres</div>',
            seriesColors: colors,
            grid: {drawBorder: false, shadow: false, background: "white",
                rendererOptions: {plotBands: {show: false, interval: 2}}
            },
            defaultAxisStart: 0,
            seriesDefaults: {
                renderer: $.jqplot.PyramidRenderer,
                rendererOptions: {barPadding: 4},
                showMinorTicks: true, yaxis: "yaxis", shadow: false
            },
            series: [
                {rendererOptions: {side: 'left', synchronizeHighlight: 1}},
                {yaxis: "y2axis", rendererOptions: {synchronizeHighlight: 0}},
                {rendererOptions: {fill: false, side: "left"}},
                {yaxis: "y2axis", rendererOptions: {fill: false}}
            ],
            axes: {
                xaxis: {
                    ticks: [[-14, 14], [-12, 12], [-10, 10], [-8, 8], [-6, 6], [-4, 4], [-2, 2], [0, 0],
                        [2, 2], [4, 4], [6, 6], [8, 8], [10, 10], [12, 12], [14, 14]],
                    tickOptions: {showGridline: true},
                    rendererOptions: {baselineWidth: 2}
                },
                yaxis: {
                    label: "Grupos de edad",
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickOptions: {showGridline: true},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {category: true, baselineWidth: 2}
                },
                yMidAxis: {
                    label: "Grupos de edad",
                    tickOptions: {showGridline: true},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {category: true, baselineWidth: 2}
                },
                y2axis: {
                    label: "Grupos de edad",
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickOptions: {showGridline: true},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {category: true, baselineWidth: 2}
                }
            }
        };
        plotOptions.series[0].yaxis = "yaxis";
        plotOptions.series[1].yaxis = "yaxis";
        plot1 = $.jqplot("chartPyramid", [male, female], plotOptions);
        $(".jqplot-target").bind("jqplotDataHighlight", function (evt, seriesIndex, pointIndex, data) {
            var malePopulation = Math.abs(plot1.series[0].data[pointIndex][1]);
            var femalePopulation = Math.abs(plot1.series[1].data[pointIndex][1]);
            var ratio = malePopulation / femalePopulation;
            $('#tooltipMale').stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", malePopulation));
            $('#tooltipFemale').stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", femalePopulation));
            $('#tooltipRatio').stop(true, true).fadeIn(350).html($.jqplot.sprintf('%.4f', ratio));
            $("#tooltipAge").stop(true, true).fadeIn(250).html(ticks[pointIndex]);
        });
        $(".jqplot-target").bind("jqplotDataUnhighlight", function (evt, seriesIndex, pointIndex, data) {
            $(".tooltip-item").stop(true, true).fadeOut(200).html('');
        });
    });
</script>
<script>
    $(function () {
        $("#slider-range-max").slider({
            range: "max", min: 1985, max: 2020, value: 2018,
            slide: function (event, ui) {
                var anho = ui.value;
                var position = 32;
                switch (anho) {
                    case 1985:
                        position = 0;
                        break;
                    case 1986:
                        position = 1;
                        break;
                    case 1987:
                        position = 2;
                        break;
                    case 1988:
                        position = 3;
                        break;
                    case 1989:
                        position = 4;
                        break;
                    case 1990:
                        position = 5;
                        break;
                    case 1991:
                        position = 6;
                        break;
                    case 1992:
                        position = 7;
                        break;
                    case 1993:
                        position = 8;
                        break;
                    case 1994:
                        position = 9;
                        break;
                    case 1995:
                        position = 10;
                        break;
                    case 1996:
                        position = 11;
                        break;
                    case 1997:
                        position = 12;
                        break;
                    case 1998:
                        position = 13;
                        break;
                    case 1999:
                        position = 14;
                        break;
                    case 2000:
                        position = 15;
                        break;
                    case 2001:
                        position = 16;
                        break;
                    case 2002:
                        position = 17;
                        break;
                    case 2003:
                        position = 18;
                        break;
                    case 2004:
                        position = 19;
                        break;
                    case 2005:
                        position = 20;
                        break;
                    case 2006:
                        position = 21;
                        break;
                    case 2007:
                        position = 22;
                        break;
                    case 2008:
                        position = 23;
                        break;
                    case 2009:
                        position = 24;
                        break;
                    case 2010:
                        position = 25;
                        break;
                    case 2011:
                        position = 26;
                        break;
                    case 2012:
                        position = 27;
                        break;
                    case 2013:
                        position = 28;
                        break;
                    case 2014:
                        position = 29;
                        break;
                    case 2015:
                        position = 30;
                        break;
                    case 2016:
                        position = 31;
                        break;
                    case 2017:
                        position = 32;
                        break;
                    case 2018:
                        position = 33;
                        break;
                    case 2019:
                        position = 34;
                        break;
                    case 2020:
                        position = 35;
                        break;
                    default:
                        position = 0;
                }
                var ticks = ["0-4", "5-9", "10-14", "15-19", "20-24", "25-29", "30-34", "35-39", "40-44", "45-49", "50-54", "55-59", "60-64", "65-69", "70-74", "75-79", "80+", ""];
                var maleTot = [
                    [12.26, 11.33, 10.65, 10.57, 10.79, 9.04, 7.18, 5.32, 4.44, 3.94, 3.48, 3.29, 2.99, 2.33, 1.30, 0.61, 0.47, 0],
                    [12.11, 11.15, 10.46, 10.39, 10.74, 9.23, 7.39, 5.55, 4.54, 3.97, 3.50, 3.22, 2.94, 2.34, 1.32, 0.68, 0.49, 0],
                    [11.96, 10.99, 10.31, 10.21, 10.64, 9.42, 7.58, 5.77, 4.66, 3.99, 3.52, 3.15, 2.87, 2.35, 1.34, 0.72, 0.52, 0],
                    [11.81, 10.84, 10.21, 10.03, 10.49, 9.58, 7.75, 5.99, 4.80, 4.01, 3.56, 3.09, 2.80, 2.37, 1.37, 0.75, 0.55, 0],
                    [11.66, 10.71, 10.14, 9.88, 10.32, 9.70, 7.92, 6.19, 4.95, 4.03, 3.59, 3.05, 2.72, 2.37, 1.40, 0.77, 0.58, 0],
                    [11.51, 10.60, 10.08, 9.78, 10.13, 9.76, 8.10, 6.38, 5.10, 4.08, 3.60, 3.02, 2.66, 2.36, 1.44, 0.79, 0.62, 0],
                    [11.37, 10.51, 10.01, 9.72, 9.93, 9.75, 8.29, 6.55, 5.25, 4.16, 3.60, 3.01, 2.60, 2.33, 1.48, 0.80, 0.65, 0],
                    [11.22, 10.45, 9.95, 9.70, 9.73, 9.68, 8.47, 6.70, 5.40, 4.24, 3.58, 3.01, 2.55, 2.29, 1.52, 0.82, 0.68, 0],
                    [11.05, 10.41, 9.90, 9.71, 9.55, 9.57, 8.62, 6.85, 5.54, 4.35, 3.57, 3.01, 2.51, 2.24, 1.55, 0.85, 0.72, 0],
                    [10.89, 10.39, 9.86, 9.72, 9.39, 9.42, 8.74, 7.00, 5.67, 4.45, 3.57, 3.01, 2.49, 2.19, 1.57, 0.90, 0.75, 0],
                    [10.71, 10.38, 9.85, 9.72, 9.28, 9.25, 8.79, 7.15, 5.79, 4.56, 3.59, 3.01, 2.47, 2.15, 1.57, 0.95, 0.78, 0],
                    [10.54, 10.37, 9.85, 9.70, 9.20, 9.06, 8.78, 7.31, 5.91, 4.68, 3.63, 3.00, 2.48, 2.12, 1.57, 0.99, 0.81, 0],
                    [10.36, 10.37, 9.87, 9.67, 9.16, 8.86, 8.72, 7.48, 6.02, 4.79, 3.69, 2.99, 2.49, 2.08, 1.57, 1.03, 0.83, 0],
                    [10.17, 10.38, 9.90, 9.65, 9.15, 8.66, 8.62, 7.62, 6.13, 4.90, 3.76, 2.99, 2.51, 2.06, 1.56, 1.07, 0.86, 0],
                    [9.96, 10.37, 9.94, 9.65, 9.16, 8.49, 8.48, 7.72, 6.24, 5.01, 3.84, 3.00, 2.53, 2.04, 1.56, 1.11, 0.89, 0],
                    [9.75, 10.34, 9.98, 9.65, 9.17, 8.36, 8.31, 7.77, 6.37, 5.12, 3.94, 3.03, 2.55, 2.03, 1.55, 1.14, 0.91, 0],
                    [9.54, 10.27, 10.02, 9.67, 9.20, 8.29, 8.12, 7.76, 6.51, 5.22, 4.04, 3.09, 2.56, 2.04, 1.55, 1.17, 0.94, 0],
                    [9.35, 10.15, 10.05, 9.70, 9.23, 8.27, 7.93, 7.70, 6.66, 5.32, 4.15, 3.17, 2.57, 2.06, 1.54, 1.19, 0.96, 0],
                    [9.20, 9.98, 10.05, 9.73, 9.27, 8.30, 7.75, 7.60, 6.80, 5.42, 4.26, 3.27, 2.58, 2.08, 1.55, 1.20, 0.99, 0],
                    [9.07, 9.79, 10.02, 9.74, 9.30, 8.35, 7.60, 7.47, 6.90, 5.53, 4.38, 3.37, 2.60, 2.09, 1.55, 1.19, 1.01, 0],
                    [8.96, 9.57, 9.75, 9.33, 8.42, 7.52, 7.35, 6.97, 5.67, 4.50, 3.49, 2.65, 2.11, 1.57, 1.17, 1.04, 0],
                    [8.83, 9.36, 9.73, 9.34, 8.49, 7.50, 7.22, 6.99, 5.84, 4.62, 3.60, 2.71, 2.12, 1.60, 1.14, 1.07, 0],
                    [8.71, 9.15, 9.70, 9.33, 8.56, 7.54, 7.10, 6.97, 6.01, 4.74, 3.71, 2.79, 2.14, 1.62, 1.12, 1.10, 0],
                    [8.59, 8.93, 9.67, 9.31, 8.63, 7.60, 7.00, 6.90, 6.18, 4.87, 3.83, 2.88, 2.16, 1.65, 1.12, 1.13, 0],
                    [8.50, 8.71, 9.62, 9.29, 8.69, 7.68, 6.93, 6.82, 6.31, 5.01, 3.94, 2.98, 2.20, 1.67, 1.13, 1.15, 0],
                    [8.41, 8.50, 9.56, 9.28, 8.73, 7.77, 6.89, 6.72, 6.39, 5.16, 4.05, 3.08, 2.25, 1.69, 1.16, 1.17, 0],
                    [8.33, 8.34, 9.47, 9.27, 8.76, 7.86, 6.90, 6.62, 6.42, 5.32, 4.16, 3.17, 2.31, 1.69, 1.19, 1.18, 0],
                    [8.25, 8.22, 9.37, 9.27, 8.78, 7.95, 6.95, 6.53, 6.40, 5.49, 4.27, 3.27, 2.37, 1.70, 1.21, 1.19, 0],
                    [8.16, 8.13, 9.24, 9.26, 8.79, 8.03, 7.02, 6.44, 6.35, 5.65, 4.39, 3.37, 2.45, 1.72, 1.23, 1.20, 0],
                    [8.07, 8.06, 9.09, 9.24, 8.79, 8.10, 7.11, 6.38, 6.28, 5.77, 4.52, 3.47, 2.53, 1.76, 1.24, 1.21, 0],
                    [7.98, 7.99, 8.93, 9.20, 8.80, 8.16, 7.20, 6.36, 6.20, 5.84, 4.67, 3.57, 2.62, 1.80, 1.25, 1.22, 0],
                    [7.89, 7.92, 8.76, 9.13, 8.81, 8.19, 7.29, 6.37, 6.11, 5.87, 4.81, 3.67, 2.70, 1.85, 1.26, 1.23, 0],
                    [7.82, 7.85, 8.61, 9.03, 8.82, 8.22, 7.37, 6.41, 6.01, 5.85, 4.96, 3.77, 2.78, 1.91, 1.28, 1.24, 0],
                    [7.76, 7.76, 8.49, 8.90, 8.82, 8.23, 7.44, 6.48, 5.93, 5.80, 5.10, 3.87, 2.87, 1.97, 1.29, 1.25, 0],
                    [7.72, 7.67, 8.40, 8.76, 8.81, 8.24, 7.51, 6.55, 5.87, 5.73, 5.20, 3.98, 2.95, 2.03, 1.30, 1.27, 0],
                    [7.69, 7.58, 8.35, 8.63, 8.77, 8.26, 7.57, 6.63, 5.85, 5.65, 5.27, 4.09, 3.04, 2.10, 1.32, 1.29, 0]
                ];
                var femaleTot = [
                    [11.09, 10.31, 9.77, 10.41, 10.87, 9.56, 7.54, 5.65, 4.68, 4.33, 3.75, 3.24, 2.98, 2.63, 1.58, 0.87, 0.76, 0],
                    [10.88, 10.22, 9.63, 10.16, 10.78, 9.72, 7.79, 5.94, 4.78, 4.31, 3.79, 3.24, 2.92, 2.58, 1.62, 0.85, 0.80, 0],
                    [10.65, 10.13, 9.56, 9.89, 10.64, 9.88, 8.01, 6.21, 4.93, 4.27, 3.84, 3.25, 2.86, 2.52, 1.66, 0.86, 0.84, 0],
                    [10.41, 10.04, 9.54, 9.64, 10.47, 10.01, 8.21, 6.46, 5.10, 4.22, 3.88, 3.26, 2.80, 2.46, 1.69, 0.91, 0.94, 0],
                    [10.18, 9.94, 9.54, 9.44, 10.26, 10.11, 8.41, 6.70, 5.28, 4.20, 3.91, 3.28, 2.76, 2.41, 1.71, 0.97, 0.91, 0],
                    [9.96, 9.83, 9.54, 9.30, 10.03, 10.14, 8.61, 6.91, 5.47, 4.22, 3.91, 3.31, 2.72, 2.35, 1.72, 1.03, 0.94, 0],
                    [9.76, 9.72, 9.53, 9.23, 9.79, 10.13, 8.81, 7.11, 5.65, 4.29, 3.88, 3.34, 2.70, 2.30, 1.71, 1.09, 0.98, 0],
                    [9.58, 9.60, 9.50, 9.22, 9.54, 10.05, 9.00, 7.29, 5.82, 4.39, 3.83, 3.37, 2.69, 2.25, 1.70, 1.14, 1.01, 0],
                    [9.42, 9.48, 9.46, 9.25, 9.31, 9.93, 9.16, 7.46, 5.98, 4.53, 3.78, 3.40, 2.70, 2.22, 1.69, 1.18, 1.05, 0],
                    [9.28, 9.37, 9.41, 9.29, 9.11, 9.76, 9.27, 7.62, 6.13, 4.68, 3.75, 3.42, 2.71, 2.19, 1.68, 1.23, 1.08, 0],
                    [9.17, 9.29, 9.35, 9.31, 8.98, 9.55, 9.32, 7.78, 6.28, 4.83, 3.76, 3.41, 2.74, 2.18, 1.67, 1.26, 1.12, 0],
                    [9.06, 9.22, 9.28, 9.31, 8.90, 9.31, 9.31, 7.93, 6.41, 4.99, 3.81, 3.39, 2.78, 2.19, 1.67, 1.29, 1.16, 0],
                    [8.94, 9.19, 9.20, 9.30, 8.88, 9.05, 9.23, 8.07, 6.53, 5.14, 3.90, 3.35, 2.83, 2.20, 1.68, 1.31, 1.21, 0],
                    [8.80, 9.17, 9.12, 9.27, 8.89, 8.80, 9.10, 8.19, 6.65, 5.30, 4.01, 3.31, 2.88, 2.23, 1.69, 1.33, 1.25, 0],
                    [8.65, 9.16, 9.05, 9.24, 8.92, 8.57, 8.93, 8.27, 6.78, 5.45, 4.15, 3.29, 2.92, 2.27, 1.71, 1.35, 1.30, 0],
                    [8.48, 9.14, 9.00, 9.19, 8.95, 8.41, 8.71, 8.29, 6.91, 5.60, 4.29, 3.32, 2.94, 2.32, 1.74, 1.38, 1.34, 0],
                    [8.33, 9.08, 8.96, 9.13, 8.98, 8.30, 8.45, 8.25, 7.05, 5.75, 4.44, 3.38, 2.95, 2.38, 1.78, 1.41, 1.38, 0],
                    [8.19, 8.98, 8.94, 9.06, 9.00, 8.26, 8.17, 8.16, 7.18, 5.89, 4.60, 3.49, 2.94, 2.45, 1.83, 1.44, 1.42, 0],
                    [8.08, 8.84, 8.91, 8.99, 9.02, 8.26, 7.91, 8.02, 7.31, 6.03, 4.75, 3.62, 2.93, 2.52, 1.88, 1.47, 1.45, 0],
                    [7.99, 8.68, 8.86, 8.90, 9.02, 8.29, 7.69, 7.86, 7.40, 6.18, 4.92, 3.77, 2.95, 2.57, 1.94, 1.48, 1.48, 0],
                    [7.91, 8.50, 8.82, 9.00, 8.34, 7.55, 7.68, 7.46, 6.34, 5.08, 3.93, 2.99, 2.60, 2.01, 1.48, 1.52, 0],
                    [7.79, 8.35, 8.74, 8.94, 8.40, 7.51, 7.52, 7.47, 6.51, 5.25, 4.09, 3.07, 2.61, 2.07, 1.44, 1.56, 0],
                    [7.67, 8.18, 8.67, 8.83, 8.46, 7.53, 7.34, 7.44, 6.66, 5.42, 4.24, 3.18, 2.61, 2.14, 1.43, 1.61, 0],
                    [7.55, 8.00, 8.61, 8.70, 8.51, 7.59, 7.19, 7.37, 6.80, 5.58, 4.39, 3.31, 2.61, 2.20, 1.46, 1.65, 0],
                    [7.45, 7.82, 8.54, 8.58, 8.53, 7.68, 7.07, 7.26, 6.90, 5.75, 4.55, 3.45, 2.63, 2.23, 1.53, 1.70, 0],
                    [7.36, 7.64, 8.47, 8.47, 8.51, 7.76, 6.99, 7.14, 6.96, 5.91, 4.70, 3.59, 2.68, 2.24, 1.62, 1.75, 0],
                    [7.27, 7.48, 8.39, 8.39, 8.46, 7.84, 6.98, 7.00, 6.98, 6.08, 4.86, 3.73, 2.76, 2.23, 1.71, 1.79, 0],
                    [7.19, 7.34, 8.30, 8.33, 8.37, 7.92, 7.02, 6.86, 6.96, 6.23, 5.02, 3.88, 2.86, 2.23, 1.78, 1.83, 0],
                    [7.11, 7.23, 8.19, 8.29, 8.27, 7.98, 7.09, 6.72, 6.91, 6.37, 5.19, 4.02, 2.98, 2.23, 1.83, 1.87, 0],
                    [7.04, 7.14, 8.08, 8.25, 8.17, 8.01, 7.18, 6.62, 6.83, 6.48, 5.35, 4.17, 3.11, 2.27, 1.86, 1.91, 0],
                    [6.97, 7.06, 7.95, 8.19, 8.09, 8.01, 7.27, 6.56, 6.72, 6.54, 5.52, 4.32, 3.24, 2.33, 1.88, 1.96, 0],
                    [6.91, 6.99, 7.82, 8.12, 8.02, 7.96, 7.35, 6.55, 6.59, 6.56, 5.68, 4.47, 3.37, 2.41, 1.90, 2.01, 0],
                    [6.85, 6.92, 7.71, 8.03, 7.97, 7.89, 7.42, 6.58, 6.45, 6.54, 5.82, 4.62, 3.50, 2.51, 1.90, 2.06, 0],
                    [6.80, 6.86, 7.62, 7.93, 7.93, 7.79, 7.47, 6.65, 6.32, 6.49, 5.94, 4.77, 3.64, 2.62, 1.91, 2.11, 0],
                    [6.75, 6.80, 7.56, 7.82, 7.88, 7.69, 7.50, 6.73, 6.21, 6.40, 6.04, 4.92, 3.78, 2.73, 1.92, 2.17, 0],
                    [6.70, 6.74, 7.51, 7.73, 7.83, 7.61, 7.49, 6.80, 6.15, 6.29, 6.09, 5.06, 3.92, 2.86, 1.95, 2.24, 0]
                ];
                var popTot = [1418459, 1470644, 1522188, 1572755, 1621948, 1669322, 1714415, 1756781, 1796111, 1832238, 1865307, 1895661, 1923705, 1949903, 1974700, 1998623, 2022178, 2045944, 2070161, 2094843, 2119843, 2144860, 2169838, 2194781, 2219720, 2244668, 2269653, 2294653, 2319684, 2344734, 2369821, 2394925, 2420114, 2445405, 2470852, 2496442];
                var popFemaleTot = [742712, 774129, 804173, 832727, 859490, 884261, 906578, 926765, 944817, 961145, 976099, 990258, 1003437, 1015994, 1028029, 1039995, 1052164, 1064836, 1078069, 1091619, 1105332, 1118632, 1131859, 1144936, 1158058, 1171172, 1184299, 1197434, 1210578, 1223740, 1236903, 1250077, 1263275, 1276506, 1289794, 1303110];
                var popMaleTot = [675747, 696515, 718015, 740028, 762458, 785061, 807837, 830016, 851294, 871093, 889208, 905403, 920268, 933909, 946671, 958628, 970014, 981108, 992092, 1003224, 1014511, 1026228, 1037979, 1049845, 1061662, 1073496, 1085354, 1097219, 1109106, 1120994, 1132918, 1144848, 1156839, 1168899, 1181058, 1193332];
                $("#amount").text(ui.value);
                $("#year").text(ui.value);
                $("#totalPopulation").number(popTot[position]);
                $("#totalFemalePopulation").number(popFemaleTot[position]);
                $("#totalMalePopulation").number(popMaleTot[position]);
                $("#ratioTotal").number(popMaleTot[position] / popFemaleTot[position], 4);
                var colors = ["#085586", "#f2665e", "#C57225", "#C57225"];
                var male = maleTot[position];
                var female = femaleTot[position];
                var plotOptions = {title: '<div style="float:left;width:50%;text-align:center">Hombres</div>\n\
                        <div style="float:right;width:50%;text-align:center">Mujeres</div>',
                    seriesColors: colors,
                    grid: {drawBorder: false, shadow: false, background: "white",
                        rendererOptions: {plotBands: {show: false, interval: 2}}},
                    defaultAxisStart: 0,
                    seriesDefaults: {renderer: $.jqplot.PyramidRenderer, rendererOptions: {barPadding: 4},
                        showMinorTicks: true, yaxis: "yaxis", shadow: false},
                    series: [
                        {rendererOptions: {side: 'left', synchronizeHighlight: 1}},
                        {yaxis: "y2axis", rendererOptions: {synchronizeHighlight: 0}},
                        {rendererOptions: {fill: false, side: "left"}},
                        {yaxis: "y2axis", rendererOptions: {fill: false}}
                    ],
                    axes: {
                        xaxis: {
                            ticks: [[-14, 14], [-12, 12], [-10, 10], [-8, 8], [-6, 6], [-4, 4], [-2, 2], [0, 0],
                                [2, 2], [4, 4], [6, 6], [8, 8], [10, 10], [12, 12], [14, 14]],
                            tickOptions: {showGridline: true},
                            rendererOptions: {baselineWidth: 2}
                        },
                        yaxis: {
                            label: "Grupos de edad", labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                            tickOptions: {showGridline: true},
                            showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                        },
                        yMidAxis: {label: "Grupos de edad", tickOptions: {showGridline: true},
                            showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                        },
                        y2axis: {label: "Grupos de edad", labelRenderer: $.jqplot.CanvasAxisLabelRenderer, tickOptions: {showGridline: true},
                            showMinorTicks: true, ticks: ticks, rendererOptions: {category: true, baselineWidth: 2}
                        }
                    }
                };
                plot1.destroy();
                plotOptions.series[0].yaxis = "yaxis";
                plotOptions.series[1].yaxis = "yaxis";
                plot1 = $.jqplot("chartPyramid", [male, female], plotOptions);
                $(".jqplot-target").bind("jqplotDataHighlight", function (evt, seriesIndex, pointIndex, data) {
                    var malePopulation = Math.abs(plot1.series[0].data[pointIndex][1]);
                    var femalePopulation = Math.abs(plot1.series[1].data[pointIndex][1]);
                    var ratio = malePopulation / femalePopulation;
                    $('#tooltipMale').stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", malePopulation));
                    $('#tooltipFemale').stop(true, true).fadeIn(250).html($.jqplot.sprintf("%.2f", femalePopulation));
                    $('#tooltipRatio').stop(true, true).fadeIn(350).html($.jqplot.sprintf('%.4f', ratio));
                    $("#tooltipAge").stop(true, true).fadeIn(250).html(ticks[pointIndex]);
                });
                $(".jqplot-target").bind("jqplotDataUnhighlight", function (evt, seriesIndex, pointIndex, data) {
                    $(".tooltip-item").stop(true, true).fadeOut(200).html('');
                });
            }
        });
        $("#amount").val($("#slider-range-max").slider("value"));
    });
</script>
<style>
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{border: 2px solid #0e6e37;background: #0e6e37;padding: 10px 0px;}
    .ui-slider-horizontal .ui-slider-range-max {right: 0;background: #d6d6d6;}
</style>
<div class="container">
    <div class="row">
        <?php include './views/modules/header.php'; ?>
    </div>
    <div class="row">
        <ul class="breadcrumb">
            <li> <a href="sis/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
            <li class="active"><a href="index.php?action=piramidePoblacional">Pirámide poblacional para Santiago de Cali</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-sm-12" style="text-align: justify;">
            <div id="graf" class="col-sm-9" style="background-color:#fff; padding: 15px;">
                <h1 id="nombreIndicador">Pirámide poblacional para Santiago de Cali</h1>
                <hr>
                <div class="col-sm-4" style="text-align: center;">
                    <div>
                        <table class="table table-striped table-bordered table-hover table-responsive" 
                               style="font-size: 12px; margin-bottom: 10px; margin-top: 40px;">
                            <tr>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%">
                                    Año
                                </td>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center">
                                    <p style="margin: 0px;" id="year">2018</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center">
                                    Población total
                                </td>
                                <td style="text-align:center">
                                    <p style="margin: 0px;" id="totalPopulation">
                                    </p>
                                    <script>
                                        $("#totalPopulation").number(2420114);
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center">
                                    Total mujeres
                                </td>
                                <td style="text-align:center">
                                    <p style="margin: 0px;" id="totalFemalePopulation">
                                    </p>
                                    <script>
                                        $("#totalFemalePopulation").number(1263275);
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center">
                                    Total hombres
                                </td>
                                <td style="text-align:center">
                                    <p style="margin: 0px;" id="totalMalePopulation">
                                    </p>
                                    <script>
                                        $("#totalMalePopulation").number(1156839);
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center">
                                    Proporción H/M
                                </td>
                                <td style="text-align:center;">
                                    <p style="margin: 0px;" id="ratioTotal">
                                    </p>
                                    <script>
                                        $("#ratioTotal").number(0.9157, 4);
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">
                                    Tipo de datos
                                </td>
                                <td style="text-align: center;">
                                    Proyecciones DANE
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-responsive" style="font-size: 13px; margin-bottom: 10px;">
                        <tr>
                            <td colspan="2">
                                <div id="amount" style="color:#0e6e37; font-weight:bold; text-align: center">2018</div>
                                <div style="margin: 5px 10px 5px 10px; padding: 8px 0px; border: solid 2px #0e6e37;" id="slider-range-max"></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8" style="padding-left: 5px;">
                    <div class="chart-container"> 
                        <div id="chartPyramid"></div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-top: 15px;">
                    <p><strong>Gráfico:</strong> Sistema de Indicadores Sociales</p>
                </div>
            </div>
            <div class="col-md-3" style="margin-top: 93px;">
                <table class="table table-striped table-bordered table-hover table-responsive" 
                       style="font-size: 12px; margin-bottom: 10px; margin-top: 40px;">
                    <tr>
                        <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">
                            Rango de edad
                        </td>
                        <td style="text-align: center; width: 50%">
                            <div class="tooltip-item" id="tooltipAge">
                                &nbsp;
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">
                            Porcentaje de hombres
                        </td>
                        <td style="text-align: center;">
                            <div class="tooltip-item" id="tooltipMale">
                                &nbsp;
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">
                            Porcentaje de mujeres
                        </td>
                        <td style="text-align: center;">
                            <div class="tooltip-item" id="tooltipFemale">
                                &nbsp;
                            </div>
                        </td>
                    </tr>
<!--                    <tr>
                        <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">
                            Proporción H/M
                        </td>
                        <td style="text-align: center;">
                            <div class="tooltip-item" id="tooltipRatio">
                                &nbsp;
                            </div>
                        </td>
                    </tr>-->
                    <tr>
                        <td style="background-color:#0e6e37; color:#fff; text-align:center; width: 50%;">
                            Tipo de datos
                        </td>
                        <td style="text-align: center;">
                            Proyecciones DANE
                        </td>
                    </tr>
                </table>
                <div class="panel" style="background-color: #d6d6d6; margin-bottom: 10px; border: 1px #0e6e37 solid;">
                    <p style="font-size: 12px; text-align: justify; margin: 10px;">
                        Para consultar la información de un rango de edad, 
                        pase con el mouse sobre el rango de interés.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-12">
            <hr>
            <h4 style="text-align:left">Descargar gráfico</h4>
            <script>
                var url = "/sis/views/resources/js/descargarGrafico.js";
                $.getScript(url);
            </script>                            
            <div class="btn-group" role="group" style="width:100%;">
                <button type="button" id="imagenPng" class="btn bt bt-ripple" style="width:20%; background-color:#52b1fe; color:#fff;">
                    <i class="fa fa-file-image-o" aria-hidden="true" style="margin-right:10px;"></i>
                    <b>PNG</b>
                </button>
                <img src="sis/views/resources/images/loading3.gif" id="loadingPng" style="display: none; margin-left: 10px;"/>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
