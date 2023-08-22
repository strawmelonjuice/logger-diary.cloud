var HttpClient = function () {
    this.get = function (aUrl, aCallback) {
        var anHttpRequest = new XMLHttpRequest();
        anHttpRequest.onreadystatechange = function () {
            if (anHttpRequest.readyState == 4 && anHttpRequest.status == 200)
                aCallback(anHttpRequest.responseText);
        }

        anHttpRequest.open("GET", aUrl, true);
        anHttpRequest.send(null);
    }
}
function mediamobilescreen() {
    return ((window.matchMedia("(orientation: portrait),(max-width: 800px)")).matches);
};
var respondwith;
function getLang(a, b, c, CallbackTo) {
    // /lang?1=50&2=10&3=2
    var client = new HttpClient();
    if (typeof CallbackTo == 'undefined') {
        CallbackTo = function (back) {
            console.log(back);
            document.write(back);
        };
    }
    if (c != '') {
        client.get('/lang/?1=' + a + '&2=' + b + '&3=' + c, function (response) {
            respondwith = response;
            // console.log("Translation sent: '" + respondwith + "'.");
            CallbackTo(response);
        });
    } else if (b != '') {
        client.get('/lang/?1=' + a + '&2=' + b, function (response) {
            respondwith = response;
            // console.log("Translation sent: '" + respondwith + "'.");
            CallbackTo(response);
        });
    } else {
        client.get('/lang/?id=' + a, function (response) {
            respondwith = response;
            // console.log("Translation sent: '" + respondwith + "'.");
            CallbackTo(response);
        });
    }
}

function ElLoadLang(elem) {
    if (elem.dataset.translation_id != null) {
        getLang(elem.dataset.translation_id, '', '', function (translation) {
            elem.innerHTML = translation;
        });
        return;
    }
    if (elem.dataset.translation_3 != null) {
        getLang(elem.dataset.translation_1, elem.dataset.translation_2, elem.dataset.translation_3, function (translation) {
            elem.innerHTML = translation;
        });
        return;
    }
    if (elem.dataset.translation_2 != null) {
        getLang(elem.dataset.translation_1, elem.dataset.translation_2, '', function (translation) {
            elem.innerHTML = translation;
        });
        return;
    }
    if (elem.dataset.translation_1 != null) {
        console.error("Found value translation_1, expected value translation_2 but got nothing. Use value translation_id for unnested translations.");
        return;
    }
}
function LoadLang() {
    var howmany = 0;
    console.log('Language loading started.');
    translatables = document.getElementsByClassName("translatable");
    for (var i = translatables.length - 1; i >= 0; i--) {
        howmany +=1;
        if ((translatables[i].tagName).toLowerCase() === "text") {
            ElLoadLang(translatables[i]);
            console.log('Assigned translation value "' + translatables[i].innerText + '" to ', translatables[i]);
            translatables[i].classList.add("translated");
            translatables[i].classList.remove("translatable");
        } else {
            console.error("Only text tags are supposed to have translatable classes, found " + translatables[i]);
        }
    }
    console.log('Language loading stopped. Processed ' + howmany + ' element(s).');
}
function ReLoadLang() {
    translatables = document.getElementsByClassName("translated");
    for (var i = translatables.length - 1; i >= 0; i--) {
        if ((translatables[i].tagName).toLowerCase() === "text") {
            translatables[i].classList.add("translatable");
            translatables[i].classList.remove("translated");
        }
    }
    LoadLang();
}

if ((window.location.pathname) == "/home/") {
    console.log("Sending date in case login didn't send it yet");
    let currentDatew = new Date();
    let cDayw = currentDatew.getDate();
    let cMonthw = currentDatew.getMonth() + 1;
    let cYearw = currentDatew.getFullYear();
    let currentdatew = (cYearw + "-" + cMonthw + "-" + cDayw);
    const xhttpw = new XMLHttpRequest();
    xhttpw.open("GET", "/set.php?clientdate=" + currentdatew);
    xhttpw.send();
}