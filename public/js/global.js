window.addEventListener("load", () => {
    const getLoading = document.querySelector("#eselvehiculo_loading");
    setTimeout(() => {
        getLoading.setAttribute("style", "opacity: 0");
        setTimeout(() => {
            getLoading.remove();
        }, 5000);
    }, 1000);
});

if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("./sw.js")
        .then((res) => console.log("service worker registered"))
        .catch((err) => console.log("service worker not registered", err));
}
