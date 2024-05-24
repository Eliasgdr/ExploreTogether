//Initialize the map
let root = am5.Root.new("chartdiv");

//Set Projection
let chart = root.container.children.push(am5map.MapChart.new(root, {
    projection: am5map.geoNaturalEarth1(), panX: "none", panY: "none", wheelY: "zoom"
}));

root.setThemes([am5themes_Animated.new(root),]);


let polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldHigh, exclude: ["AQ"]
}));


polygonSeries.mapPolygons.template.setAll({
    tooltipText: "{name}", templateField: "polygonSettings", interactive: true, toggleKey: "active"
});

polygonSeries.set("fill", am5.color(0x262626));
polygonSeries.set("stroke", am5.color(0xffffff));


polygonSeries.mapPolygons.template.states.create("hover", {fillOpacity: 0.6});

let countriesList = ["US", "FR", "AL", "ZA",]

polygonSeries.mapPolygons.template.events.on("click", function (ev) {
    const countryId = ev.target.dataItem.dataContext.id;
    console.log('Clicked on ' + countryId);
    polygonSeries.mapPolygons.template.states.create("active", {
        fill: am5.color(0x0000FF)
    });
});

for (let i = 0; i < countriesList.length; i++) {
    polygonSeries.data.push({
        id: countriesList[i], polygonSettings: {
            fill: am5.color(0x0000FF),
        }
    });
}







