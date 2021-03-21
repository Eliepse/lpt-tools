<?php
/**
 * @var string $day
 * @var string[] $hours
 * @var string $hour
 */

use Carbon\CarbonInterval;
use App\Http\Controllers\Onboarding\OnboardingRequestController;
?>
<li>
	<h3>@lang("onboarding.days.$day")</h3>
	<ul>
		@foreach($hours as $hour)
			<?php
			[$h, $min] = explode(":", $hour);
			?>
			<li>
				<a href="{{ action([OnboardingRequestController::class, "show"], [$school, $category, $course, "daily+$day+$hour"]) }}"
				   class="btn btn-ondboarding btn-ondboarding--small" type="submit"
				>
					@lang("onboarding.hour-short", ["hour" => $h, "minutes" => $min])
				</a>
			</li>
		@endforeach
	</ul>
</li>