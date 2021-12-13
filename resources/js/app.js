import "./bootstrap";
import Vue from "vue";
import router from "./router";
import axios from "axios";
import VueAxios from "vue-axios";
import App from "./layouts/App.vue";

Vue.use(VueAxios, axios);
new Vue({
    router,
    el: "#app",
    render: (h) => h(App),
});
