@extends("onboarding.courses.base")

@section("body-class", "onboarding--portal")

@section("main")
	{{--	@dd(\Illuminate\Support\Facades\Lang::getLocale())--}}
	@if(\Illuminate\Support\Facades\App::getLocale() === "cn")
		<img class="onboarding-portalTitle" src="/images/decorations/onboarding-title-fr.svg" alt="Inscription - Les Petits Trilingues">
	@else
		<img class="onboarding-portalTitle" src="/images/decorations/onboarding-title-fr.svg" alt="Inscription - Les Petits Trilingues">
	@endif
	{{--	<div class="container">--}}
	<a class="btn btn-ondboarding" href="{{ route("onboarding.schools") }}">C'est parti&nbsp;!</a>
	{{--	</div>--}}
@endsection