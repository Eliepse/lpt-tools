import Vuex from 'vuex';
import {filterNonPinyin, filterNonChinese, pinyinCharsRegex} from './utils/chineseRegex';
import Vue from 'vue';
import Axios from 'axios';
import pinTls from "pinyin-utils";

Vue.use(Vuex)

export default new Vuex.Store({
	strict: true,
	state: {
		chinese_words: [],
		chinese_cache: {}
	},
	mutations: {
		SET_CN_CACHE(state, list) {
			state.chinese_cache = list;
		},
		STORE_CARD(state, {value, pinyin}) {
			const id = state.chinese_words.reduce((carr, word) => carr < word.id ? word.id : carr, 0)
			this.state.chinese_words.push({
				id: id + 1,
				value: filterNonChinese(value),
				pinyin: (filterNonPinyin(pinyin.trim() || "").match(/\S+/g) || [])
					.map(pin => pinTls.numberToMark(pin)).join(" ")
			})
		},
		UPDATE_CARD(state, {id, value, pinyin}) {
			const word = state.chinese_words.find(word => word.id === id)
			if (!word) return;
			word.value = filterNonChinese(value)
			word.pinyin = (filterNonPinyin(pinyin || "").match(/\S+/g) || [])
				.map(pin => pinTls.numberToMark(pin))
				.join(" ");
		},
		MOVE_CARD(state, {id, direction}) {
			const actualId = state.chinese_words.findIndex(word => word.id === id)
			if (actualId < 0) return;

			if (direction === 1 && actualId + 1 < state.chinese_words.length) {
				state.chinese_words = [
					...state.chinese_words.slice(0, actualId),
					state.chinese_words[actualId + 1],
					state.chinese_words[actualId],
					...state.chinese_words.slice(actualId + 2),
				]
			} else if (direction === -1 && actualId - 1 >= 0) {
				state.chinese_words = [
					...state.chinese_words.slice(0, actualId - 1),
					state.chinese_words[actualId],
					state.chinese_words[actualId - 1],
					...state.chinese_words.slice(actualId + 1),
				]
			}
		},
		REMOVE_CARD(state, id) {
			state.chinese_words = state.chinese_words.filter(card => card.id !== id);
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