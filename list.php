<?php
	$db = new SQLite3("TracksDB.sqlite");
	$statement = $db->prepare("select zdatetime, zlatitude, zlongitude, zspeed, zaltitude from ztrackwaypoint where ztrack = :ztrack order by zbbreakpoint;");
	$statement->bindValue(":ztrack", $_GET["ztrack"], SQLITE3_INTEGER);
	$waypoints = $statement->execute();
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="ymaps.css">
</head>

<body>

<h2>яндекс хуяндекс</h2>

<div><a href="index.php">Обратно к списку треков</a></div>

<div>
	<table>
		<thead>
			<tr>
				<th>Time</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th>Speed (m/s)</th>
				<th>Speed (kmh)</th>
				<th>Altitude</th>
			</tr>
		</thead>
		<tbody>
		<?php while($row = $waypoints->fetchArray(SQLITE3_ASSOC)):?>
			<tr>
				<td><?php echo date('d.m.Y H:i:s', $row["ZDATETIME"] + 978307200.0)?></td>
				<td><?php echo $row["ZLATITUDE"]?></td>
				<td><?php echo $row["ZLONGITUDE"]?></td>
				<td><?php echo $row["ZSPEED"]?></td>
				<td><?php echo $row["ZSPEED"] * 3.6?></td>
				<td><?php echo $row["ZALTITUDE"]?></td>
			</tr>
		<?php endwhile;?>
		</tbody>
	</table>
</div>

</body>
</html>


<?php $db->close();?>
