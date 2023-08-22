function handleWindowControls() {
  document.getElementById("min-button").addEventListener("click", (event) => {
    window.ipcRender.send('window:minify');
  });

  document.getElementById("max-button").addEventListener("click", (event) => {
    window.ipcRender.send('window:maxify');
    document.body.classList.add("maximized");
  });

  document
    .getElementById("restore-button")
    .addEventListener("click", (event) => {
      window.ipcRender.send('window:unmaxify');
      document.body.classList.remove("maximized");      
    });

  document.getElementById("close-button").addEventListener("click", (event) => {
    window.ipcRender.send('window:close');
  });
}
handleWindowControls();
var userLang = navigator.language || navigator.userLanguage;