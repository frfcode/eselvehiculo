// NAME OF CACHE
const CACHE_NAME = "eselvehiculo.com";
// URLS STATICS FOR CACHE
const urlsToCache = [
    "/",
    "/assets/css/style.css",
    "/assets/pwa/icons/icon-512x512.png",
    "/assets/pwa/icons/icon-72x72.png",
];

//INSTALL CAHCHE FILES STATICS
self.addEventListener("install", (e) => {
    e.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache).then(() => self.skipWaiting());
            })
            .catch((err) => console.log("Falló registro de cache", err))
    );
});

//BEFORE INSTALL SERVICE WORKED (SW) ACTIVE CACHE
self.addEventListener("activate", (e) => {
    const cacheWhitelist = [CACHE_NAME];
    e.waitUntil(
        caches
            .keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        //DELETE FILES NOT NECESSARY IN CACHE
                        if (cacheWhitelist.indexOf(cacheName) === -1) {
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            //TELLS THE SW TO ACTIVATE THE CURRENT CACHE
            .then(() => self.clients.claim())
    );
});

//WHEN THE BROWSER RETRIEVES A URL
self.addEventListener("fetch", (e) => {
    //SEARCH REAL URL OR OBJECT CACHE
    e.respondWith(
        caches.match(e.request).then((res) => {
            if (res) {
                //GET CACHE
                return res;
            }
            //RETURNS THE URL REQUEST
            return fetch(e.request);
        })
    );
});
