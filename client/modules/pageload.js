// import pageLoader from "./modules/pageload.js";
let pagecontent = document.getElementById('content');
export default () => {
    console.log("Page actualisation check");
    if (window.location.hash != pagecontent.dataset.currentView) {
        console.log("Actualising...");
        switch (window.location.hash) {
            default:
            case '#/home/':
                pagecontent.innerText = "No page content possible yet.";
                window.location.hash = '/home/';
                pagecontent.dataset.currentView = '#/home/';
                break;
        }
        // ReLoadLang()
    }
}