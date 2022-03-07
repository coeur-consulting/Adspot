require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import mitt from "mitt";
import VCalendar from "v-calendar";
import VueGoogleMaps from '@fawmi/vue-google-maps'
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";


if (!localStorage.getItem("cartItems")) {
    localStorage.setItem("cartItems", JSON.stringify([]));
}

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const emitter = mitt();
const options = {
    // You can set your default options here
};
 const currencyFormat = (numb)=> {
    var num = Number(numb);
    if (num) {
        return "₦" + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    } else {
        return "₦0.00";
    }
};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({
            provide: {
                emitter: emitter,
                currency: currencyFormat,
            },
            render: () => h(app, props),
        })
            .use(VCalendar, {})
            .use(plugin)
            .use(VueToast,{
    // One of the options
    position: 'top-right',
  
})
            .use(VueGoogleMaps, {
                load: {
                    key: "YOUR_API_KEY_COMES_HERE",
                },
            })
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
