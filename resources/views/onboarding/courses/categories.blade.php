@extends("onboarding.courses.base")

@section("body-class", "onboarding--categories")

@section("header-text")
	<a href="{{ route("onboarding.schools") }}" class="onboarding-header__backBtn">
		<svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" fill="none">
			<path fill-rule="evenodd" d="M.5 6.5c-.3-.3-.3-.8 0-1.1L5.2.7c.3-.3.8-.3 1.1 0s.3.8 0 1.1L2.8 5.3H19v1.5H2.8l3.5 3.5c.3.3.3.8 0 1.1s-.8.3-1.1 0L.5 6.5z" fill="#0da84a"/>
		</svg>
		&nbsp;
		@lang("onboarding.buttons.previous")
	</a>
	<hr>
	<h1 class="onboarding-header__title">@lang("onboarding.our categories")</h1>
@endsection

@section("main")
	<div class="container">
		<ul class="onboarding-choiceList">
			@foreach($categories as $category)
				<li>
					@component("onboarding.courses.components.button")
						@slot("link", route("onboarding.courses", [$school, $category]))
						@lang("onboarding.categories." . $category)
					@endcomponent
				</li>
			@endforeach
		</ul>
	</div>
@endsection