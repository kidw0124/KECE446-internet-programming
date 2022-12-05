<!DOCTYPE html>
<html>
	<head>
		<title>Practice 12</title>
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
	<body style="max-width: 1000px; margin: 10px auto">
		<?php
			$link = mysqli_connect('localhost:3306', 'root', '');
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			if(isset($_POST['checkbox'])){
				foreach($_POST['checkbox'] as $value){
					$kor_city = mysqli_query($link, "SELECT * FROM world.city WHERE ID = $value");
					$deleted_city[] = mysqli_fetch_assoc($kor_city);
					mysqli_query($link, "DELETE FROM world.city WHERE ID = $value");
				}
			}
			if(isset($_POST['add'])){
				$real_add = ($_POST['add']['Name'] != ''
								&& $_POST['add']['CountryCode'] != ''
								&& $_POST['add']['Population'] != '');
				if($_POST['add']['District'] == ''){
					$_POST['add']['District'] = $_POST['add']['Name'];
				}
				if($real_add){
					$add = 	mysqli_query($link,
						"INSERT INTO world.city
							(Name, CountryCode, District, Population) VALUES
							(\"" . $_POST['add']['Name'] . "\", \""
							. $_POST['add']['CountryCode'] . "\", \"" .
							$_POST['add']['District'] . "\", " . $_POST['add']['Population'] . ")");
				}
			}
			if (isset($_POST['search'])
					&& $_POST['search'] != '') {
				$kor_city = mysqli_query($link,
											"SELECT * FROM world.city
											WHERE CountryCode = 'KOR' AND
											name LIKE '%{$_POST['search']}%'");
			}
			else{
				$kor_city = mysqli_query($link,
											"SELECT * FROM world.city
											WHERE CountryCode = 'KOR'");
			}
		?>
		<h3>2020330017 김동우</h3>
		<h4>
			<?php
				if(isset($deleted_city)){
					echo count($deleted_city) . ' cities are deleted.';
					echo '<br />';
					foreach($deleted_city as $value){
						echo $value['Name'] . ', ';
					}
					echo 'are deleted.';
				} ?>
		</h4>
		<h4>
			<?php
				if(isset($add) && $add){
					echo "Successfully added " . $_POST['add']['Name'] . " to the database.";
				}
				else if(isset($add) && !$add){
					echo "Failed to add " . $_POST['add']['Name'] . " to the database.";
				}
			?>
		</h4>
		<form
			action="<?php
						echo $_SERVER['PHP_SELF'];
					?>"
			method="post"
			id="city-in-korea"
			style="width: 100%"
		>
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
				<div
					style="
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						width: 100%;
					"
				>
					<input name="search" placeholder="Search City" style="width:80%"
					<?php
						if (isset($_POST['search']) && $_POST['search'] != '') {
							echo "value=\"{$_POST['search']}\"";
						}
					?>
					/>
					<button>Search</button>
				</div>
				<div
					style="
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						width: 100%;
					"
				>
					<b>Name</b>
					<input name="add[Name]" placeholder="City Name" class="add" />
					<b>Population</b>
					<input
						type="number"
						name="add[Population]"
						placeholder="Population"
						class="add"
					/>
					<b>District</b>
					<input name="add[District]" placeholder="District" class="add" />
					<b>Country Code</b>
					<input
						name="add[CountryCode]"
						value="KOR"
						maxlength="3"
						minlength="3"
						length="3"
						style="width: 3rem"
						class="add"
					/>
					<button id="add-button" disabled>ADD</button>
				</div>
				<div
					style="
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						width: 100%;
					"
				>
					<button id="delete-select-button">Delete Selected</button>
				</div>
				<div style="text-align: left; width: 100%">
					<?php
						if (isset($_POST['search'])&& $_POST['search'] != '') {
							echo "Search result for \"{$_POST['search']}\"";
							echo "<br>"; } echo "Total: " . mysqli_num_rows($kor_city); ?>
				</div>
			</div>
			<table id="city-in-korea-table">
				<tr>
					<th><input type="checkbox" id="check-all" /></th>
					<?php
						while($kor_city_fields = mysqli_fetch_field($kor_city)){
							echo "<th>".($kor_city_fields->name)."</th>";
						}
					?>
				</tr>
				<?php
					while($kor_city_row = mysqli_fetch_row($kor_city)){
						echo "<tr name=\"row[]\">";
						echo "<td style=\"text-align: center\"><input
							type=\"checkbox\" name=\"checkbox[]\"
							value=\"$kor_city_row[0]\" class=\"checkboxcity\" />
						</td>";
						foreach($kor_city_row as $key => $value){
							echo "<td>";
							$len = strlen($value);
							if($key ==1 && isset($_POST['search']) && $_POST['search'] != ''){
								$value_to_lower = strtolower($value);
								$search_to_lower = strtolower($_POST['search']);
								do {
									$pos = strpos($value_to_lower, $search_to_lower);
									if ($pos !== false) {
										echo substr($value, 0, $pos);
										echo "<span style=\"background-color: yellow\">";
										echo substr($value, $pos, strlen($_POST['search']));
										echo "</span>";
										$value = substr($value, $pos + strlen($_POST['search']));
										$value_to_lower = substr($value_to_lower,
																$pos + strlen($_POST['search']));
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
				<script type="text/javascript">
					function checkAll() {
						var checkboxes = document.querySelectorAll(
							'input[type="checkbox"]'
						);
						for (var checkbox of checkboxes) {
							checkbox.checked = true;
						}
					}
					function uncheckAll() {
						var checkboxes = document.querySelectorAll(
							'input[type="checkbox"]'
						);
						for (var checkbox of checkboxes) {
							checkbox.checked = false;
						}
					}
					document
						.getElementById("check-all")
						.addEventListener("click", function () {
							if (this.checked) {
								checkAll();
							} else {
								uncheckAll();
							}
						});
					var cb_city = document.getElementsByClassName("checkboxcity");
					for (var i = 0; i < cb_city.length; i++) {
						cb_city[i].addEventListener("change", function () {
							if (this.checked == false) {
								document.getElementById("check-all").checked = false;
							}
							if (
								document.querySelectorAll('input[type="checkbox"]:checked')
									.length >= cb_city.length
							) {
								document.getElementById("check-all").checked = true;
							}
						});
					}
					var add_input = Array.from(document.getElementsByClassName("add"));
					add_input.forEach(function (element) {
						element.addEventListener("input", function () {
							if (this.value != "") {
								document.getElementById("add-button").disabled = false;
								add_input.forEach(function (element) {
									if (element.value.trim() == "") {
										document.getElementById("add-button").disabled = true;
										return;
									}
								});
							}
						});
					});
					document
						.getElementsByName("add[Name]")[0]
						.addEventListener("input", function () {
							if (
								document.getElementsByName("add[District]")[0].value == "" ||
								document.getElementsByName("add[District]")[0].value ==
									this.value.slice(0, -1)
							) {
								document.getElementsByName("add[District]")[0].value =
									this.value;
							}
						});
				</script>
			</table>
		</form>
	</body>
</html>
