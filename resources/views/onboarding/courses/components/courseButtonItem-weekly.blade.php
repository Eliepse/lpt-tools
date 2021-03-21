<?php
/**
 * @var string $range
 * @var string[] $hours
 * @var string $hour
 */

use Carbon\CarbonInterval;
use App\Http\Controllers\Onboarding\OnboardingRequestController;
?>
<li>
	<?php [$from, $to] = explode("-", $range); ?>
	<h3>@lang("onboarding.days.$from") &rsaquo; @lang("onboarding.days.$to")</h3>
	<ul>
		@foreach($hours as $hour)
			<?php
			[$h, $min] = explode(":", $hour);
			?>
			<li>
				<a href="{{ action([OnboardingRequestController::class, "show"], [$school, $category, $course, "weekly+$range+$hour"]) }}"
				   class="btn btn-ondboarding btn-ondboarding--small" type="submit"
				>
					@lang("onboarding.hour-short", ["hour" => $h, "minutes" => $min])
				</a>
			</li>
		@endforeach
	</ul>
</li>