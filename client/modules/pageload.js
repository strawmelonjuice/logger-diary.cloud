// import pageLoader from "./modules/pageload.js";
let pagecontent = document.getElementById('content');
export default () => {
    function LoadPageModule(pagemodule,type = "snippet") {
        import("./pages/" + pagemodule)
            .then((page) => {
                if (type === "string") {
                pagecontent.innerHTML = page.default;} 
                if (type === "snippet") {
                  pagecontent.innerHTML = page.default();
                } 
            }
            );
    }
    console.log("Page actualisation check");
    if (window.location.hash != pagecontent.dataset.currentView) {
        console.log("Actualising...");
        switch (window.location.hash) {
            case '#/offline/':
                LoadPageModule("offline.mjs")
                pagecontent.dataset.currentView = '#/offline/';
                break;
            default:
            case '#/home/':
                LoadPageModule("home.js","string");
                window.location.hash = '/home/';
                pagecontent.dataset.currentView = '#/home/';
                break;
        }
        // ReLoadLang()
    }
}