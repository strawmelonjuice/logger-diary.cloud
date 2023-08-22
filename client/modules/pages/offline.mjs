const helga = function () {
    window.ononline = () => {
        window.location.hash = '/home/';
    }
    return "You are offline. <button>Retry</button>";
}
export default helga