import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./views/Home.vue";
import About from "./views/About.vue";
import Dokter from "./views/Dokter.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/about",
            name: "about",
            component: About,
        },
        {
            path: "/dokter",
            name: "dokter",
            component: Dokter,
        },
    ],
});

export default router;
