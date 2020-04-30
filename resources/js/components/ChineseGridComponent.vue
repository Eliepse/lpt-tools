<template>
	<div class="cg">
		<div class="cg__container cg__container--editing" v-show="step === 'editing'">
			<div class="cg__actions text--center">
				<button v-show="$store.state.chinese_cache.length > 0" @click="$refs.cacheList.show()">
					Listes précédentes
				</button>
				<button @click="step = 'configuring'">Étape suivante</button>
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
		<div class="cg__container cg__container--configuring" v-show="step === 'configuring'">
			<div class="cg__actions text--left">
				<button @click="step = 'editing'">Retour à la liste</button>
			</div>
			<div class="cg__layout form">
				<div class="form__control">
					<label class="control__label" for="className">Titre</label>
					<input id="className" type="text" name="className" placeholder="学前班, ..." maxlength="50" required>
				</div>
				<div class="form__control">
					<label class="control__label" for="classDate">Date</label>
					<input id="classDate" type="date" name="date" placeholder="学前班, ...">
				</div>
				<div class="form__control form__control--options">
					<span class="control__label">Ordre des traits</span>
					<div>
						<input id="strokes-true" type="radio" name="stokes" value="true">
						<label for="strokes-true">Avec</label>
						<input id="strokes-false" type="radio" name="stokes" value="false" checked>
						<label for="strokes-false">Sans</label>
					</div>
				</div>
				<div class="form__control form__control--options">
					<span class="control__label">Pinyin</span>
					<div>
						<input id="pinyin-true" type="radio" name="pinyin" value="true">
						<label for="pinyin-true">Avec</label>
						<input id="pinyin-false" type="radio" name="pinyin" value="false" checked>
						<label for="pinyin-false">Sans</label>
					</div>
				</div>
				<div class="form__control">
					<label class="control__label" for="columns">Cells/line</label>
					<input id="columns" type="number" name="date" min="6" value="9" max="25">
				</div>
				<div class="form__control">
					<label class="control__label" for="models">Mots fantômes</label>
					<input id="models" type="number" name="date" min="0" value="1" max="10">
				</div>
				<div class="form__control">
					<label class="control__label" for="emptyLines">Lignes supplémentaires</label>
					<input id="emptyLines" type="number" name="date" min="0" value="0" max="50">
				</div>
			</div>
			<div class="cg__actions text--right">
				<button>Générer l'exercice</button>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapGetters} from "vuex"
	import ChineseGridCard from './chineseGrid/CardComponent';
	import ChineseCacheList from './chineseGrid/CacheListComponent';

	export default {
		components: {ChineseCacheList, ChineseGridCard},
		mounted() {
			this.$refs.cacheList.load();
		},
		data() {
			return {
				step: "editing"
			};
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