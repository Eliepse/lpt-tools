<?php /**
 * @var Eliepse\LptLayoutPDF\Student $student
 * @var App\Course $course
 */ ?>
<div class="left-side">

	<h1>
		<span>Les Petits Trilingues</span><br>
		Fiche de pré-inscription
	</h1>

	<h2>@lang("onboarding.course")</h2>

	<table class="infos">
		<tbody>
		<tr>
			<td class="label">@lang("onboarding.level")</td>
			<td class="value">{{ $course->name }}</td>
		</tr>
		<tr>
			<td class="label">@lang("onboarding.schedule")</td>
			<td class="value">@lang("onboarding.days." . $schedule["day"]) - {{ $schedule["hour"] }} h</td>
		</tr>
		<tr>
			<td class="label">@lang("onboarding.school")</td>
			<td class="value">{{ $course->school }}</td>
		</tr>
		</tbody>
	</table>

	<h2>@lang("onboarding.student")</h2>

	<table class="infos">
		<tbody>
		<tr>
			<td class="label">Prénom NOM (中文名)</td>
			<td class="value">
				{{ $student->getFullname() }} @if(!empty($student->fullname_cn))({{ $student->fullname_cn }})@endif
			</td>
		</tr>
		<tr>
			<td class="label">@lang("onboarding.form.bornAt")</td>
			<td class="value">{{ $student->born_at->toDateString() }}</td>
		</tr>
		<tr>
			<td class="label">@lang("onboarding.form.city-code")</td>
			<td class="value">{{ $student->city_code }}</td>
		</tr>
		<tr>
			<td class="label">@lang("onboarding.form.wechat_id")</td>
			<td class="value">{{ $student->first_contact_wechat }}</td>
		</tr>
		<tr>
			<td class="label">@lang("onboarding.form.phone_emergency")</td>
			<td class="value">
				{{ $student->first_contact_phone }}<br>
				{{ $student->second_contact_phone }}<br>
			</td>
		</tr>
		</tbody>
	</table>

	<table class="price">
		<tbody>
		<tr>
			<td>Reste à payer 需支付</td>
			<td class="price__tag">{{ $course->price }} €</td>
		</tr>
		</tbody>
	</table>

</div>