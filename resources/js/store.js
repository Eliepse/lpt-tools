import Vuex from 'vuex';
import {filterNonPinyin, filterNonChinese, pinyinCharsRegex} from './utils/chineseRegex';
import Vue from 'vue';
import Axios from 'axios';
import pinTls from "pinyin-utils";

Vue.use(Vuex)

export default new Vuex.Store({
	strict: true,
	state: {
		chinese_words: {},
		chinese_cache: {}
	},
	mutations: {
		SET_CN_CACHE(state, list) {
			state.chinese_cache = list;
		},
		STORE_CARD(state, {value, pinyin}) {
			const id = Object.keys(state.chinese_words)
				.reduce(function (carr, id) {
					id = Number(id);
					return id < carr ? carr : id;
				}, -1) + 1;
			this.state.chinese_words[id] = {
				id,
				value: filterNonChinese(value),
				pinyin: (filterNonPinyin(pinyin.trim() || "").match(/\S+/g) || [])
					.map(pin => pinTls.numberToMark(pin)).join(" ")
			}
		},
		UPDATE_CARD(state, {id, value, pinyin}) {
			if (!state.chinese_words[id]) return;
			state.chinese_words[id].value = filterNonChinese(value)
			state.chinese_words[id].pinyin = (filterNonPinyin(pinyin || "").match(/\S+/g) || [])
				.map(pin => pinTls.numberToMark(pin))
				.join(" ");
		},
		REMOVE_CARD(state, id) {
			if (!state.chinese_words[id]) return;
			delete state.chinese_words[id];
		}
	},
	actions: {
		async fetchChineseLists({commit}) {
			await Axios.get("/api/lists/chinese")
				.then((resp) => {
					commit("SET_CN_CACHE", resp.data)
				})
				.catch((resp) => {
					console.error("Unable to load chinese cached lists.", resp.message)
				})
		},
	},
	getters: {
		getChineseCacheList: state => key => state.chinese_cache[key] || []
	},
})