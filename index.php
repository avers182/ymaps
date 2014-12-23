<?php
	$db = new SQLite3("TracksDB.sqlite");
	$tracks = $db->query("select z_pk, zdistance, zendtime, zstarttime, zname from ztrack order by z_pk desc;");
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="ymaps.css">
</head>

<body>

<h2>Tracks</h2>

<div>
	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Distance</th>
				<th>Start time</th>
				<th>End time</th>
				<th>Speeds</th>
				<th>Altitudes</th>
				<th>List</th>
			</tr>
		</thead>
		<tbody>
		<?php while($row = $tracks->fetchArray(SQLITE3_ASSOC)):?>
			<tr>
				<td><a href="ymaps.php?ztrack=<?php echo $row["Z_PK"]?>"><?php echo $row["ZNAME"]?></a></td>
				<td><?php echo round($row["ZDISTANCE"], 2)?></td>
				<td><?php echo date('d.m.Y H:i:s', $row["ZSTARTTIME"] + 978307200.0)?></td>
				<td><?php echo date('d.m.Y H:i:s', $row["ZENDTIME"] + 978307200.0)?></td>
				<td><a href="ymaps.php?ztrack=<?php echo $row["Z_PK"]?>&speeds=speeds">speeds</a></td>
				<td><a href="ymaps.php?ztrack=<?php echo $row["Z_PK"]?>&alts=alts">altitudes</a></td>
				<td><a href="list.php?ztrack=<?php echo $row["Z_PK"]?>">list</a></td>
			</tr>
		<?php endwhile;?>
		</tbody>
	</table>
</div>

</body>
</html>


<?php $db->close();?>
