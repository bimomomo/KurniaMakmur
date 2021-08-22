require('./bootstrap');

window.Vue = require('vue').default;
// register vue router
import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

// register vform
import {
    Form
} from "vform";
window.Form = Form;

// register swall alert
let Fire = new Vue();
window.Fire = Fire;
//Import Alert
import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});
window.Toast = Toast;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
let routes = [
    //DASHBOARD
    {
        path: "/home",
        component: require("./components/DashboardMain.vue").default,
    },
    {
        path: "/master-kategori",
        component: require("./components/master/kategori.vue").default,
    },
    {
        path: "/master-brand",
        component: require("./components/master/brand.vue").default,
    },
    {
        path: "/master-gudang",
        component: require("./components/master/gudang.vue").default,
    },
    {
        path: "/master-satuan",
        component: require("./components/master/satuan.vue").default,
    },
    {
        path: "/master-barang",
        component: require("./components/master/barang.vue").default,
    },
    {
        path: "/mutasi-stock-masuk",
        component: require("./components/mutasi/mutasistockmasuk.vue").default,
    },
]

const router = new VueRouter({
    mode: "history",
    routes,
});
const app = new Vue({
    el: '#app',
    router,
});
