function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function doViewNav() {
    (document.getElementsByClassName("sidenav")[0]).style.width = "250px";
    // document.getElementById("main").style.marginLeft = "250px";
    document.getElementById("main").style.filter = "brightness(20%) opacity(20%) blur(25px)";
    document.getElementById("ViewNavButton").style.display = "none";
}
function doHideNav() {
    (document.getElementsByClassName("sidenav")[0]).style.width = "0";
    // document.getElementById("main").style.marginLeft = "0";
    document.getElementById("main").style.filter = "none";
    document.getElementById("ViewNavButton").style.display = "inline-block";
    lessLinks()
}
function contrastingColor(color) {
    return (luma(color) >= 165) ? '000' : 'fff';
}
function luma(color) // color can be a hx string or an array of RGB values 0-255
{
    var rgb = (typeof color === 'string') ? hexToRGBArray(color) : color;
    return (0.2126 * rgb[0]) + (0.7152 * rgb[1]) + (0.0722 * rgb[2]); // SMPTE C, Rec. 709 weightings
}
function hexToRGBArray(color) {
    if (color.length === 3)
        color = color.charAt(0) + color.charAt(0) + color.charAt(1) + color.charAt(1) + color.charAt(2) + color.charAt(2);
    else if (color.length !== 6)
        throw ('Invalid hex color: ' + color);
    var rgb = [];
    for (var i = 0; i <= 2; i++)
        rgb[i] = parseInt(color.substr(i * 2, 2), 16);
    return rgb;
}
function rgbToHex(r, g, b) {
    return (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1);
}

function moreLinks() {
    document.getElementById("menumorelinks").style.display = "block";
    // mmlt: menu more links trigger
    document.getElementById("mmlt").style.display = "none";
}

function lessLinks() {
    document.getElementById("menumorelinks").style.display = "none";
    document.getElementById("mmlt").style.display = "block";
}
window.addEventListener('onclick', function (e) {
    console.log('Click detected.');
    if ((document.getElementsByClassName("sidenav")[0]).contains(e.target)) {
        console.log('Clicked to nav');
    } else {
        doHideNav();
    }
});

function ParseThisTimeStamp(e) {
    var caller = (document.getElementById(e));
    // caller = document.getElementById(caller.id);
    // console.log("filter: " + (caller.style.filter));
    if ((caller.style.filter) != ('none')) {
        let timestamp = caller.innerHTML;
        if (caller.id != "") {
            console.log("Parsing timestamp of element with ID: " + caller.id)
        } else {
            console.log("Parsing timestamp of an " + caller + " without ID.")
        }
        const jstimestamp = timestamp * 1000;
        const dateObject = new Date(jstimestamp);
        const data = dateObject.toLocaleString();
        const date = data.substring(0, data.length - 3);
        caller.innerHTML = date;
        caller.style.filter = 'none';
    }
}

function ParseMyTimeStamp(e) {
    var caller = (e && e.target) || (window.event && window.event.srcElement);
    // caller = document.getElementById(caller.id);
    // console.log("filter: " + (caller.style.filter));
    if ((caller.style.filter) != ('none')) {
        let timestamp = caller.innerHTML;
        if (caller.id != "") {
            console.log("Parsing timestamp of element with ID: " + caller.id)
        } else {
            console.log("Parsing timestamp of an " + caller + " without ID.")
        }
        const jstimestamp = timestamp * 1000;
        const dateObject = new Date(jstimestamp);
        const data = dateObject.toLocaleString();
        const date = data.substring(0, data.length - 3);
        caller.innerHTML = date;
        caller.style.filter = 'none';
    }
}
console.log("Sending client date to server over GET...");
let currentDate = new Date();
let cDay = currentDate.getDate();
let cMonth = currentDate.getMonth() + 1;
let cYear = currentDate.getFullYear();
let currentdate = (cYear + "-" + cMonth + "-" + cDay);
const xhttp = new XMLHttpRequest();
xhttp.open("GET", "/set.php?clientdate=" + currentdate);
xhttp.send();
if ((typeof focusmode != "undefined") && (focusmode != null) && (focusmode)) {
    window.addEventListener('mouseover', function (e) {
        if (document.getElementById('AddEntryFormDiv').contains(e.target)) {
            NewEntryFocus()
        }
    });
    window.addEventListener('click', function (e) {
        if (document.getElementById('AddEntryFormDiv').contains(e.target)) {
        } else { NewEntryUnFocus() }
    });
}
switch (urisrvside) {
    case "/home/":
        textboxPlaceholder = document.getElementById("textbox-placeholder");
        const textboxtypetogglebtn = {
            "textbox": '<button id="textboxtypetogglebtn" class="emojis" onclick="TextboxTypeToggle()" style="height: 36px; padding: 0px; width: 72px; margin: 5px; display: none">𓐟</button>',
            "input": '<button class="emojis" onclick="TextboxTypeToggle()" id="textboxtypetogglebtn" align="left" style="height: 38.8px; width: 38.8px; margin: 4px; padding: 0px;-webkit-transform: scaleX(-1); transform: scaleX(-1)">&#x2195;&#xFE0F;</button>&nbsp;&nbsp;'
        }
        getLang(22, '', '', function (tt) {
            if (usersetting.longEntries) {
                textboxPlaceholder.innerHTML = '<textarea autofocus autocomplete="off"  title="' + tt + '" name="new_entry" class="textbox" placeholder="' + ExampleEntry + '" required></textarea>';
                textbox = document.getElementsByClassName('textbox')[0];
                $(textboxtypetogglebtn.textbox).insertBefore("#feelemojibutton");
            } else {
                textboxPlaceholder.innerHTML = '<input type="text" autocomplete="off"  title="' + tt + '" name="new_entry" class="textbox" placeholder="' + ExampleEntry + '" required>';
                textbox = document.getElementsByClassName('textbox')[0];
                $(textboxtypetogglebtn.input).insertBefore("#textbox-placeholder");
            }
        });
        function TextboxTypeToggle() {
            document.getElementById('textboxtypetogglebtn').remove();
            textboxvalue = textbox.value;
            getLang(22, '', '', function (tt) {
                if ((textbox.tagName).toLowerCase() == "textarea") {
                    textboxPlaceholder.innerHTML = '<input type="text" value="' + textboxvalue + '" autocomplete="off"  title="' + tt + '" name="new_entry" class="textbox" placeholder="' + ExampleEntry + '" required>';
                    $(textboxtypetogglebtn.input).insertBefore("#textbox-placeholder");
                    textbox = document.getElementsByClassName('textbox')[0];
                    if (focusmodestatus) {
                        document.getElementById("baebadoopiiepoopiee").style.display = "";
                    }
                } else {
                    textboxPlaceholder.innerHTML = '<textarea autofocus autocomplete="off"  title="' + tt + '" name="new_entry" class="textbox" placeholder="' + ExampleEntry + '" required>' + textboxvalue + '</textarea>';
                    $(textboxtypetogglebtn.textbox).insertBefore("#feelemojibutton");
                    textbox = document.getElementsByClassName('textbox')[0];
                    if (focusmodestatus) {
                        onFocusModeResizeTextbox();
                    }
                }
            });
        }
        function timeDifference(previous) {
            current = Date.now();
            // https://stackoverflow.com/a/6109105
            // But modified alot lol
            var msPerMinute = 60 * 1000;
            var msPerHour = msPerMinute * 60;
            var msPerDay = msPerHour * 24;
            var msPerWeek = msPerDay * 7;
            var msPerMonth = msPerDay * 30;
            var msPerYear = msPerDay * 365;

            var elapsed = current - previous;

            if (elapsed < msPerMinute) {
                return Math.round(elapsed / 1000) + ' <text  class="translatable" data-translation_1="82" data-translation_2="1"></text>';
            }

            else if (elapsed < msPerHour) {
                return Math.round(elapsed / msPerMinute) + ' <text  class="translatable" data-translation_1="82" data-translation_2="2"></text>';
            }

            else if (elapsed < msPerDay) {
                return Math.round(elapsed / msPerHour) + ' <text  class="translatable" data-translation_1="82" data-translation_2="3"></text>';
            }
            else if (Math.round(elapsed / msPerDay) > 2) {
                // Too long ago, we don't need all that.
                return "";
            }
            else if ((Math.round(elapsed / msPerDay)) == 1) {
                return '<text  class="translatable" data-translation_1="82" data-translation_2="5"></text>';
            }
            else if (elapsed < msPerMonth) {
                return Math.round(elapsed / msPerDay) + ' <text  class="translatable" data-translation_1="82" data-translation_2="4"></text>';
            }
        }
        (document.getElementById('feelemojiinput')).value = '⏺️';
        (document.getElementById('feelemojibutton')).innerText = '⏺️';
        setTimeout(function () {
            bonsloe = document.getElementById('bonsloe')
            if ((typeof bonsloe != 'undefined') && (bonsloe != null)) {
                bonsloe.removeAttribute('disabled');
                bonsloe.style.opacity = '100%';
                bonsloe.addEventListener('click', function () {
                    tableFromJson();
                })
            }
        }, 15000);
        const d = new Date();
        let uur = d.getHours();
        quarter = parseInt(Math.round(uur / 24 * 4));
        if (quarter == 0) {
            quarter = 1;
        }
        getLang(8, quarter, '', function (greet) {
            document.getElementById("greeting").innerHTML = greet;
        });


        function tableFromJson() {
            var ponsloe = document.getElementById('ponsloe');
            // Rico is here because I used to include the counting in the string, but for some reason  the order wasn' t always right. Rico is here so I can say "Not yet boom, rico."
            var rico = new Number;
            getLang(25, 2, '', function (alet) {
                rico = 1;
                teal = alet + ' (' + (rico) + '/5)'; console.log(teal);
                ponsloe.innerText = teal;
            });
            $.getJSON('/?api=entries-json', function (entryListvar) {
                const entryList = entryListvar
                getLang(25, 3, '', function (alet) {
                    rico++;
                    teal = alet + ' (' + (rico) + '/5)';
                    // Unpacking entry data
                    console.log(teal);
                    ponsloe.innerText = teal;
                });
                let col = [];
                for (let i = 0; i < entryList.length; i++) {
                    for (let key in entryList[i]) {
                        if (col.indexOf(key) === -1) {
                            col.push(key);
                        }
                    }
                }
                getLang(25, 4, '', function (alet) {
                    rico++;
                    teal = alet + ' (' + (rico) + '/5)';
                    // Creating a table to put the data into
                    console.log(teal);
                    ponsloe.innerText = teal;
                });
                const table = document.createElement("table");
                let tr = table.insertRow(-1);

                for (let i = 0; i < col.length; i++) {
                    let th = document.createElement("th");
                    th.innerHTML = col[i];
                    th.id = "ReadBackTH_" + col[i];
                    switch (col[i]) {
                        case 'Date':
                            getLang(18, '', '', function (text) {
                                th.innerText = text;
                            });
                            break;
                        case 'Text':
                            getLang(19, '', '', function (text) {
                                th.innerText = text;
                            });
                            break;
                        case 'Feel':
                            getLang(20, '', '', function (text) {
                                th.innerText = text;
                            });
                            break;
                    }
                    tr.appendChild(th);
                }
                getLang(25, 5, '', function (alet) {
                    rico++;
                    teal = alet + ' (' + (rico) + '/5)';
                    // Organising entry data into table
                    console.log(teal);
                    ponsloe.innerText = teal;
                });
                for (let i = 0; i < entryList.length; i++) {

                    tr = table.insertRow(-1);

                    for (let j = 0; j < col.length; j++) {
                        let tabCell = tr.insertCell(-1);
                        tabCell.innerHTML = entryList[i][col[j]];
                        tabCell.className = "readbacktable_" + col[j];

                        switch (col[j]) {
                            case 'Date':
                                if (tabCell.hasChildNodes && tabCell.children[0] != null && ((tabCell.children[0]).tagName).toLowerCase() == 'span') {
                                    var tstamp = parseInt((tabCell.children[0]).innerText);
                                } else {
                                    var tstamp = parseInt(tabCell.innerText);
                                }
                                var date = new Date(tstamp * 1000);
                                var fulldatedispl = (date.getDate() +
                                    "/" + (date.getMonth() + 1) +
                                    "/" + date.getFullYear() +
                                    "<br> <span class=\"timefonted\">" + date.getHours() +
                                    ":" + (String(date.getMinutes())).padStart(2, '0') +
                                    "</span>");
                                if (timeDifference(tstamp * 1000) == "") {
                                    tabCell.classList.add('entrydate');
                                    var date = new Date(tstamp * 1000);
                                    tabCell.innerHTML = fulldatedispl;
                                } else {
                                    if (usersetting.relativetimes) {
                                        tabCell.style.fontSize = "100%";
                                        tabCell.innerHTML = timeDifference(tstamp * 1000);
                                    }
                                }
                                break;
                            case 'Text':
                                // hi
                                break;
                            case 'Feel':
                                tabCell.classList.add('emojis');
                                if ((!tabCell.hasChildNodes) && ((((tabCell.children[0]).tagName).toLowerCase()) == 'span')) {
                                    tabCell.innerHTML = ((tabCell.children[0]).innerText);
                                }
                                break;
                        }
                    }
                }
                getLang(25, 6, '', function (alet) {
                    rico++;
                    teal = alet + ' (' + (rico) + '/5)';
                    // Ready to show entries!
                    console.log(teal);
                    ponsloe.innerText = teal;
                });
                table.id = "readbacktable";
                table.setAttribute('align', 'center');
                const divShowData = document.getElementById('showData');
                divShowData.innerHTML = "";
                divShowData.appendChild(table);
                ReLoadLang();
                (document.getElementById("ShowEntriesBtn")).style.display = "none";
                (document.getElementById("ShowEntriesBtn")).innerHTML = "";
                (document.getElementById("ShowEntriesBtn")).remove();
            });
        }

        // function ParseEntryTimestamps() {
        //     var elements = document.getElementsByClassName('entrytimestamps');
        //     for (var i = 0, length = elements.length; i < length; i++) {
        //         let timestamp = elements[i].innerHTML;
        //         console.log("Parsing timestamp.");
        //         const jstimestamp = timestamp * 1000;
        //         const dateObject = new Date(jstimestamp);
        //         const data = dateObject.toLocaleString();
        //         const date = data.substring(0, data.length - 3);
        //         elements[i].innerHTML = date;
        //         elements[i].className = 'entrydate';
        //         setTimeout(ParseEntryTimestamps, 25);
        //         break;
        //     }
        // }
        var focusmodestatus;
        focusmodestatus = false;
        function onFocusModeResizeTextbox() {
            if ((textbox.tagName).toLowerCase() === "textarea") {
                (document.getElementById('baebadoopiiepoopiee')).style.display = "block";
                textbox.style.transition = 'height 4.7s cubic-bezier(1, 0, 0, 1) 0s, width 3.8s cubic-bezier(1, 0, 0, 1) 0s';
                textbox.style.height = "20em";
                textbox.style.width = "95%";
                $("<br id='hijskpok'>").insertAfter(textbox);
                setTimeout(function () { textbox.style.transition = ''; }, 47000);
            }
        }
        function HideFocusModeAlert () {
            setCookie("HideFocusModeAlert","true",30);
            document.getElementById('focusmodealert').style.display = 'none';
        }
        if (getCookie("HideFocusModeAlert") == "true") {
            document.getElementById('focusmodealert').style.display = 'none';
        }
        function NewEntryFocus() {
            if (!mediamobilescreen()) {
                // document.getElementById("AddEntryFormDiv").style.maxWidth = (getComputedStyle(document.getElementById("AddEntryFormDiv")).width)
                // document.getElementById("AddEntryFormDiv").style.position = "fixed";
                // document.getElementById("AddEntryFormDiv").style.top = "0px";
                // document.body.style.overflow = "hidden";
                document.getElementById('focusmodealert').style.overflow = 'hidden';
                if (focusmodestatus === false) {
                    var elements = document.getElementsByClassName('outsideofinputfocus');
                    for (var i = 0, length = elements.length; i < length; i++) {
                        elements[i].style.filter = "opacity(30%) grayscale(1) blur(25px)";
                        continue;
                    }
                    textbox = document.getElementsByClassName('textbox')[0];
                    onFocusModeResizeTextbox();
                    document.getElementById('focusmodealert').style.transition = '';
                    document.getElementById('focusmode-salutations').style.display = 'none';
                    focusmodestatus = true;
                    // document.getElementById('focusmodealert').style.display = 'block';
                    document.getElementById('focusmodealert').style.height = '7em';
                    document.getElementById('focusmodealert').style.marginBottom = '20px';
                    document.getElementById('focusmodealert').style.opacity = '100';
                    // if (drawer.classList.contains('hidden')) {
                    //     document.getElementById('drawer').classList.remove('hidden');
                    // }
                    focusmodealertbg = (getComputedStyle(document.getElementById('focusmodealert')).getPropertyValue("background-color"));
                    focusmodealertbgRGB = (((focusmodealertbg).replace('rgb(', '')).replace(')', '')).split(",");
                    focusmodealertbgHEX = (rgbToHex(focusmodealertbgRGB[0], focusmodealertbgRGB[1], focusmodealertbgRGB[2]));
                    document.getElementById('focusmodealert').style.color = contrastingColor(focusmodealertbgHEX);
                }
            }
        }
        function NewEntryUnFocus() {
            // document.getElementById("AddEntryFormDiv").style.maxWidth = "";
            // document.getElementById("AddEntryFormDiv").style.position = "";
            // document.getElementById("AddEntryFormDiv").style.top = "";
            // document.body.style.overflow = "";
            var elements = document.getElementsByClassName('outsideofinputfocus');
            for (var i = 0, length = elements.length; i < length; i++) {
                elements[i].style.filter = "none";
                continue;
            }
            textbox = document.getElementsByClassName('textbox')[0];
            {
                if ((textbox.tagName).toLowerCase() === "textarea") {
                    (document.getElementById('baebadoopiiepoopiee')).style.display = '';
                    textbox.style.transition = '';
                    textbox.style.height = '';
                    textbox.style.width = '';
                    if (typeof (document.getElementById('hijskpok')) != 'undefined' && (document.getElementById('hijskpok')) != null) {
                        (document.getElementById('hijskpok')).remove();
                    }
                }
            }
            document.getElementById("baebadoopiiepoopiee").style.display = "";
            focusmodestatus = false;
            // document.getElementById('focusmodealert').style.display = 'none';
            document.getElementById('focusmodealert').style.transition = 'height 0.2s linear 0s';
            document.getElementById('focusmodealert').style.height = '0px';
            document.getElementById('focusmodealert').style.marginBottom = '0px';
            document.getElementById('focusmodealert').style.opacity = '0';

            // if (!drawer.classList.contains('hidden')) {
            //     document.getElementById('drawer').classList.add('hidden');
            // }
        }
        textbox = document.getElementsByClassName('textbox')[0];
        

        break;
    case '/settings/':
        // Not yet but it'll trigger me.
        break;
}
LoadLang();
