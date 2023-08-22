const HiddenPageElement = document.getElementsByClassName("hidden-tourpages");
function GetHiddenPageElementById(id) {
    for (var i = 0; i < HiddenPageElement.length; i++) {
        HiddenPageElement[i].style.display = 'none';
        if ((HiddenPageElement[i].id) === ("hidden-tourpage-" + id)) {
            return HiddenPageElement[i]
        };
    }
}
visibletourpage = document.getElementById('ViewnPage');
function ActualizeTourPage() {
    console.log("Actualisation check");
    if (window.location.hash != visibletourpage.dataset.currentView){
        console.log("Actualising...");
        switch (window.location.hash) {
            case '#2':
                visibletourpage.innerHTML = GetHiddenPageElementById("2").innerHTML;
                visibletourpage.dataset.currentView = '#2';
                getLang('tour','0','5',function (translation) {
                    document.getElementById("dieh2").innerText = translation;
                })
                break;
            case '#3':
                visibletourpage.innerHTML = GetHiddenPageElementById("3").innerHTML;
                visibletourpage.dataset.currentView = '#3';
                break;
            case '#4':
                visibletourpage.innerHTML = GetHiddenPageElementById("4").innerHTML;
                visibletourpage.dataset.currentView = '#4';
                getLang('tour', '0', '5', function (translation) {
                    document.getElementById("dieh2").innerText = translation;
                })
                break;
            case '#5':
                visibletourpage.innerHTML = GetHiddenPageElementById("5").innerHTML;
                visibletourpage.dataset.currentView = '#5';
                break;
            case '#6':
                visibletourpage.innerHTML = GetHiddenPageElementById("6").innerHTML;
                visibletourpage.dataset.currentView = '#6';
                break;
            case '#7':
            case '#final':
                visibletourpage.innerHTML = GetHiddenPageElementById("7").innerHTML;
                visibletourpage.dataset.currentView = '#final';
                window.location.hash = 'final';
                getLang('tour', '0', '5', function (translation) {
                    document.getElementById("dieh2").innerText = translation;
                })
                break;
            default:
            case '#1':
                visibletourpage.innerHTML = GetHiddenPageElementById("1").innerHTML;
                window.location.hash = '1';
                visibletourpage.dataset.currentView = '#1';
                break;
        }
        ReLoadLang()
    }
}
setInterval(function () {ActualizeTourPage()}, 500);
for (var i = 0; i < HiddenPageElement.length; i++) {
    HiddenPageElement[i].style.display = 'none';
}