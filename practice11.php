<!DOCTYPE html>
<html>
	<head>
		<title>Practice 11</title>
		<meta charset="utf-8" />
		<style type="text/css">
			table,
			th,
			td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			table {
				padding: 0px;
				margin: 0px;
				width: 100%;
			}
			th {
				background-color: lightblue;
			}
			td {
				padding: 5px;
			}
		</style>
	</head>
	<body style="max-width: 500px; margin: 10px auto">
		<?php
			$link = mysqli_connect('localhost:3306', 'root', '');
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			if (isset($_GET['search']) && $_GET['search'] != '') {
				$kor_city = mysqli_query($link, "SELECT * FROM world.city WHERE CountryCode = 'KOR' AND name LIKE '%{$_GET['search']}%'");
			}
			else{
				$kor_city = mysqli_query($link, "SELECT * FROM world.city WHERE CountryCode = 'KOR'");
			}
		?>
		<h3>2020330017 김동우</h3>
		<div id="city-in-korea" style="width: 100%">
			<div
				id="search"
				style="
					width: 100%;
					display: flex;
					flex-direction: column;
					justify-content: space-between;
					align-items: center;
				"
			>
				<form
					action="./practice11.php"
					method="get"
					style="
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						width: 100%;
					"
				>
					<input name="search" placeholder="Search City" style="width:80%"
					<?php
						if (isset($_GET['search']) && $_GET['search'] != '') {
							echo "value=\"{$_GET['search']}\"";
						}
					?>
					/>
					<button>Search</button>
				</form>
				<div style="text-align: left; width: 100%">
					<?php
						if (isset($_GET['search'])&& $_GET['search'] != '') {
							echo "Search result for \"{$_GET['search']}\"";
							echo "<br>"; } echo "Total: " . mysqli_num_rows($kor_city); ?>
				</div>
			</div>
			<table id="city-in-korea-table">
				<tr>
					<?php
						while($kor_city_fields = mysqli_fetch_field($kor_city)){
							echo "<th>".($kor_city_fields->name)."</th>";
						}
					?>
				</tr>
				<?php
					while($kor_city_row = mysqli_fetch_row($kor_city)){
						echo "<tr>";
						foreach($kor_city_row as $key => $value){
							echo "<td>";
							$len = strlen($value);
							if($key ==1 && isset($_GET['search']) && $_GET['search'] != ''){
								$value_to_lower = strtolower($value);
								$search_to_lower = strtolower($_GET['search']);
								do {
									$pos = strpos($value_to_lower, $search_to_lower);
									if ($pos !== false) {
										echo substr($value, 0, $pos);
										echo "<span style=\"background-color: yellow\">";
										echo substr($value, $pos, strlen($_GET['search']));
										echo "</span>";
										$value = substr($value, $pos + strlen($_GET['search']));
										$value_to_lower = substr($value_to_lower, $pos + strlen($_GET['search']));
									}
								} while ($pos !== false);
								echo $value;
							}
							else{
								echo $value;
							}

						}
						echo "</tr>";
					}
				?>
			</table>
		</div>
	</body>
</html>
