<?php

namespace App\WorkginGrids;

use Eliepse\WorkingGrid\Template\WithDrawingTutorial;

class GridTemplateStrokes extends GridTemplate implements WithDrawingTutorial
{
	// Makes the tutorial height relative to the cell size
	public $tutorial_height = 0;

	public $tutorial_color = "#bfbfbf";
}