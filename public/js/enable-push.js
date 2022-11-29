function askPermission() {
    return new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (
            result
        ) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    }).then(function (permissionResult) {
        if (permissionResult !== "granted") {
            throw new Error("We weren't granted permission.");
        }
    });
}

function urlBase64ToUint8Array(base64String) {
    var padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, "+")
        .replace(/_/g, "/");

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function storePushSubscription(pushSubscription) {
    const token = document
        .querySelector("meta[name=csrf-token]")
        .getAttribute("content");

    window.axios
        .post("/push", {
            pushSubscription,
        })
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            console.error(err);
        });
}

function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    "BJajn3KJHM5jNeRAaYzIq-b7fPQqlbW_Mg-l8GnMPE2Er7LuPncvj_uSazWMkLLGzucyTSUwroQsewUT-kxAPOo"
                ),
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            // successfully subscribed
            storePushSubscription(pushSubscription);
        });
}

function initSW() {
    if (!"serviceWorker" in navigator) {
        //service worker isn't supported
        return;
    }

    //don't use it here if you use service worker
    //for other stuff.
    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    //register the service worker
    navigator.serviceWorker
        .register("../sw.js")
        .then(() => {
            console.debug("serviceWorker installed!");
            initPush();
        })
        .catch((err) => {
            console.error(err);
        });
}

function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (
            result
        ) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    }).then((permissionResult) => {
        if (permissionResult !== "granted") {
            throw new Error(
                "Erlaubnis für Push-Benachrichtigungen verweigert."
            );
        }
        subscribeUser();
    });
}

askPermission().then(() => initSW());
