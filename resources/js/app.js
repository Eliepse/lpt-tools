import Vue from "vue"
import Vuex from "vuex"
import ChineseGridComponent from "./components/ChineseGridComponent"

Vue.use(Vuex)

document.execCommand("defaultParagraphSeparator", false, null);

const store = new Vuex.Store({
	state: {
		chineseCards: {
			current: [],
			cachedList: []
		}
	},
	getters: {},
	mutations: {
		createCard() {
			const card = {value: "", pinyin: ""}
			this.state.chineseCards.current.push(card)
			return card;
		},
		updateCard({card, value, pinyin}) {
			//this.state.chineseCards.current.fin
		}
	},
	actions: {},
})

Vue.component('chinese-grid', ChineseGridComponent);

new Vue({
	el: '#app',
	store
});
