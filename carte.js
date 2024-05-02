//Initialize the map
let root = am5.Root.new("chartdiv");

//Set Projection
let chart = root.container.children.push(
    am5map.MapChart.new(root, {
        projection: am5map.geoNaturalEarth1(),
        panX: "none",
        panY: "none",
        wheelY: "none"
    })
);

let polygonSeries = chart.series.push(
    am5map.MapPolygonSeries.new(root, {
        geoJSON: am5geodata_worldLow,
        exclude: ["AQ"]
    })
);

/*
polygonSeries.mapPolygons.template.events.on("click", function(ev) {
  polygonSeries.zoomToDataItem(ev.target.dataItem);
});*/

polygonSeries.mapPolygons.template.setAll({
  tooltipText: "{name}",
  interactive: true
});

polygonSeries.mapPolygons.template.states.create("hover", {
  fill: am5.color(0x4d4d4d)
});



polygonSeries.set("fill", am5.color(0x262626));
polygonSeries.set("stroke", am5.color(0xffffff));

polygonSeries.data.setAll([{
  id: "FR",
  polygonSettings: {
    fill: am5.color(0xFF0000)
  }
}])

/*
polygonSeries.events.on("ready", function(ev) {
  let francePolygon = polygonSeries.getPolygonById("FR"); // "FR" is the ISO 3166-1 alpha-2 code for France
  if (francePolygon) {
    francePolygon.fill = am5core.color("#FF0000"); // Set fill color to highlight France
    francePolygon.setState("hover", { fill: am5core.color("#FF0000") }); // Set hover state color
  }
});*/




