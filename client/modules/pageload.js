// import pageLoader from "./modules/pageload.js";
let pagecontent = document.getElementById("content");
let setPageStyling = function (PageStyling) {
    if (document.getElementById("contentstyling") != null) {
        (document.getElementById("contentstyling")).remove;
    }
    var pageStyleSheet = document.createElement("style");
    pageStyleSheet.innerHTML = PageStyling;
    document.head.appendChild(pageStyleSheet);
}
// let pagestyling = ;
export default () => {
    function LoadPageModule(pagemodule, type = "snippet") {
        import("./pages/" + pagemodule).then((page) => {
            if (type === "string") {
                pagecontent.innerHTML = page.default;
            }
            if (type === "snippet") {
                pagecontent.innerHTML = page.default();
            }
        });
    }
    console.log("Page actualisation check");
    if (window.location.hash != pagecontent.dataset.currentView) {
        console.log("Actualising...");
        switch (window.location.hash) {
            case "#/login/":
                setPageStyling(`
                body {
                    background-color: pink;
                }
                `)
                pagecontent.innerHTML = `
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
                `;
                pagecontent.dataset.currentView = "#/login/";
                break;
            case "#/gologin/":
                break;
            case "#/offline/":
                console.error(window.offlinereason);
                LoadPageModule("offline.mjs");
                pagecontent.dataset.currentView = "#/offline/";
                break;
            default:
            case "#/home/":
                LoadPageModule("home.js", "string");
                window.location.hash = "/home/";
                pagecontent.dataset.currentView = "#/home/";
                break;
        }
        // ReLoadLang()
    }
};
