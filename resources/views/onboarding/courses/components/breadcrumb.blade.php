<ol class="onboarding-breadcrumb">
	<li>
		<a href="{{ route("onboarding.welcome") }}">
			@lang("general.lptName")
		</a>
	</li>
	@isset($school)
		<li>
			<a href="{{ route("onboarding.categories", [$school]) }}">
				@lang("onboarding.schools.$school.name")
			</a>
		</li>
	@endif
	@isset($category)
		<li>
			<a href="{{ route("onboarding.courses", [$school, $category]) }}">
				@lang("onboarding.categories.$category")
			</a>
		</li>
	@endif
</ol>