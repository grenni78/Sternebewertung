import { getCurrentInstance } from "vue";

export default function getEventbus() {
    const internalInstance = getCurrentInstance();

    const emitter =
        internalInstance.appContext.config.globalProperties.$eventBus;

    return emitter;
}
