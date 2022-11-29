import { usePage } from "@inertiajs/inertia-vue3";

let workerInterval = null;
let has_focus = false;

window.addEventListener("focus", () => {
    has_focus = true;
});
window.addEventListener("blur", () => {
    has_focus = false;
});

function startWorker(emitter) {
    if (workerInterval) {
        console.error("worker already running.");
        return;
    }

    navigator.serviceWorker.addEventListener("message", (event) => {
        emitter.emit(event.data.type, event.data);
    });

    workerInterval = setInterval(() => {
        // return if not logged in
        if (!usePage().props.value?.userDetails) {
            return;
        }

        // run only if we do not have permission
        if (Notification?.permission == "granted") {
            return;
        }

        window.axios.get("/api/v1_1/updates").then((response) => {
            // only run if there is something to do
            if (response.status == 200) {
                // expect an array
                if (Array.isArray(response.data)) {
                    response.data.forEach((element) => {
                        if (element.data.type && element.data.data) {
                            try {
                                // emit an event
                                emitter.emit(
                                    element.data.type,
                                    JSON.parse(element.data.data)
                                );
                            } catch (e) {
                                emitter.emit("error", e);
                            }
                        }
                    });
                }
            }
        });
    }, 5000);
}

function stopWorker(emitter) {
    if (workerInterval) {
        //navigator.serviceWorker.removeEventListener("message", navigator_event);
        clearInterval(workerInterval);
        workerInterval = null;
    }
}

export { startWorker, stopWorker };
