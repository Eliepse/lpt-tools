import Vue from "vue"
import Vuex from "vuex"
import ChineseGridComponent from "./components/ChineseGridComponent"
import {filterChinese, filterNonChinese} from './utils/chineseRegex';

Vue.use(Vuex)

document.execCommand("defaultParagraphSeparator", false, null);

const store = new Vuex.Store({
	strict: true,
	state: {
		chinese_cards: {},
		chinese_cache: {}
	},
	mutations: {
		STORE_CARD(state, {value, pinyin}) {
			const id = Object.keys(state.chinese_cards).reduce(function (carr, id) {
				id = Number(id); return id < carr ? carr : id;
			}, -1) + 1;
			this.state.chinese_cards[id] = {
				id,
				value: filterChinese(value),
				pinyin: (pinyin.match(/[a-zA-Z0-9]/gi) || []).join("")
			}
		},
		UPDATE_CARD(state, {id, value, pinyin}) {
			if (!state.chinese_cards[id]) return;
			state.chinese_cards[id].value = filterNonChinese(value)
			state.chinese_cards[id].pinyin = (pinyin.match(/[a-zA-Z0-9]/gi) || []).join("")
		}
	},
	getters: {},
})

Vue.component('chinese-grid', ChineseGridComponent);

new Vue({
	el: '#app',
	store
});
