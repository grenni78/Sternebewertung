self.addEventListener("push", function (event) {
    if (!(self.Notification && self.Notification.permission === "granted")) {
        //notifications aren't supported or permission not granted!
        return;
    }

    const payload = event.data ? event.data.json() : "no payload";

    const promiseChain = clients
        .matchAll({
            type: "window",
            includeUncontrolled: true,
        })
        .then((windowClients) => {
            let clientIsFocused = false;

            for (let i = 0; i < windowClients.length; i++) {
                const windowClient = windowClients[i];
                if (windowClient.focused) {
                    clientIsFocused = true;
                    break;
                }
            }

            if (!clientIsFocused) {
                // show Notification if window has no focus
                self.registration.showNotification(payload.title, payload);
            }
            // notify app
            if (payload.data) {
                windowClients.forEach((windowClient) => {
                    windowClient.postMessage(payload.data);
                });
            }
        });

    event.waitUntil(promiseChain);
});
