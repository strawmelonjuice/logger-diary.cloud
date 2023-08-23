const {
  contextBridge: contextBridge,
  ipcRenderer: ipcRenderer,
} = require("electron");
const ipc = {
  render: {
    send: ["window:unmaxify", "window:maxify", "window:minify", "window:close"],
    receive: [],
    sendReceive: [],
  },
};
contextBridge.exposeInMainWorld("ipcRender", {
  send: (channel, args) => {
    let validChannels = ipc.render.send;
    if (validChannels.includes(channel)) {
      ipcRenderer.send(channel, args);
    }
  },
  receive: (channel, listener) => {
    let validChannels = ipc.render.receive;
    if (validChannels.includes(channel)) {
      ipcRenderer.on(channel, (event, ...args) => listener(...args));
    }
  },
  invoke: (channel, args) => {
    let validChannels = ipc.render.sendReceive;
    if (validChannels.includes(channel)) {
      return ipcRenderer.invoke(channel, args);
    }
  },
});
