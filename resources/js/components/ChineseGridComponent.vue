<template>
	<div class="cg">
		<div class="cg__container cg__container--editing" v-show="step === 'editing'">
			<div class="cg__actions text--center">
				<button class="btn" v-show="$store.state.chinese_cache.length > 0" @click="$refs.cacheList.show()">
					Listes précédentes
				</button>
				<button class="btn" @click="step = 'configuring'">Étape suivante</button>
			</div>
			<div class="cg__sheet">
				<transition-group name="list" tag="ul" class="cg__inputList">
					<li class="cg__inputItem list-item"
					    v-for="card in getCards"
					    :key="card.id">
						<chinese-grid-card
								v-if="card.id !== 'add'"
								:card="card"
								:editable="true"
								:grabFocus="true"
                :onMove="handleMove"
								@validate="addCard"
								@deleted="$forceUpdate()"
						/>
						<div @click="addCard"
						     v-else
						     class="cgCard cgCard--interactive cgCard--ghost"
						>
							<div>+</div>
						</div>
					</li>
				</transition-group>
			</div>
			<chinese-cache-list ref="cacheList"/>
		</div>
		<div class="cg__container cg__container--configuring" v-show="step === 'configuring'">
			<div class="cg__actions text--left">
				<button class="btn" @click="step = 'editing'">Retour à la liste</button>
			</div>
			<div class="cg__layout form" ref="form">
				<div class="form__control">
					<label class="control__label" for="title">Titre</label>
					<input id="title" type="text" name="title" placeholder="学前班, ..." maxlength="50">
				</div>
				<div class="form__control">
					<label class="control__label" for="classDate">Date</label>
					<input id="classDate" type="date" name="date" placeholder="学前班, ...">
				</div>
				<div class="form__control form__control--options">
					<span class="control__label">Ordre des traits</span>
					<div>
						<input id="strokes-true" type="radio" name="strokes" value="true">
						<label for="strokes-true">Avec</label>
						<input id="strokes-false" type="radio" name="strokes" value="false" checked>
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
					<label class="control__label" for="columns">Caractères par ligne</label>
					<input id="columns" type="number" name="columns" min="6" value="9" max="25">
				</div>
				<div class="form__control">
					<label class="control__label" for="models">Quantité d'aide à l'écriture</label>
					<input id="models" type="number" name="models" min="0" value="1" max="10">
				</div>
				<div class="form__control">
					<label class="control__label" for="emptyLines">Lignes supplémentaires</label>
					<input id="emptyLines" type="number" name="emptyLines" min="0" value="0" max="50">
				</div>
			</div>
			<div class="cg__actions text--right">
				<button class="btn" @click="generateGrid">Générer l'exercice</button>
			</div>
		</div>
		<aside class="popup" v-show="downloadLink">
			<div class="popup__content">
        <div class="btn-group--actions">
				  <button class="btn btn--action btn--close" @click="downloadLink = null"></button>
        </div>
				<p>Votre exercice est prêt !</p>
				<a class="btn" :href="downloadLink" target="_blank">Télécharger l'exercice</a>
			</div>
		</aside>
	</div>
</template>

<script>
	import ChineseGridCard from './chineseGrid/CardComponent';
	import ChineseCacheList from './chineseGrid/CacheListComponent';

	export default {
		components: {ChineseCacheList, ChineseGridCard},
		mounted() {
			this.$refs.cacheList.load();
		},
		data() {
			return {
				step: "editing",
				downloadLink: null
			};
		},
		methods: {
			addCard() {
				this.$store.commit("STORE_CARD", {value: "", pinyin: ""})
				this.$forceUpdate()
			},
			generateGrid() {
				Axios.post("/api/grid/chinese", {
					words: this.$store.state.chinese_words,
					title: this.$refs.form.querySelector("input[name=title]").value,
					date: this.$refs.form.querySelector("input[name=date]").value,
					strokes: this.$refs.form.querySelector("input[name=strokes]:checked").value === "true",
					pinyin: this.$refs.form.querySelector("input[name=pinyin]:checked").value === "true",
					columns: Number(this.$refs.form.querySelector("input[name=columns]").value),
					models: Number(this.$refs.form.querySelector("input[name=models]").value),
					emptyLines: Number(this.$refs.form.querySelector("input[name=emptyLines]").value)
				})
					.then(res => {
						if (res.status === 200) {
							this.downloadLink = res.data.url;
						} else {
							alert("Erreur, aucun lien n'a été généré")
						}
					})
					.catch(res => alert("Erreur: " + res.message))
			},

      handleMove: function(id, direction) {
        this.$store.commit("MOVE_CARD", {id, direction})
        this.$forceUpdate()
      }
		},
    computed: {
      getCards: function () {
        return [...this.$store.state.chinese_words, {id:'add'}];
      },
    }
	}
</script>

<!--suppress CssUnusedSymbol -->
<style scoped>
	.list-item {
		transition: transform 250ms, opacity 200ms;
	}

	.list-enter {
		transform: scale(.5);
	}

	.list-leave-to {
		opacity: 0;
		transform: scale(.5);
	}
</style>