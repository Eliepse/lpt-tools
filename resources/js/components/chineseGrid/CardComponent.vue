<template>
	<div class="cgCard" :class="{ 'cgCard--editable': editable, 'cgCard--editing': editing }">
    <div class="btn-group--actions">
      <button class="btn btn--action btn--close" @click="removeCard"></button>
    </div>
		<div class="cgCard__cn"
		     v-html="printValue"
		     @focusin="focus.chinese = true"
		     @focusout="(e) => focusOut('chinese', e)"
		     @keypress="onkeypress"
		     :contenteditable="editable"
		></div>
		<div class="cgCard__pinyin"
		     v-html="printPinyin"
		     @focusin="focus.pinyin = true"
		     @focusout="(e) => focusOut('pinyin', e)"
		     @keypress="onkeypress"
		     :contenteditable="editable"
		></div>
	</div>
</template>

<script>
	import {filterNonChinese, filterNonPinyin, pinyinCharsRegex} from "../../utils/chineseRegex"

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
				if (!this.editable) return;
				const content = e.target.innerHTML.replace(/<.*>/gi, "");
				switch (type) {
					case "chinese":
						this.focus.chinese = false
						this.chinese = filterNonChinese(content);
						break;
					case "pinyin":
						this.focus.pinyin = false
						this.pinyin = filterNonPinyin(content || "");
				}
				this.$store.commit("UPDATE_CARD", {
					id: this.card.id,
					value: this.chinese,
					pinyin: this.pinyin,
				})
				this.pinyin = this.card.pinyin
			},
			removeCard() {
				this.$store.commit("REMOVE_CARD", this.card.id)
				this.$emit("deleted")
			},
			filterKeys(e) {
				if (!e.key.match(pinyinCharsRegex)) {
					e.preventDefault();
				}
			},
			onkeypress(e) {
				if (e.code === 'Enter') {
					this.$emit("validate");
					e.preventDefault();
					return;
				}
				this.filterKeys(e)
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