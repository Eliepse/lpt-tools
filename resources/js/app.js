import axios from "axios"
import Vue from "vue"
import ChineseGridComponent from "./components/ChineseGridComponent.vue"
import store from "./store"

window.Axios = axios;

document.execCommand("defaultParagraphSeparator", false, null);

Vue.component('chinese-grid', ChineseGridComponent);

new Vue({
	el: '#app',
	store
});
