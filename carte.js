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

root.setThemes([
  am5themes_Animated.new(root),
]);



let polygonSeries = chart.series.push(
    am5map.MapPolygonSeries.new(root, {
        geoJSON: am5geodata_worldLow,
        exclude: ["AQ"]
    })
);


polygonSeries.mapPolygons.template.setAll({
  tooltipText: "{name}",
  templateField: "polygonSettings",
  interactive: true
});

polygonSeries.set("fill", am5.color(0x262626));
polygonSeries.set("stroke", am5.color(0xffffff));



polygonSeries.mapPolygons.template.states.create("hover", {
  fill: am5.color(0x4d4d4d),
});

polygonSeries.mapPolygons.template.events.on("")



polygonSeries.data.setAll([{
  id: "FR",
  polygonSettings: {
    fill: am5.color(0x0000FF),
  }
}]);







