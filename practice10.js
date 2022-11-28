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
