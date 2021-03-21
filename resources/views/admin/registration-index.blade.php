@extends('layouts.app')

<?php
/**
 * @var Collection $registrations
 * @var CourseRegistration $registration
 */

use App\Course;
use App\Models\CourseRegistration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
?>

@section('content')
	<div class="container m-auto max-w-5xl">
		<h1 class="mt-12 mb-8 text-3xl font-bold">Inscriptions</h1>

		<table class="w-full">
			<thead class="border-b border-gray-200 text-gray-400">
			<tr>
				<th class="pb-2 px-2 font-normal text-left">École</th>
				<th class="pb-2 px-2 font-normal text-left">Cours</th>
				<th class="pb-2 px-2 font-normal text-left">Horaire</th>
				<th class="pb-2 px-2 font-normal text-left">Étudiant</th>
				<th class="pb-2 px-2 font-normal text-left">Contacts</th>
				<th class="pb-2 px-2 font-normal text-left">Enregistré à</th>
			</tr>
			</thead>
			<tbody>
			@foreach($registrations as $key => $registration)
				<?php
				$course = new Course($registration["course"]);
				$fromHour = Carbon::createFromFormat("H:i", $registration->schedule["hour"]);
				$toHour = $fromHour->copy()->addMinutes($course->duration);
				$class = "";
				if (request("uid") === $registration->uid) {
					$class = "bg-yellow-200";
				} elseif ($key % 2) {
					$class = "bg-green-50";
				}
				?>
				<tr class="{{ $class }}" id="uid-{{ $registration->uid }}">
					<td class="text-left py-4 px-2">
						@lang("onboarding.schools.{$registration->school}.name")
					</td>
					<td class="text-left py-4 px-2">
						@lang("onboarding.categories.{$registration->category}") - {{ $course->name }}<br>
						{{ $course->price }}&nbsp;€ / @lang("onboarding.denominators.{$course->price_denominator}") <br>
					</td>
					<td class="text-left py-4 px-2">
						{{ $registration->schedule["days"] }}<br>
						{{ $fromHour->format("H:i") }} - {{ $toHour->format("H:i") }}<br>
					</td>
					<td class="text-left py-4 px-2">
						{{ $registration->student["firstname"] }} {{ $registration->student["lastname"] }}
						<i>({{ $registration->student["fullname_cn"] }})</i><br>
						{{ Carbon::create($registration->student["birthday"])->toDateString() }}<br>
						{{ $registration->student["city_code"] }}
					</td>
					<td class="text-left py-4 px-2">
						Tél 1 : {{ $registration->contact["phone_1"] }}<br>
						Tél 2 : {{ $registration->contact["phone_2"] }}<br>
						Wechat : {{ $registration->contact["wechat_1"] }}
					</td>
					<td>
						{{ $registration->created_at->toDateTimeString("minute") }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endsection
