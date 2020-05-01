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
					<label class="control__label" for="columns">Cells/line</label>
					<input id="columns" type="number" name="columns" min="6" value="9" max="25">
				</div>
				<div class="form__control">
					<label class="control__label" for="models">Mots fantômes</label>
					<input id="models" type="number" name="models" min="0" value="1" max="10">
				</div>
				<div class="form__control">
					<label class="control__label" for="emptyLines">Lignes supplémentaires</label>
					<input id="emptyLines" type="number" name="emptyLines" min="0" value="0" max="50">
				</div>
			</div>
			<div class="cg__actions text--right">
				<button @click="generateGrid">Générer l'exercice</button>
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
			},
			generateGrid() {
				Axios.post("/api/grid/chinese", {
					words: this.$store.state.chinese_words,
					title: this.$refs.form.querySelector("input[name=title").value,
					date: this.$refs.form.querySelector("input[name=date]").value,
					strokes: this.$refs.form.querySelector("input[name=strokes]:checked").value === "true",
					pinyin: this.$refs.form.querySelector("input[name=pinyin]:checked").value === "true",
					columns: Number(this.$refs.form.querySelector("input[name=columns]").value),
					models: Number(this.$refs.form.querySelector("input[name=models]").value),
					emptyLines: Number(this.$refs.form.querySelector("input[name=emptyLines]").value),
				})
					.then((res) => {
						/*******************************************************************************
						 *******************************************************************************
						 * L'idée est de préparer le document en mettant en cache les informations     *
						 * nécessaires à la génération du document pdf (conserver également les        *
						 * données vectoriels des caractères ?).                                       *
						 * Ensuite, la clé de ce cache (plus ou moins sous la forme d'un uuid) est     *
						 * renvoyé à l'utilisateur sous la forme d'une url. L'interface peut ainsi     *
						 * afficher un bouton permettant permettant de télécharger le document généré. *
						 *******************************************************************************
						 *******************************************************************************/
						//return;
						//if (res.status === 200) {
						//	// Create a new Blob object using the
						//	//response data of the onload object
						//	const blob = new Blob([this.response], {type: 'image/pdf'});
						//	//Create a link element, hide it, direct
						//	//it towards the blob, and then 'click' it programatically
						//	const a = document.createElement("a");
						//	a.style.display = "none";
						//	document.body.appendChild(a);
						//	//Create a DOMString representing the blob
						//	//and point the link element towards it
						//	let url = window.URL.createObjectURL(blob);
						//	a.href = url;
						//	a.download = 'myFile.pdf';
						//	//programatically click the link to trigger the download
						//	//a.click();
						//	//release the reference to the file by revoking the Object URL
						//	//window.URL.revokeObjectURL(url);
						//} else {
						//	//deal with your error state here
						//}
					})
			}
		},
		computed: {
			...mapGetters([])
		}
	}
</script>