<template>
	<div class="cg">
		<div class="cg__actions">
			<button v-show="$store.state.chinese_cache.length > 0" @click="$refs.cacheList.show()">Listes précédentes</button>
		</div>
		<div class="cg__sheet">
			<ul class="cg__inputList">
				<li class="cg__inputItem list-complete-item" v-for="card in $store.state.chinese_words" :key="card.id">
					<chinese-grid-card :card="card" :editable="true" :grabFocus="true"/>
				</li>
				<li class="cg__inputItem">
					<div @click="addCard" class="cgCard cgCard--interactive cgCard--ghost">
						<div>+</div>
					</div>
				</li>
			</ul>
		</div>
		<chinese-cache-list ref="cacheList"/>
	</div>
</template>

<script>
	import {mapGetters} from "vuex"
	import ChineseGridCard from './chineseGrid/CardComponent';
	import ChineseCacheList from './chineseGrid/ChineseCacheListComponent';

	export default {
		components: {ChineseCacheList, ChineseGridCard},
		mounted() {
			this.$refs.cacheList.load();
		},
		data() {
			return {};
		},
		methods: {
			addCard() {
				this.$store.commit("STORE_CARD", {value: "", pinyin: ""})
				this.$forceUpdate()
			}
		},
		computed: {
			...mapGetters([])
		}
	}
</script>

<style scoped></style>
