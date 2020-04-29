<template>
	<div class="cgCard" :class="{ 'cgCard--interactive': editable, 'cgCard--editing': editing }">
		<div class="cgCard__cn"
		     v-html="printValue"
		     @focusin="focus.chinese = true"
		     @focusout="(e) => focusOut('chinese', e)"
		     @keypress="filterKeys"
		     :contenteditable="editable"
		></div>
		<div class="cgCard__pinyin"
		     v-html="printPinyin"
		     @focusin="focus.pinyin = true"
		     @focusout="(e) => focusOut('pinyin', e)"
		     @keypress="filterKeys"
		     :contenteditable="editable"
		></div>
	</div>
</template>

<script>
	import {filterNonChinese} from "../../utils/chineseRegex"

	export default {
		name: "ChineseGridCard",
		props: {
			card: {
				type: Object,
				required: true
			},
			editable: {
				type: Boolean,
				required: false,
				default() {return false;}
			},
			grabFocus: {
				type: Boolean,
				required: false,
				default() {return false;}
			}
		},
		data() {
			return {
				focus: {
					chinese: false,
					pinyin: false,
				},
				chinese: this.card.value,
				pinyin: this.card.pinyin
			}
		},
		mounted() {
			this.$el.querySelector(".cgCard__cn").focus()
		},
		methods: {
			focusOut(type, e) {
				if(!this.editable) return;
				const content = e.target.innerHTML.replace(/<.*>/gi, "");
				switch (type) {
					case "chinese":
						this.focus.chinese = false
						this.chinese = filterNonChinese(content);
						break;
					case "pinyin":
						this.focus.pinyin = false
						this.pinyin = (content.match(/[a-zA-Z0-9]/gi) || []).join("");
				}
				this.$store.commit("UPDATE_CARD", {
					id: this.card.id,
					value: this.chinese,
					pinyin: this.pinyin,
				})
			},
			filterKeys(e) {
				if (e.code === 13) {
					e.preventDefault();
					return;
				}
				if (!e.key.match(/[a-zA-Z0-9]/)) {
					e.preventDefault();
				}
			}
		},
		computed: {
			editing() {
				return this.focus.chinese || this.focus.pinyin;
			},
			printValue() {
				return this.focus.chinese ? this.chinese || "" : this.chinese || "..."
			},
			printPinyin() {
				return this.focus.pinyin ? this.pinyin || "" : this.pinyin || "..."
			}
		}
	}
</script>