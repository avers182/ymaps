<?php
	$db = new SQLite3("TracksDB.sqlite");
	$statement = $db->prepare("select zlatitude, zlongitude, zspeed, zaltitude from ztrackwaypoint where ztrack = :ztrack order by zbbreakpoint;");
	$statement->bindValue(":ztrack", $_GET["ztrack"], SQLITE3_INTEGER);
	$waypoints = $statement->execute();
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
</head>

<body>

<h2>яндекс хуяндекс</h2>
<div><a href="index.php">Обратно к списку треков</a></div>
<div id="map" style="width:900px; height:600px"/>

<script type="text/javascript">
	ymaps.ready(function() {
		var map = new ymaps.Map("map", {center: [55.4515, 65.3705], zoom: 15, type: "yandex#satellite", behaviors: ['default', 'scrollZoom']});
		map.controls.add("smallZoomControl").add("mapTools").add("typeSelector");

//		map.balloon.open([55.4515, 65.3705], {contentBody: "щвейка"}, {closeButton: false});

		var route = new ymaps.Polyline([], {}, {strokeColor: '#0000ff', strokeWidth: 1});
		<?php while($row = $waypoints->fetchArray(SQLITE3_ASSOC)):?>
			route.geometry.getCoordinates().push([<?php echo $row["ZLATITUDE"]?>, <?php echo $row["ZLONGITUDE"]?>]);
			<?php if (isset($_GET["speeds"])||isset($_GET["alts"])):?>
				map.geoObjects.add(
					new ymaps.Placemark(
						[<?php echo $row["ZLATITUDE"]?>, <?php echo $row["ZLONGITUDE"]?>],
						// {iconContent: "<?php echo round($row["ZSPEED"] * 3.6, 2)?>"},
						// {iconContent: "<?php echo round($row["ZALTITUDE"])?>"},
						{iconContent: "<?php if (isset($_GET["speeds"])) echo round($row["ZSPEED"] * 3.6, 2); elseif(isset($_GET["alts"])) echo round($row["ZALTITUDE"]);?>"},
						{preset: "twirl#blueStretchyIcon"}
					)
				);
			<?php endif;?>
		<?php endwhile;?>
		map.geoObjects.add(route);

		map.setBounds(route.geometry.getBounds());
	});
</script>

</body>
</html>


<?php $db->close();?>
