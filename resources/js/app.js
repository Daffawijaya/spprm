import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/index.js";
import "../css/app.css";
import { createPinia } from "pinia";
import axios from "axios";

createApp(App).use(createPinia()).use(router).mount("#app");

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            // Token expired / invalid
            localStorage.removeItem("token"); // kalau kamu simpan token di localStorage
            localStorage.removeItem("loginTime"); // kalau kamu simpan login time
            router.push({ name: "Login" }); // arahkan user ke halaman login
        }

        return Promise.reject(error);
    }
);
