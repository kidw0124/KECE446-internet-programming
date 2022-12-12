<!DOCTYPE html>
<html>
	<head>
		<title>Practice 13</title>
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
	<body style="max-width: 95%; margin: 10px auto">
		<?php
			$types[1]="char(128)";
			$types[2]="integer";
			$types[3]="double";
			$link = mysqli_connect('localhost:3306', 'root', '');
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			if(isset($_POST['newtablecreate'])){
				$query ="CREATE TABLE "."world.". "{$_POST['newtablename']} (    ";
				for($i=0; $i<count($_POST['newtablefieldname']); $i++){
					$query .= "{$_POST['newtablefieldname'][$i]} {$types[$_POST['newtablefieldtype'][$i]]}".", ";
				}
				$query = substr($query, 0, -2);
				$query .= ")";
				$create = mysqli_query($link, $query);
				if(!$create){
					echo "Failed to create table " . $_POST['newtablename']. '<br />';
					echo 'Error:' . mysqli_error($link) . '<br />';
				} else {
					echo "Successfully created table ". $_POST['newtablename'] . '<br />';
				}
			}
			$tables = mysqli_query($link,"SHOW TABLES FROM world");
			$tableList = array();
			while($cRow = mysqli_fetch_array($tables)){
				$tableList[] = $cRow[0];
			}
			if(isset($_POST['checkbox'])
				&& isset($_POST['add']['table'])
				&& in_array($_POST['add']['table'], $tableList)){
					$table_fields = mysqli_query($link, "SHOW COLUMNS FROM world." . $_POST['add']['table']);
					while($cRow = mysqli_fetch_array($table_fields)){
						$fields[] = $cRow[0];
						//echo $cRow[0] . '<br />';
					}
					$failcnt=0;
					$succnt=0;
					foreach($_POST['checkbox'] as $value){
						$query = "DELETE FROM world." .$_POST['add']['table'] . " WHERE ";
						$delim=";DD"; $real_value=array();
						foreach($fields as $field){ $loc = strpos($value, $delim);
							$real_value[$field] = substr($value, 0, $loc);
							$value = substr($value, $loc + strlen($delim));
							if($real_value[$field] == ''){
								continue;
							}
							else if(is_numeric($real_value[$field])){
								$real_value[$field] = floatval($real_value[$field]);
								$query .= $field . " = " .$real_value[$field] . " AND ";
							}
							else{
								$query .= $field . " = '" .$real_value[$field] . "' AND ";
							}
						}
						$query = substr($query, 0, -5);
						echo 'query: ' . $query . '<br />';
						$del = mysqli_query($link, $query);
						if(!$del){
							echo "Failed to delete data from the table "
								. $_POST['add']['table'] . mysqli_error($link) . '<br />';
							$failcnt++;
						}
						else{
							echo "Successfully deleted data from the table "
							. $_POST['add']['table'].'<br />';
							$succnt++;
						}
						echo '<br />';
					}
					echo 'Total ' . $succnt . ' rows deleted successfully and ' . $failcnt . ' rows failed to delete.<br />';
				}
				$isadd = false;
				if(isset($_POST['add'])){
					foreach($_POST['add'] as $key =>$value){
						if($key != 'table' && $value != ''){
							$isadd = true;
						}
					}
				}
				if(isset($_POST['add']['table'])
					&& in_array($_POST['add']['table'],$tableList)
					&& $isadd){
						$query = "INSERT INTO world." .$_POST['add']['table'] . " ( ";
						foreach($_POST['add'] as $key => $value){
							if($key != 'table' && $value != ''){
								$query .= $key . ", ";
							}
						}
						$query = substr($query, 0, -2); $query .= ") VALUES ( ";
						foreach($_POST['add'] as $key => $value){
							if($key != 'table' && $value != ''){
								$query .= "'" . $value. "', ";
							}
						}
						$query = substr($query, 0, -2);
						$query .= ")";
						$add = mysqli_query($link, $query);
						if(!$add){
							echo "Failed to add data to the table " . $_POST['add']['table'];
						}
						else {
							echo "Successfully added data to the table " . $_POST['add']['table'];
						}
					}
					if(isset($_POST['search'])
						&& $_POST['search'] != ''
						&& in_array($_POST['search'], $tableList)){
							$table_search = mysqli_query($link, "SELECT * FROM world." .$_POST['search']);
							$table_search_field = mysqli_fetch_fields($table_search);
							} ?>
		<h3>2020330017 김동우</h3>
		<h4>
			<?php
			echo 'Tables in database world: <br />';
			foreach($tableList as $value){
				echo $value . '<br />';
			}?>
		</h4>
		<script type="text/javascript">
			function newTable() {
				var newtable = document.getElementsByName("newtablename")[0].value;
				var newtablefield =
					document.getElementsByName("newtablefield")[0].value;
				console.log(newtablefield);
				document.getElementsByName("newtablefield")[0].innerHTML =
					"Fields : " + newtablefield;
				console.log(newtablefield);

				var newtablefieldstr = "<h3>Create new table</h3>\n";
				newtablefieldstr += "<h4>Table Name : " + newtable + "</h4>\n";
				newtablefieldstr +=
					'<input type="hidden" name="newtablename" value="' +
					newtable +
					'" />\n';
				newtablefieldstr += "<h4>Fields : " + newtablefield + "</h4>\n";
				newtablefieldstr +=
					'<input type="hidden" name="newtablefield" value="' +
					newtablefield +
					'" />\n';
				newtablefieldstr += "<h4>Type for Field</h4>";
				for (var i = 0; i < newtablefield; i++) {
					console.log(i);
					newtablefieldstr +=
						'<input type="text" name="newtablefieldname[]" placeholder="field name" /><select name="newtablefieldtype[]"><option value="1">char(128)</option><option value="2">integer</option><option value="3">double</option></select><br/>\n';
				}
				newtablefieldstr +=
					'<button type="submit" name="newtablecreate" value="newtablecreate">Create</button>\n';
				console.log(newtablefieldstr);
				document.getElementById("newtablecreate").innerHTML = newtablefieldstr;
			}
		</script>
		<h4>
			<?php
				if(isset($add) && $add){
					echo "Successfully added " . $_POST['add']['table'] . " to the database.";
				}
				else if(isset($add) && !$add){
					echo "Failed to add " . $_POST['add']['table'] . " to the database.";
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
			<div id="newtablecreate">
				<h3>Create new table</h3>
				<input type="text" name="newtablename" placeholder="new table name" />
				<input
					type="number"
					name="newtablefield"
					placeholder="number of fields"
				/>
				<button type="button" id="newtable" onclick="newTable()">Create</button>
			</div>
			<br />
			<h3>Search table</h3>
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
					<input name="search" placeholder="Search table" style="width:80%"
					<?php
						if (isset($_POST['search']) && $_POST['search'] != '') {
							echo "value=\"{$_POST['search']}\"";
						}
					?>
					/>
					<button>Search</button>
				</div>
				<h3 style="text-align: left">Add Row to Table</h3>
				<div
					style="
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						width: 100%;
					"
				>
					<div style="display: flex; flex-direction: column; width: 100%">
						<?php
							if(isset($table_search_field)){
								echo "<input name=\"add[table]\" class=\"add\"
								style=\"display: none\" value=\"{$_POST['search']}\">
								</input>";
								foreach($table_search_field as $value){
									echo "<b>{$value->name}</b>";
									echo "<input name=\"add[{$value->name}]\" placeholder=\"{$value->name}\" class=\"add\" />";
								}
							}
						?>
						<button id="add-button"
						<?php if(!isset($table_search)){echo "disabled";} ?>
						>ADD ROW</button>
					</div>
				</div>
				<div
					style="
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						width: 100%;
					"
				>
					<button id="delete-select-button"
					<!-- <?php if(!isset($table_search)){echo "disabled";} ?>
					>Delete Selected</button> -->
				</div>
				<div style="text-align: left; width: 100%">
					<?php
						if (isset($table_search)) {
							echo "<br>"; echo "Total rows: " . mysqli_num_rows($table_search); } ?>
				</div>
			</div>
			<?php
				if (isset($_POST['search']) && $_POST['search'] != '') {
					echo "<h4>Search result for \"{$_POST['search']}\"</h4>";
				}
				if(!isset($table_search)){
					echo "<h4>Table not found</h4>";
				}
			?>
			<table id="db-table">
				<tr>
					<?php
						if(isset($table_search)){
							echo "<th><input type='checkbox' id='check-all' /></th>";
							foreach($table_search_field as $key => $value){
								echo "<th>{$value->name}</th>";
							}
						}
					?>
				</tr>
				<?php
				if(isset($table_search)){
					while($table_row = mysqli_fetch_row($table_search)){
						$row_value = '';
						foreach($table_row as $key => $value){
							$row_value .= (string)$value .";DD";
						}
						echo "<tr name=\"row[]\">";
						echo "<td style=\"text-align: center\"><input
							type=\"checkbox\" name=\"checkbox[]\"
							value=\"$row_value\" class=\"checkboxcity\" />
							</td>";
						foreach($table_row as $key => $value){
							echo "<td>";
							echo $value;
							echo "</td>";
						}
						echo "</tr>";
					}
				}?>
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
				</script>
			</table>
		</form>
	</body>
</html>
