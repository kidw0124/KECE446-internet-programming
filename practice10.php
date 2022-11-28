<!DOCTYPE html>
<html>
	<head>
		<title>Practice 10</title>
		<meta charset="utf-8" />
		<style type="text/css">
			.calculator {
				display: flex;
				flex-direction: column;
				border: none;
				border-radius: 10px;
				padding: 10px;
				justify-content: center;
				align-items: center;
				background-color: #d7e3fc;
				background-image: url("https://cdn-icons-png.flaticon.com/512/6247/6247204.png");
				background-position: 100% 0%;
				background-repeat: no-repeat;
				background-size: auto 100%;
			}
			.input-panel,
			.output-panel {
				height: 2rem;
				text-align: center;
				display: flex;
				flex-direction: row;
				justify-content: center;
				width: 80%;
				border: none;
				margin: 5px;
				background-color: #edf2fb;
				font-family: "Courier New", Courier, monospace;
				overflow-x: visible;
				background-image: url("https://cdn-icons-png.flaticon.com/512/2942/2942909.png");
				background-size: 100% 100%;
				background-position: 0% 50%;
				border-radius: 10px;
			}
			.buttons-zip {
				width: 80%;
				border: none;
				margin: 0;
				padding: 0;
				display: flex;
				flex-direction: row;
				justify-content: center;
				margin: 5px;
				padding: 5px 0px;
				background-color: #edf2fb;
				font-family: "Courier New", Courier, monospace;
				background-image: url("https://cdn-icons-png.flaticon.com/512/2942/2942909.png");
				background-size: auto;
				background-position: 0% 50%;
				border-radius: 10px;
			}
			#input-num {
				background-image: url("https://cdn-icons-png.flaticon.com/512/2942/2942909.png");
				background-position: 0% 70%;
			}
			#output-num {
				background-image: url("https://cdn-icons-png.flaticon.com/512/2942/2942909.png");
				background-position: 0% 80%;
			}
			#input-num,
			#output-num {
				border: none;
				margin: 0;
				padding: 0;
				background-color: #edf2fb;
				font-family: "Courier New", Courier, monospace;
				font-weight: bold;
			}
			button {
				width: 3rem;
				height: 100%;
				background-color: #b6ccfe;
				font-family: "Courier New", Courier, monospace;
				font-weight: bold;
				border: none;
				border-radius: 10px;
				font-size: 1.2rem;
			}
			button:hover {
				background-color: #ccdbfd;
			}
		</style>
	</head>
	<body style="max-width: 500px; margin: 10px auto">
		<h3>2020330017 김동우</h3>
		<form class="calculator" action="./practice10.php" method="post">
			<div class="input-panel">
            <?php
                if (isset($_POST['equation'])) {
                    try{
                        $equation = $_POST['equation'];
                        eval("\$result = $equation;");
                    } catch (ParseError $e) {
                        $result = "Error";
                    }
                }
            ?>
				<input
					type="text"
					id="input-num"
					style="
						width: 100%;
						height: 100%;
						text-align: right;
						font-size: 1.5rem;
						border: none;
						outline: none;
						background-color: #edf2fb;
					"
					placeholder="Input Number"
					onkeyup="
                        var start = this.selectionStart;
                        var end = this.selectionEnd;
                        this.value = this.value.toUpperCase();
                        this.setSelectionRange(start, end);
                    "
					name="equation"
                    <?php
                        if (isset($_POST['equation'])) {
                            echo "value=\"$equation\"";
                        }
                    ?>
				/>
			</div>

			<div class="output-panel">
				<div
					id="output-num"
					style="
						width: 100%;
						height: 100%;
						text-align: right;
						font-size: 1.5rem;
						border: none;
						outline: none;
						background-color: #edf2fb;
					"
				>
                <?php
                    if (isset($_POST['equation'])) {
                        echo $result;
                    }
                ?>
            </div>
			</div>
			<div class="buttons-zip">
				<table>
					<tr>
						<td>
							<button type="button" id="(">(</button>
						</td>
						<td>
							<button type="button" id=")">)</button>
						</td>
					</tr>
					<tr>
						<td>
							<button type="button" id="7">7</button>
						</td>
						<td>
							<button type="button" id="8">8</button>
						</td>
						<td>
							<button type="button" id="9">9</button>
						</td>
						<td>
							<button type="button" id="/">/</button>
						</td>
						<td>
							<button type="button" id="back">←</button>
						</td>
					</tr>
					<tr>
						<td>
							<button type="button" id="4">4</button>
						</td>
						<td>
							<button type="button" id="5">5</button>
						</td>
						<td>
							<button type="button" id="6">6</button>
						</td>
						<td>
							<button type="button" id="*">*</button>
						</td>
						<td>
							<button type="button" id="esc">C</button>
						</td>
					</tr>
					<tr>
						<td>
							<button type="button" id="1">1</button>
						</td>
						<td>
							<button type="button" id="2">2</button>
						</td>
						<td>
							<button type="button" id="3">3</button>
						</td>
						<td>
							<button type="button" id="-">-</button>
						</td>
						<td rowspan="2">
							<button id="enter">
								<br />
								=
								<br />
								<br />
							</button>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<button type="button" id="0">0</button>
						</td>
						<td>
							<button type="button" id=".">.</button>
						</td>
						<td>
							<button type="button" id="+">+</button>
						</td>
					</tr>
				</table>
			</div>
			<script type="text/javascript">
				let nums = [
					"0",
					"1",
					"2",
					"3",
					"4",
					"5",
					"6",
					"7",
					"8",
					"9",
					".",
					"(",
					")",
					"+",
					"-",
					"*",
					"/",
				];
				let ops = ["C", "=", "←"];

				nums.forEach((num) => {
					document.getElementById(num).addEventListener("click", () => {
						document.getElementById("input-num").value += num;
					});
				});
				document.getElementById("esc").addEventListener("click", () => {
					document.getElementById("input-num").value = "";
					document.getElementById("output-num").innerHTML = "";
				});
				document.getElementById("back").addEventListener("click", () => {
					document.getElementById("input-num").value = document
						.getElementById("input-num")
						.value.slice(0, -1);
				});
				document.addEventListener("keydown", (e) => {
					if (e.key === "Escape") {
						document.getElementById("input-num").value = "";
						document.getElementById("output-num").innerHTML = "";
					} else if (e.key === "Backspace") {
						document.getElementById("input-num").value = document
							.getElementById("input-num")
							.value.slice(0, -1);
					}
				});
			</script>
		</form>
	</body>
</html>
