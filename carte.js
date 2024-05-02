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
        geoJSON: am5geodata_worldLow
    })
);
polygonSeries.set("fill", am5.color(0x262626));
polygonSeries.set("stroke", am5.color(0xffffff));


