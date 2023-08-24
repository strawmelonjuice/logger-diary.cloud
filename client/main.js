const {
  app: app,
  BrowserWindow: BrowserWindow,
  ipcMain: ipcMain,
} = require("electron");
const path = require("path");
const env = require("./env.json");
let windj;
function createWindow() {
  windj = new BrowserWindow({
    width: 400,
    height: 500,
    frame: false,
    backgroundColor: "#FFF",
    webPreferences: {
      devTools: env.devmode,
      nodeIntegration: true,
      contextIsolation: true,
      preload: path.join(__dirname, "/preload.js"),
    },
  });
  windj.loadFile("assets/index.html");
  // if (env.devmode === true) {
  //   windj.webContents.openDevTools();
  // }
  windj.on("closed", () => {
    windj = null;
  });
}
app.on("ready", createWindow);
app.on("window-all-closed", function () {
  if (process.platform !== "darwin") {
    app.quit();
  }
});
app.on("activate", function () {
  if (windj === null) {
    ipcMain.handle("ping", () => "pong");
    ipcMain.handle("windowaction-close", () => windj.close());
    ipcMain.on("window:minify", () => {
      windj.minimize();
    });
    createWindow();
  }
});
ipcMain.on("window:maxify", () => {
  windj.maximize();
});
ipcMain.on("window:unmaxify", () => {
  windj.restore();
});
ipcMain.on("window:close", () => {
  windj.close();
});
ipcMain.on("window:minify", () => {
  windj.minimize();
});
