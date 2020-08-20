<?php

use App\Http\Controllers\Onboarding\OnboardingRequestController;

?>
@extends("onboarding.courses.base")

@section("body-class", "onboarding--request")

@section("header-text")
	<a href="{{ route("onboarding.courses", [$course->school, $course->category]) }}" class="onboarding-header__backBtn">
		<svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" fill="none">
			<path fill-rule="evenodd" d="M.5 6.5c-.3-.3-.3-.8 0-1.1L5.2.7c.3-.3.8-.3 1.1 0s.3.8 0 1.1L2.8 5.3H19v1.5H2.8l3.5 3.5c.3.3.3.8 0 1.1s-.8.3-1.1 0L.5 6.5z" fill="#0da84a"/>
		</svg>
		&nbsp;
		@lang("onboarding.buttons.previous")
	</a>
	<hr>
	<h1 class="onboarding-header__title">@lang("onboarding.your child")</h1>
@endsection

@section("main")
	<div class="container">
		<form class="onboardingForm" action="{{ action([OnboardingRequestController::class, "store"], [$course->school, $course->category, $course, $schedule]) }}" method="post">
			@csrf
			@method("post")
			<div class="form__group">
				<div class="form__control @error("firstname") form__control--invalid @enderror">
					<label class="control__label" for="firstname">@lang("onboarding.form.firstname")</label>
					<input id="firstname"
					       type="text"
					       name="firstname"
					       placeholder=""
					       maxlength="32"
					       required
					       value="{{ old("firstname", $student->firstname) }}"
					>
					@error("firstname")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>

				<div class="form__control @error("lastname") form__control--invalid @enderror">
					<label class="control__label" for="lastname">@lang("onboarding.form.lastname")</label>
					<input id="lastname"
					       type="text"
					       name="lastname"
					       placeholder=""
					       maxlength="32"
					       required
					       value="{{ old("lastname", $student->lastname) }}"
					>
					@error("lastname")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>

				<div class="form__control @error("fullname_cn") form__control--invalid @enderror">
					<label class="control__label" for="fullname_cn">@lang("onboarding.form.fullname_cn")</label>
					<input id="fullname_cn"
					       type="text"
					       name="fullname_cn"
					       placeholder=""
					       maxlength="32"
					       required
					       value="{{ old("fullname_cn", $student->fullname_cn) }}"
					>
					@error("fullname_cn")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>

				<div class="form__control @error("bornAt") form__control--invalid @enderror">
					<label class="control__label" for="bornAt">@lang("onboarding.form.bornAt")</label>
					@error("bornAt")
					<p class="form__helper">{{$message}}</p>
					@enderror
					<input id="bornAt"
					       type="date"
					       name="bornAt"
					       required
					       placeholder="YYYY-MM-DD"
					       pattern="\d{4}-\d{2}-\d{2}"
{{--					       max="{{ \Carbon\Carbon::now()->toDateString() }}"--}}
					       value="{{ old("bornAt", optional($student->born_at)->toDateString()) }}"
					>
				</div>

				<div class="form__control @error("city_code") form__control--invalid @enderror">
					<label class="control__label" for="city_code">@lang("onboarding.form.city-code")</label>
					<input id="city_code"
					       type="text"
					       name="city_code"
					       placeholder=""
					       maxlength="5"
					       required
					       pattern="\d{5}"
					       title="ex: 93250"
					       value="{{ old("city_code", $student->city_code) }}"
					>
					@error("city_code")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>
			</div>

			<h2 class="onboarding-header__title">@lang("onboarding.your contacts")</h2>

			<div class="form__group">
				<div class="form__control @error("first_wechat_id") form__control--invalid @enderror">
					<label class="control__label" for="first_wechat_id">@lang("onboarding.form.wechat_id")</label>
					<input id="first_wechat_id"
					       type="text"
					       name="first_wechat_id"
					       placeholder=""
					       maxlength="32"
					       required
					       value="{{ old("first_wechat_id", $student->first_contact_wechat) }}"
					>
					@error("first_wechat_id")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>

				<div class="form__control @error("first_phone") form__control--invalid @enderror">
					<label class="control__label" for="wechatId">@lang("onboarding.form.phone_emergency")</label>
					<input id="wechatId"
					       type="tel"
					       name="first_phone"
					       placeholder=""
					       pattern="[+- 0-9()]+"
					       maxlength="17"
					       required
					       value="{{ old("first_phone", $student->first_contact_phone) }}"
					>
					@error("first_phone")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>

				<div class="form__control @error("second_phone") form__control--invalid @enderror">
					<label class="control__label" for="wechatId">@lang("onboarding.form.phone_emergency2")</label>
					<input id="wechatId"
					       type="tel"
					       name="second_phone"
					       placeholder=""
					       pattern="[+- 0-9()]+"
					       maxlength="17"
					       required
					       value="{{ old("second_phone", $student->second_contact_phone) }}"
					>
					@error("second_phone")
					<p class="form__helper">{{$message}}</p>
					@enderror
				</div>
			</div>

			<button class="btn btn-ondboarding" type="submit">{!! nl2br(trans("onboarding.complete my registration request")) !!}</button>
		</form>
	</div>
@endsection