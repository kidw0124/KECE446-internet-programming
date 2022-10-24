var equation = "";
for (let i = 0; i <= 9; i++) {
	document.getElementById(i.toString()).addEventListener("click", () => {
		document.getElementsByClassName("equation-panel")[0].innerHTML +=
			i.toString();
		document.getElementsByClassName("answer-panel")[0].innerHTML = "";
	});
}

const chars = ["dot", "plus", "minu", "mul", "divi", "op", "cp"];
const symbols = [".", "+", "-", "*", "/", "(", ")"];
const chracs = {
	divi: "/",
	mul: "*",
	plus: "+",
	minu: "-",
	dot: ".",
	op: "(",
	cp: ")",
	"/": "divi",
	"*": "mul",
	"+": "plus",
	"-": "minu",
	".": "dot",
	"(": "op",
	")": "cp",
};

chars.forEach((x) => {
	document.getElementById(x).addEventListener("click", () => {
		document.getElementsByClassName("equation-panel")[0].innerHTML += chracs[x];
		document.getElementsByClassName("answer-panel")[0].innerHTML = "";
	});
});
document.getElementById("back").addEventListener("click", () => {
	let str = document.getElementsByClassName("equation-panel")[0].innerHTML;
	if (str.length > 0) {
		document.getElementsByClassName("equation-panel")[0].innerHTML = str.substr(
			0,
			str.length - 1
		);
		document.getElementsByClassName("answer-panel")[0].innerHTML = "";
	}
});
document.getElementById("esc").addEventListener("click", () => {
	document.getElementsByClassName("equation-panel")[0].innerHTML = "";
	document.getElementsByClassName("answer-panel")[0].innerHTML = "";
});
document.getElementById("enter").addEventListener("click", () => {
	try {
		document.getElementsByClassName("answer-panel")[0].innerHTML = eval(
			document.getElementsByClassName("equation-panel")[0].innerHTML
		);
	} catch (e) {
		document.getElementsByClassName("answer-panel")[0].innerHTML = e;
	}
});
document.addEventListener("keydown", (e) => {
	if (e.key >= "0" && e.key <= "9") {
		document.getElementById(e.key).click();
	} else if (symbols.includes(e.key)) {
		document.getElementById(chracs[e.key]).click();
	} else {
		switch (e.key) {
			case "Enter":
				document.getElementById("enter").click();
				break;
			case "Backspace":
				document.getElementById("back").click();
				break;
			case "Escape":
				document.getElementById("esc").click();
				break;
		}
	}
});
