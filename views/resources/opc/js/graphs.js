queue()
        .defer(d3.json, "views/modules/consulta-indicadores/opc/data.php")
        .defer(d3.json, "views/modules/consulta-indicadores/opc/static/geojson/barrios.json")
        .await(makeGraphs);

function makeGraphs(error, records, states) {
    if (error !== null) {
        console.log('Error:');
        console.log(error);
    } else {
        console.log('Sin errores');
    }

    var ndx = crossfilter(records);
    
    console.log(ndx.size());
    
    var yearDim = ndx.dimension(function (d) {
        return d["anho_marca_temporal"];
    });
    var genderDim = ndx.dimension(function (d) {
        return d["sexoVictima"];
    });
    var ageSegmentDim = ndx.dimension(function (d) {
        return d["edadNNAJVictima"];
    });
    var unrestDim = ndx.dimension(function (d) {
        return d["conflictividad_delito"];
    });
    var comunaDim = ndx.dimension(function (d) {
        if (d["comuna"] === '0') {
            return 'Sin Dato';
        } else {
            return d["comuna"];
        }
    });
    var locationdDim = ndx.dimension(function (d) {
        return d["nombre_barrio"];
    });
    var yearGroup = yearDim.group();
    var genderGroup = genderDim.group();
    var ageSegmentGroup = ageSegmentDim.group();
    var unrestGroup = unrestDim.group();
    var comunaGroup = comunaDim.group();
    var locationGroup = locationdDim.group();
    var all = ndx.groupAll();
    var groupname = "Choropleth";
    var yearChart = dc.barChart("#year-bar-chart", groupname);
    var genderChart = dc.rowChart("#gender-row-chart", groupname);
    var ageSegmentChart = dc.rowChart("#age-segment-row-chart", groupname);
    var unrestChart = dc.rowChart("#unrest-row-chart", groupname);
    var comunaChart = dc.barChart("#comuna-bar-chart", groupname);
    var locationChart = dc.rowChart("#location-row-chart", groupname);
    var numberRecordsND = dc.numberDisplay("#number-records-nd", groupname);
    var choropletMap = dc.leafletChoroplethChart("#cali-chart", groupname);

    function drawCharts() {
        numberRecordsND
                .formatNumber(d3.format(","))
                .valueAccessor(function (d) {
                    return d;
                })
                .group(all);

        choropletMap
                .dimension(locationdDim)
                .group(locationGroup)
                .geojson(states)
                .center([3.42, -76.5])
                .zoom(12)
                .colors(["#E2F2FF", "#C4E4FF", "#9ED2FF", "#81C5FF", "#6BBAFF", "#51AEFF", "#36A2FF", "#1E96FF", "#0089FF", "#0061B5"])
                .colorDomain(function () {
                    return [dc.utils.groupMin(this.group(),
                                this.valueAccessor()),
                        dc.utils.groupMax(this.group(),
                                this.valueAccessor())];
                })
                .colorAccessor(function (d, i) {
                    return d.value;
                })
                .featureKeyAccessor(function (feature) {
                    return feature.properties.BARRIO;
                })
                .popup(function (d, feature) {
                    return (feature.properties.BARRIO + ":" + d.value);
                })
                .renderPopup(true);

        unrestChart
                .width(180)
                .height(250)
                .margins({top: 5, left: 5, right: 20, bottom: 20})
                .elasticX(true)
                .dimension(unrestDim)
                .group(unrestGroup)
                .colors(d3.scale.category20())
                .label(function (d) {
                    return capital_letter(d.key);
                })
                .title(function (d) {
                    return d.value;
                })
                .ordering(function (d) {
                    return -d.value;
                })
                .xAxis().ticks(3);

        genderChart
                .width(180)
                .height(250)
                .margins({top: 5, left: 5, right: 20, bottom: 20})
                .elasticX(true)
                .dimension(genderDim)
                .group(genderGroup)
                .colors(d3.scale.category20())
                .label(function (d) {
                    return capital_letter(d.key);
                })
                .title(function (d) {
                    return d.value;
                })
                .ordering(function (d) {
                    return -d.value;
                })
                .xAxis().ticks(3);

        ageSegmentChart
                .width(180)
                .height(250)
                .margins({top: 5, left: 5, right: 20, bottom: 20})
                .elasticX(true)
                .dimension(ageSegmentDim)
                .group(ageSegmentGroup)
                .colors(d3.scale.category20())
                .label(function (d) {
                    if (d.key === "SIN DATO") {
                        return capital_letter(d.key);
                    } else {
                        return d.key;
                    }
                })
                .title(function (d) {
                    return d.value;
                })
                .xAxis().ticks(3);


        var color = d3.scale.ordinal().range(["#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);
        var x = d3.scale.linear()
                .domain([0, 23])
                .range([0, 420]);

        comunaChart
                .width(620)
                .height(250)
                .margins({top: 5, left: 40, right: 5, bottom: 20})
                .elasticY(true)
                .elasticX(true)
                .dimension(comunaDim)
                .group(comunaGroup)
                .x(d3.scale.ordinal())
                .centerBar(true)
                .xUnits(dc.units.ordinal)
                .ordering(function (d) {
                    var order = {
                        1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6, 7: 7, 8: 8, 9: 9, 10: 10, 11: 11, 12: 12,
                        13: 13, 14: 14, 15: 15, 16: 16, 17: 17, 18: 18, 19: 19, 20: 20, 21: 21, 22: 22, 0: 23
                    };
                    return order[d.key];
                })
                .renderHorizontalGridLines(true)
                ;

        function getTops(source_group) {
            return {
                all: function () {
                    return source_group.top(4);
                }
            };
        }
        var topLocation = getTops(locationGroup);

        locationChart
                .width(220)
                .height(250)
                .margins({top: 5, left: 5, right: 20, bottom: 20}).elasticX(true)
                .dimension(locationdDim)
                .group(topLocation)
                .colors(d3.scale.category20())
                .label(function (d) {
                    return capital_letter(d.key);
                })
                .title(function (d) {
                    return d.value;
                })
                .ordering(function (d) {
                    return -d.value;
                })
                .xAxis().ticks(3);

        yearChart
                .width(330)
                .height(250)
                .margins({top: 5, left: 40, right: 0, bottom: 20})
                .elasticY(true)
                .elasticX(true)
                .dimension(yearDim)
                .group(yearGroup)
                .x(d3.scale.ordinal())
                .xUnits(dc.units.ordinal)
                .centerBar(true)
                .renderHorizontalGridLines(true);

        dc.renderAll(groupname);
    }
    ;
    drawCharts();
}
function capital_letter(str) {
    str = str.toLowerCase();
    str = str.split(" ");
    for (var i = 0, x = str.length; i < x; i++) {
        str[i] = str[i][0].toUpperCase() + str[i].substr(1);
    }
    return str.join(" ");
}
;