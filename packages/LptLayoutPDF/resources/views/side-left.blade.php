<?php /**
 * @var Eliepse\LptLayoutPDF\Student $student
 * @var App\Course $course
 */ ?>
<div class="left-side">

	<h1>
		<span>Les Petits Trilingues</span><br>
		Fiche de pré-inscription
	</h1>

	<h2>Cours</h2>

	<table class="infos">
		<tbody>
		<tr>
			<td class="label">Nom</td>
			<td class="value">{{ $course->name }}</td>
		</tr>
		<tr>
			<td class="label">Horaire</td>
			<td class="value">@lang("onboarding.days." . $schedule["day"]) - {{ $schedule["hour"] }} h</td>
		</tr>
		<tr>
			<td class="label">Établissement</td>
			<td class="value">{{ $course->school }}</td>
		</tr>
		</tbody>
	</table>

	<h2>Étudiant</h2>

	<table class="infos">
		<tbody>
		<tr>
			<td class="label">Prénom</td>
			<td class="value">{{ $student->firstname }}</td>
		</tr>
		<tr>
			<td class="label">Nom</td>
			<td class="value">{{ $student->lastname }}</td>
		</tr>
		<tr>
			<td class="label">Nom chinois</td>
			<td class="value">{{ $student->fullname_cn }}</td>
		</tr>
		<tr>
			<td class="label">Date de naissance</td>
			<td class="value">{{ $student->born_at }}</td>
		</tr>
		<tr>
			<td class="label">Ville de résidence</td>
			<td class="value">{{ $student->city_code }}</td>
		</tr>
		</tbody>
	</table>

	<table class="price">
		<tbody>
		<tr>
			<td>Reste à payer</td>
			<td class="price__tag">{{ $course->price }} €</td>
		</tr>
		</tbody>
	</table>

</div>