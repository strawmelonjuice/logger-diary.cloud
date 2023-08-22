// This script? ÍS the FRAMEWORK MOD
// Now available for all themes, though.

if (typeof LDtheme != 'undefined' && LDtheme != null) {
switch (LDtheme) {
    case "skyframe":
        {
            if (typeof previewtheme !== 'undefined') {
                if (previewtheme === true) {
                    document.body.querySelectorAll('*').forEach(function (node) {
                        node.style.display = "none";
                    });
                    getLang(50, 10, 2, function (innerText) {
                        document.body.innerHTML = document.body.innerHTML + "<p>" + innerText + "</p>";
                    });
                    setTimeout(function () {
                        getLang(50, 10, 2, function (innerText) {
                            document.body.innerHTML = "<p>" + innerText + "</p>";
                        });
                    }, 5000)
                    function tableFromJson () {return};
                    break;
                }
            }
            console.log("Framework theme injection started...");
            if (document.getElementById("h2-13")) {
                document.getElementById("h2-13").classList.add("AddEntryForm");
                if (document.getElementById("focusmodealert")) {
                    document.getElementById("focusmodealert").innerHTML = '<h2>' + document.getElementById("h2-13").innerText + '</h2>';
                    document.getElementById("focusmode-salutations").id = "focusmode-salutations-disabled";
                    document.getElementsByClassName("closebtn")[0].innerHTML = '<span id="focusmode-salutations"></span>';
                }
            }
            if (document.getElementById("GreetingH")) {
                document.getElementById("GreetingH").style.display = 'none';
                document.getElementById("gambiwashere").innerHTML = document.getElementById("GreetingH").innerHTML;
            }

            document.getElementById("theLoggerNav").classList.remove("sidenav");
            document.getElementById("ViewNavButton").style.display = 'none';

            document.getElementsByClassName("closebtn")[0].style.display = 'none';
            document.getElementById("ViewNavButton").innerHTML = '';

            var frameworktogglestatus = "unknown";
            function ToggleAddentryform() {
                switch (frameworktogglestatus) {
                    case 'hidden':
                        ShowAddentryform();
                        break;

                    default:
                        HideAddentryform();
                        break;
                }
            }
            function HideAddentryform() {
                frameworktogglestatus = "hidden";
                const collection = document.getElementsByClassName("AddEntryForm");
                NewEntryUnFocus();
                for (var i = 0; i < collection.length; i++) {
                    collection[i].classList.add("HiddenAddEntryForm");
                }
            }
            var tempNode = document.getElementById('ImOnlyHereForYou');
            if (tempNode != null) {
                var newDiv = document.createElement('div');
                newDiv.id = "framework-add-btn";
                newDiv.setAttribute("onclick", "ToggleAddentryform()");
                var newImg = document.createElement('img');
                newImg.src = "/img/add.png";
                newImg.alt = "Write...";
                newImg.setAttribute("style", "height: 36px; width: 36px; margin: 0; padding: 0;");
                newDiv.appendChild(newImg);
                tempNode.parentNode.replaceChild(newDiv, tempNode);
            }
            HideAddentryform()
            function ShowAddentryform() {
                frameworktogglestatus = "shown";
                const collection = document.getElementsByClassName("AddEntryForm");
                NewEntryFocus();
                for (var i = 0; i < collection.length; i++) {
                    collection[i].classList.remove("HiddenAddEntryForm");
                }
            }

            console.log("Framework theme injection ended.");
        }
        break;
}}
document.body.setScaledFont = function (f) {
    switch (true) {
        case (mediamobilescreen()):
            var s = this.offsetWidth,
                fs = s * (f / 60);
            console.log("Scaling in mobile mode.");
            break;
        case ((this.offsetWidth) < 1200):
            var s = this.offsetWidth,
                fs = s * (f / 90);
            console.log("Scaling in tablet mode. Width: " + this.offsetWidth);
            break;
        case ((this.offsetWidth) < 1600):
            var s = this.offsetWidth,
                fs = s * (f / 100);
            console.log("Scaling in laptop mode. Width: " + this.offsetWidth);
            break;
        case ((this.offsetWidth) > 1600):
            var s = this.offsetWidth,
                fs = s * (f / 150);
            console.log("Scaling in desktop mode. Width: " + this.offsetWidth);
            break;
    }
    this.style.fontSize = fs + '%';
    return this
};

scft = ScaleFontsTo + (usersetting.zoomdiffer / 10);
// e.g. 180% = 18.1
document.body.setScaledFont(scft);
window.onresize = function () {
    document.body.setScaledFont(scft);
}