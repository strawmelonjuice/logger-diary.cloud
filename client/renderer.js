function getLang(a, b, c, d) {
	d(a + b + c);
}
function handleWindowControls() {
	document.getElementById("min-button").addEventListener("click", (event) => {
		window.ipcRender.send("window:minify");
	});

	document.getElementById("max-button").addEventListener("click", (event) => {
		window.ipcRender.send("window:maxify");
		document.body.classList.add("maximized");
	});

	document
		.getElementById("restore-button")
		.addEventListener("click", (event) => {
			window.ipcRender.send("window:unmaxify");
			document.body.classList.remove("maximized");
		});

	document.getElementById("close-button").addEventListener("click", (event) => {
		window.ipcRender.send("window:close");
	});
}
handleWindowControls();
const pagecontent = document.getElementById("content");
const setPageStyling = function (PageStylingCSS) {
	if (document.getElementById("contentstyling") != null) {
		document.getElementById("contentstyling").remove;
	}
	const pageStyleSheet = document.createElement("style");
	pageStyleSheet.innerHTML = PageStylingCSS;
	document.head.appendChild(pageStyleSheet);
};
const setPageContent = function (PageContentHTML, instant = false) {
	if (instant === false) {
		pagecontent.style.width = "0px";
		setTimeout(() => {
			pagecontent.innerHTML = PageContentHTML;
			pagecontent.style.width = "";
		}, 5000);
	} else {
		pagecontent.innerHTML = PageContentHTML;
		pagecontent.style.width = "";
	}
};
function pageLoader(instant = false) {
	console.log("Page actualisation check");
	if (window.location.hash !== pagecontent.dataset.currentView) {
		console.log("Actualising...");
		switch (window.location.hash) {
			case "#/login/":
				setPageStyling(`
                body {
                    background-color: pink;
                }
                `);
				setPageContent(
					`
                <form id="loginform" action="#/gologin/" method="get">
                    <div class="form-group">
                        <label><h4>Username</h4></label>
                            <input type="text" name="username" id="username-input" class="LoginForm " value="Just_Mar_Ok">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group">
                        <label><h4>Password</h4></label>
                            <input type="password" name="password" id="password-input" class="LoginForm " value="xxosihH8riEq7c">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group"><br></br>
                        <input type="submit" class="LoginForm LoginButton" value="Continue!">
                    </div>
                    <p>Don't have an account? <a href="https://logger-diary.online/register/" target="_blank">Sign up online</a>.</p>
                </form>
                `,
					instant,
				);
				pagecontent.dataset.currentView = "#/login/";
				break;
			case "#/gologin/":
				break;
			case "#/unavailable/":
				console.error(window.unavailabilityReason);
				setPageStyling(`
          #unavailabilityReason {
            color: white;
            background-color: red
          }
        `);
				setPageContent(
					`
                <h2>Couldn't connect!</h2>
                <p>Reason:</p>
                <p><code id="unavailabilityReason">${window.unavailabilityReason}</code></p>
                <p><button>Retry</button></p>
                `,
					instant,
				);
				pagecontent.dataset.currentView = "#/unavailable/";
				break;
			default:
				// case "#/home/":
				setPageStyling(`
        
        `);
				setPageContent(
					`
        <p>Home page!</p>
        <div class="readback" align="center">
        <span id='ShowEntriesBtn'>
          <p style="vertical-align:bottom"><br>
            <text style="font-size: 2em" class="translatable" data-translation_1="25" data-translation_2="1"></text>&nbsp;
            <img src="/img/animated/1485.gif" class="svgrecolor" width="30em" style="display: inline-block">
          </p>
          <p id="ponsloe" style="font-size: 1.2em"><img src="/img/animated/1484.png" class="svgrecolor" width="20em" style="display: inline-block"></p>
          <input type='button' onclick='tableFromJson()' id="bonsloe" disabled value='Retry' style="opacity: 10%; transition: opacity 3s ease-in 0s;">
        </span>

        <span id='showData' id="readbacktable" class="readback" align="center"></span>
      </div>
        `,
					instant,
				);
				{
					setTimeout(function () {
						bonsloe = document.getElementById("bonsloe");
						if (typeof bonsloe !== "undefined" && bonsloe != null) {
							bonsloe.removeAttribute("disabled");
							bonsloe.style.opacity = "100%";
							bonsloe.addEventListener("click", function () {
								tableFromJson();
							});
						}
					}, 15000);
					function timeDifference(previous) {
						current = Date.now();
						// https://stackoverflow.com/a/6109105
						// But modified alot lol
						const msPerMinute = 60 * 1000;
						const msPerHour = msPerMinute * 60;
						const msPerDay = msPerHour * 24;
						const msPerWeek = msPerDay * 7;
						const msPerMonth = msPerDay * 30;
						const msPerYear = msPerDay * 365;

						const elapsed = current - previous;

						if (elapsed < msPerMinute) {
							return `${Math.round(
								elapsed / 1000,
							)} <text  class="translatable" data-translation_1="82" data-translation_2="1"></text>`;
						} else if (elapsed < msPerHour) {
							return `${Math.round(
								elapsed / msPerMinute,
							)} <text  class="translatable" data-translation_1="82" data-translation_2="2"></text>`;
						} else if (elapsed < msPerDay) {
							return `${Math.round(
								elapsed / msPerHour,
							)} <text  class="translatable" data-translation_1="82" data-translation_2="3"></text>`;
						} else if (Math.round(elapsed / msPerDay) > 2) {
							// Too long ago, we don't need all that.
							return "";
						} else if (Math.round(elapsed / msPerDay) === 1) {
							return '<text  class="translatable" data-translation_1="82" data-translation_2="5"></text>';
						} else if (elapsed < msPerMonth) {
							return `${Math.round(
								elapsed / msPerDay,
							)} <text  class="translatable" data-translation_1="82" data-translation_2="4"></text>`;
						}
					}
					setTimeout(function () {
						bonsloe = document.getElementById("bonsloe");
						if (typeof bonsloe !== "undefined" && bonsloe != null) {
							bonsloe.removeAttribute("disabled");
							bonsloe.style.opacity = "100%";
							bonsloe.addEventListener("click", function () {
								tableFromJson();
							});
						}
					}, 15000);
					const d = new Date();
					const uur = d.getHours();
					quarter = parseInt(Math.round((uur / 24) * 4));
					if (quarter === 0) {
						quarter = 1;
					}
					getLang(8, quarter, "", function (greet) {
						// document.getElementById("greeting").innerHTML = greet;
					});
					function tableFromJson() {
						const ponsloe = document.getElementById("ponsloe");
						// Rico is here because I used to include the counting in the string, but for some reason  the order wasn' t always right. Rico is here so I can say "Not yet boom, rico."
						let rico = new Number();
						getLang(25, 2, "", function (alet) {
							rico = 1;
							teal = `${alet} (${rico}/5)`;
							console.log(teal);
							ponsloe.innerText = teal;
						});
						apicall("entries", function (entryListvar) {
							const entryList = entryListvar;
							getLang(25, 3, "", function (alet) {
								rico++;
								teal = `${alet} (${rico}/5)`;
								// Unpacking entry data
								console.log(teal);
								ponsloe.innerText = teal;
							});
							const col = [];
							for (let i = 0; i < entryList.length; i++) {
								for (const key in entryList[i]) {
									if (col.indexOf(key) === -1) {
										col.push(key);
									}
								}
							}
							getLang(25, 4, "", function (alet) {
								rico++;
								teal = `${alet} (${rico}/5)`;
								// Creating a table to put the data into
								console.log(teal);
								ponsloe.innerText = teal;
							});
							const table = document.createElement("table");
							let tr = table.insertRow(-1);

							for (let i = 0; i < col.length; i++) {
								const th = document.createElement("th");
								th.innerHTML = col[i];
								th.id = `ReadBackTH_${col[i]}`;
								switch (col[i]) {
									case "Date":
										getLang(18, "", "", function (text) {
											th.innerText = text;
										});
										break;
									case "Text":
										getLang(19, "", "", function (text) {
											th.innerText = text;
										});
										break;
									case "Feel":
										getLang(20, "", "", function (text) {
											th.innerText = text;
										});
										break;
								}
								tr.appendChild(th);
							}
							getLang(25, 5, "", function (alet) {
								rico++;
								teal = `${alet} (${rico}/5)`;
								// Organising entry data into table
								console.log(teal);
								ponsloe.innerText = teal;
							});
							for (let i = 0; i < entryList.length; i++) {
								tr = table.insertRow(-1);

								for (let j = 0; j < col.length; j++) {
									const tabCell = tr.insertCell(-1);
									tabCell.innerHTML = entryList[i][col[j]];
									tabCell.className = `readbacktable_${col[j]}`;

									switch (col[j]) {
										case "Date":
											if (
												tabCell.hasChildNodes &&
												tabCell.children[0] != null &&
												tabCell.children[0].tagName.toLowerCase() === "span"
											) {
												tstamp = parseInt(tabCell.children[0].innerText);
											} else {
												tstamp = parseInt(tabCell.innerText);
											}
											date = new Date(tstamp * 1000);
											fulldatedispl = `${date.getDate()}/${
												date.getMonth() + 1
											}/${date.getFullYear()}<br> <span class=\"timefonted\">${date.getHours()}:${String(
												date.getMinutes(),
											).padStart(2, "0")}</span>`;
											if (timeDifference(tstamp * 1000) === "") {
												tabCell.classList.add("entrydate");
												date = new Date(tstamp * 1000);
												tabCell.innerHTML = fulldatedispl;
											} else {
												if (usersetting.relativetimes) {
													tabCell.style.fontSize = "100%";
													tabCell.innerHTML = timeDifference(tstamp * 1000);
												}
											}
											break;
										case "Text":
											// hi
											break;
										case "Feel":
											tabCell.classList.add("emojis");
											if (
												!tabCell.hasChildNodes &&
												tabCell.children[0].tagName.toLowerCase() === "span"
											) {
												tabCell.innerHTML = tabCell.children[0].innerText;
											}
											break;
									}
								}
							}
							getLang(25, 6, "", function (alet) {
								rico++;
								teal = `${alet} (${rico}/5)`;
								// Ready to show entries!
								console.log(teal);
								ponsloe.innerText = teal;
							});
							table.id = "readbacktable";
							table.setAttribute("align", "center");
							const divShowData = document.getElementById("showData");
							divShowData.innerHTML = "";
							divShowData.appendChild(table);
							document.getElementById("ShowEntriesBtn").style.display = "none";
							document.getElementById("ShowEntriesBtn").innerHTML = "";
							document.getElementById("ShowEntriesBtn").remove();
						});
					}
				}
				window.location.hash = "/home/";
				pagecontent.dataset.currentView = "#/home/";
				break;
		}
		// ReLoadLang()
	}
}
document.body.addEventListener("click", (event) => {
	if (!IfUp()) {
		window.unavailabilityReason = "API down.";
		window.location.hash = "/unavailable/";
	} else {
		if (window.unavailabilityReason === "API down.") {
			window.unavailabilityReason = "";
			window.location.hash = "/home/";
		}
	}
});
addEventListener("offline", () => {
	window.unavailabilityReason = "Internet unavailable.";
	window.location.hash = "/unavailable/";
});
addEventListener("online", () => {
	window.unavailabilityReason = "";
	window.location.hash = "/home/";
});
setTimeout(() => {
	pageLoader(true);
	addEventListener("hashchange", () => {
		pageLoader(false);
	});
}, 20);
