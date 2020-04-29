import Vue from "vue"
import ChineseGridComponent from "./components/ChineseGridComponent"

import store from "./store"

document.execCommand("defaultParagraphSeparator", false, null);

Vue.component('chinese-grid', ChineseGridComponent);

new Vue({
	el: '#app',
	store
});
