require('./bootstrap');


// Import modules...
import { createApp, ref, h } from 'vue';
import { App, App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Inertia } from '@inertiajs/inertia'
import Emitter from 'tiny-emitter';
import {startWorker, stopWorker } from './modules/worker.js'
import AppLayout from "./Layouts/AppLayout";
import debounce from './directives/debounce';


Inertia.on('navigate', (event) => {
    switch (event.detail.page.url) {
        case '/logout':

            stopWorker();

            break;
        default:
            //console.debug('Navigated to', event)

    }
})


const el = document.getElementById('app');

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .directive('debounce', (el, binding) => debounce(el, binding))
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .component('app-layout', AppLayout)
    .mount(el);

app.$.appContext.config.globalProperties.$eventBus = new Emitter();

InertiaProgress.init({ color: '#4B5563' });

startWorker(app.$.appContext.config.globalProperties.$eventBus);
