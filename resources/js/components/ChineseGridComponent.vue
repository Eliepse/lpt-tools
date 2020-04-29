<template>
	<div class="container">
		<ul class="cg__inputList">
			<li class="cg__inputItem" v-for="card in $store.state.chinese_words" :key="card.id">
				<chinese-grid-card :card="card" :editable="true" :grabFocus="true"/>
			</li>
			<li class="cg__inputItem">
				<div @click="addCard" class="cgCard cgCard--interactive cgCard--ghost">
					<div>+</div>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	import {mapGetters} from "vuex"
	import ChineseGridCard from './chineseGrid/CardComponent';

	export default {
		components: {ChineseGridCard},
		mounted() {},
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
