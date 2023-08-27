function apicall(ask, callback) {
	if (localStorage.getItem("loginUsername") !== "") {
		const body = {
			username: localStorage.getItem("loginUsername"),
			password: localStorage.getItem("loginPassword"),
			ask: ask,
		};
		$.post(apiadress, body, (data, status) => {
			callback(data);
		});
	} else {
		console.error("No credentials!");
	}
}
if (localStorage.getItem("loginUsername") == null) {
	console.log("Oh dear. Not logged in!");
	window.location.hash = "/login/";
}
function apiping() {
	return new Promise((resolve, reject) => {
		// console.log("Ping");
		$.get(`${apiadress}ping/`, "", (successResponse) => {
			// console.log("Pong");
			resolve(successResponse);
		}).fail((failResponse) => {
			reject(failResponse);
		});
	});
}
let pingres;
setTimeout(async () => {
	try {
		pingres = await apiping();
	} catch (error) {
		pingres = "no";
	}
}, 13);
setInterval(async () => {
	try {
		pingres = await apiping();
	} catch (error) {
		pingres = "no";
	}
}, 3000);
function IfUp() {
	// if ((typeof (document.getElementById("content").dataset.pingres) != 'undefined') && ((document.getElementById("content").dataset.pingres) != '') && ((document.getElementById("content").dataset.pingres) != null)) {
	//   if ((document.getElementById("content").dataset.lastping) > (Date.now() - 3000)) {
	//     if ((document.getElementById("content").getAttribute('data-pingres') == 1)) { return true; } else { return false; }
	//   } else {
	//     (document.getElementById("content")).removeAttribute("data-pingres");
	//     (document.getElementById("content")).removeAttribute("data-lastping");
	//   }
	// } else {
	if (pingres === "pong") {
		return true;
		// document.getElementById("content").dataset.pingres = 1;
		// document.getElementById("content").dataset.lastping = Date.now();
	} else {
		return false;
		// document.getElementById("content").dataset.pingres = 0;
	}
	// }
}