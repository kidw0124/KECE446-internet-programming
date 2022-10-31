var turn = 0;
var now = 0;
var prev = undefined;
var fir_score = 0,
	fir_tries = 0;
var sec_score = 0,
	sec_tries = 0;
var check = false;
var n = 0;
var check_cards = {};
const shapes = ["spades", "hearts", "diamonds", "clubs"];
const numbers = [
	"ace",
	"2",
	"3",
	"4",
	"5",
	"6",
	"7",
	"8",
	"9",
	"10",
	"jack",
	"queen",
	"king",
];

function get_number() {
	var n = 0;
	do {
		var input = prompt("Enter pairs of cards (a number between 1 and 52)");
		if (isNaN(input)) {
			alert("You must enter a number");
		} else if (input < 1 || input > 52) {
			alert("You must enter a number between 1 and 52");
		} else {
			n = parseInt(input);
		}
	} while (n == 0);
	return n;
}
function flip_card(card) {
	if (prev == card || check || check_cards[card.className]) {
		return;
	}
	check = true;
	card.style.filter = "brightness(1)";
	if (now == 0) {
		prev = card;
		now = 1;
		check = false;
	} else {
		if (prev.className == card.className) {
			if (turn == 0) {
				fir_score++;
				fir_tries++;
				document.getElementById("first-player").innerHTML =
					"First player : " + fir_score + " / " + fir_tries;
			} else {
				sec_score++;
				sec_tries++;
				document.getElementById("second-player").innerHTML =
					"Second player : " + sec_score + " / " + sec_tries;
			}
			prev.disabled = true;
			card.disabled = true;
			prev = undefined;
			now = 0;
			turn = 1 - turn;
			check = false;
			document.getElementById("turn").innerHTML =
				(turn == 0 ? "First" : "Second") +
				" player's Turn " +
				(turn == 0 ? fir_tries + 1 : sec_tries + 1);
			document.getElementById("turn").style.color = turn == 0 ? "red" : "blue";
			check_cards[card.className] = true;
		} else {
			if (turn == 0) {
				fir_tries++;
				document.getElementById("first-player").innerHTML =
					"First player : " + fir_score + " / " + fir_tries;
			} else {
				sec_tries++;
				document.getElementById("second-player").innerHTML =
					"Second player : " + sec_score + " / " + sec_tries;
			}
			setTimeout(function () {
				prev.style.filter = "brightness(0)";
				card.style.filter = "brightness(0)";
				prev = undefined;
				now = 0;
				turn = 1 - turn;
				check = false;
				document.getElementById("turn").innerHTML =
					(turn == 0 ? "First" : "Second") +
					" player's Turn " +
					(turn == 0 ? fir_tries + 1 : sec_tries + 1);
				document.getElementById("turn").style.color =
					turn == 0 ? "red" : "blue";
			}, 1000);
		}
	}
	if (fir_score + sec_score == n) {
		if (fir_score > sec_score) {
			alert("First player won!");
		} else if (fir_score < sec_score) {
			alert("Second player won!");
		} else if (fir_score / fir_tries > sec_score / sec_tries) {
			alert("First player won!");
		} else if (fir_score / fir_tries < sec_score / sec_tries) {
			alert("Second player won!");
		} else {
			alert("Draw!");
		}
		document.getElementById("turn").innerHTML = "Game Over";
		document.getElementById("turn").style.color = "black";
	}
}
function make_table(n) {
	var rows = Math.ceil((2 * n) / 10);
	var cols = 10;
	var table = document.getElementById("cards-table");
	var cards = [];
	for (var i = 0; i < n; i++) {
		var nownumber = numbers[i % 13];
		var nowshape = shapes[Math.floor(i / 13)];
		cards.push(nownumber + "_of_" + nowshape);
		check_cards[nownumber + "_of_" + nowshape] = false;
	}
	for (var i = 0; i < n; i++) {
		var nownumber = numbers[i % 13];
		var nowshape = shapes[Math.floor(i / 13)];
		cards.push(nownumber + "_of_" + nowshape);
	}
	cards.sort(() => Math.random() - 0.5);
	for (var i = 0; i < rows; i++) {
		var row = table.insertRow();
		for (var j = 0; j < cols; j++) {
			var cell = row.insertCell();
			if (i * 10 + j < 2 * n) {
				var src = "./trump cards/" + cards[i * 10 + j] + ".png";
				cell.innerHTML =
					"<img class='" + cards[i * 10 + j] + "' src='" + src + "'/>";
				cell.firstChild.style.width = "100%";
				cell.firstChild.style.height = "100%";
				cell.firstChild.style.objectFit = "contain";
				cell.firstChild.style.filter = "brightness(0)";
				cell.firstChild.onclick = function () {
					flip_card(this);
				};
			}
		}
	}
}
n = get_number();
make_table(n);
