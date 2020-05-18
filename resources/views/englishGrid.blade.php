<?php
/**
 * @var \Illuminate\Support\MessageBag $errors
 */
?>
		<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Writting grid creator - LPT</title>

	<link href="{{ mix("/css/styles.css") }}" rel="stylesheet" type="text/css">
</head>

<body class="page--writtingGrid">

<main id="app">
	<div class="cg">
		<div class="cg__container cg__container--configuring">
			<form action="{{ route('exercice.english-grid.pdf') }}" method="GET" class="cg__layout form">

				<div class="form__control @error("title") form__control--invalid @enderror">
					<label class="control__label" for="title">Titre</label>
					<input id="title" type="text" name="title" placeholder="学前班, ..." required autofocus maxlength=50 value="{{ old('title') }}">
					@error('title')
					<div class="form__helper">{{ $message }}</div>
					@enderror
				</div>

				<div class="form__control @error("words") form__control--invalid @enderror">
					<label class="control__label" for="words">Mots</label>
					<textarea id="title" type="text" name="words" placeholder="apple, banana..." required autofocus maxlength=50>{{ old('words') }}</textarea>
					@error('words')
					<div class="form__helper">{{ $message }}</div>
					@enderror
				</div>

				<div class="form__control form__control--options @error("pinyin") form__control--invalid @enderror">
					<span class="control__label">Règles pinyin</span>
					<div>
						<input id="pinyin-true" type="radio" name="pinyin" value="1" @if(old("pinyin") === "1") checked @endif>
						<label for="pinyin-true">Oui</label>
						<input id="pinyin-false" type="radio" name="pinyin" value="0" @if(old("pinyin", "0") === "0") checked @endif>
						<label for="pinyin-false">Non</label>
					</div>
					@error('pinyin')
					<div class="form__helper">{{ $message }}</div>
					@enderror
				</div>
			<div class="cg__actions text--right">
				<button type="submit">Générer l'exercice</button>
			</div>
			</form>
		</div>
	</div>

</main>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
