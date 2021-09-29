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
    {
        path: "/tambah-invoice",
        component: require("./components/penjualan/invoicejual.vue").default,
    },
    {
        path: "/checkout-invoice",
        component: require("./components/penjualan/checkout.vue").default,
    },
    {
        path: "/data-invoice",
        component: require("./components/penjualan/datainvoice.vue").default,
    },
    {
        path: "/data-pelanggan",
        component: require("./components/master/pelanggan.vue").default,
    },
    {
        path: "/data-pegawai",
        component: require("./components/master/driver.vue").default,
    },
    {
        path: "/invoice-penjualan",
        component: require("./components/laporan/invoicepenjualan.vue").default,
    },
    {
        path: "/invoice-pengiriman",
        component: require("./components/laporan/invoicepengiriman.vue").default,
    },
    {
        path: "/transaksi-pelanggan",
        component: require("./components/laporan/transaksipelanggan.vue").default,
    },
]
Vue.mixin({
    methods: {
        formatRupiah(isisan) {
            var isi = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
            }).format(isisan);
            return isi;
        },
    },
});

const router = new VueRouter({
    mode: "history",
    routes,
});
const app = new Vue({
    el: '#app',
    router,
});
