<?php

namespace App\WorkginGrids;

use Eliepse\WorkingGrid\Template\WithDrawingTutorial;
use Eliepse\WorkingGrid\Template\WithPinyin;

class GridTemplateStrokesPinyin extends GridTemplate implements WithPinyin, WithDrawingTutorial
{
	// Makes the tutorial height relative to the cell size
    public $tutorial_height = 0;

	public $tutorial_color = "#bfbfbf";
}
