<?php

use \App\Http\Controllers\Onboarding\DownloadRequestPDFController;

?>
@extends("onboarding.courses.base")

@section("body-class", "onboarding--confirmation")

@section("main")
	<img class="lpt-logo" src="/images/logo.png" alt="LPT logo">
	@if(\Illuminate\Support\Facades\App::getLocale() === "cn")
		<img class="onboarding-requestReady" src="/images/decorations/request_ready-zh.svg" alt="Votre dossier d'inscription est prêt !">
	@else
		<img class="onboarding-requestReady" src="/images/decorations/request_ready-fr.svg" alt="Votre dossier d'inscription est prêt !">
	@endif
	<div class="onboarding-confirmMessage">
		<p>@lang("onboarding.confirmation_text_1")</p>
		<p>@lang("onboarding.confirmation_text_2")</p>
	</div>
	<form action="{{ action(DownloadRequestPDFController::class, [$course->school, $course->category, $course, $schedule]) }}" method="post">
		@csrf
		@method('post')
		<button class="btn btn-ondboarding" type="submit">@lang("onboarding.buttons.download-form")</button>
	</form>
	<a class="btn btn--link" href="{{ route("onboarding.schools") }}">@lang("onboarding.buttons.reset")</a>
@endsection