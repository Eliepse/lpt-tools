<template>
	<aside class="cgCache" :class="{'cgCache--active':active}">
		<button class="btn cgCache__btnClose btn--action btn--close" @click="hide"></button>
		<h1 class="cgCache__title">Listes précédemment éditées</h1>
		<ul class="cgCache__listList">
			<li v-for="(list, key) in $store.state.chinese_cache" :key="key" class="cgCache__item">
				<div class="cgCache__list">
					<div v-for="(card, key) in list" :key="key" class="cgCache__word">
						<span class="cgCache__chinese">{{ card.value }}</span>
						<span class="cgCache__pinyin">{{ card.pinyin || "..." }}</span>
					</div>
				</div>
				<button class="btn" @click="insertList(key)">Ajouter</button>
			</li>
		</ul>
	</aside>
</template>

<script>
	export default {
		name: "CacheList",
		data() {
			return {
				active: false,
			}
		},
		methods: {
			async load() {await this.$store.dispatch("fetchChineseLists")},
			show() {this.active = true},
			hide() {this.active = false},
			insertList(index) {
				this.$store.getters.getChineseCacheList(index).forEach(({value, pinyin}) => {
					this.$store.commit("STORE_CARD", {value, pinyin})
				})
				this.$parent.$forceUpdate()
			}
		}
	}
</script>

<style scoped>

</style>