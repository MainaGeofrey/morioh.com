import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";

// Nucleo Icons
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";

import materialKit from "./material-kit";


//import store from "./stores";
import ElementPlus from "element-plus";
//import i18n from "@/core/plugins/i18n";
//imports for app initialization
import ApiService from "./core/services/ApiService";

//import { BootstrapVue, IconsPlugin } from "bootstrap-vue";


const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(materialKit);

//app.use(store);
app.use(ElementPlus);

ApiService.init(app);
//initApexCharts(app);
//initInlineSvg(app);
//initVeeValidate();

//app.use(i18n);


app.mount("#app");
