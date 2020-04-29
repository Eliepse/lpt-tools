import Vuex from 'vuex';
import {filterChinese, filterNonChinese} from './utils/chineseRegex';
import Vue from 'vue';

Vue.use(Vuex)

export default new Vuex.Store({
	strict: true,
	state: {
		chinese_words: {},
		chinese_cache: {}
	},
	mutations: {
		STORE_CARD(state, {value, pinyin}) {
			const id = Object.keys(state.chinese_words).reduce(function (carr, id) {
				id = Number(id);
				return id < carr ? carr : id;
			}, -1) + 1;
			this.state.chinese_words[id] = {
				id,
				value: filterChinese(value),
				pinyin: (pinyin.match(/[a-zA-Z0-9]/gi) || []).join("")
			}
		},
		UPDATE_CARD(state, {id, value, pinyin}) {
			if (!state.chinese_words[id]) return;
			state.chinese_words[id].value = filterNonChinese(value)
			state.chinese_words[id].pinyin = (pinyin.match(/[a-zA-Z0-9]/gi) || []).join("")
		}
	},
	getters: {},
})