<?php

namespace App\WorkginGrids;

use Eliepse\WorkingGrid\PageInfo;
use Eliepse\WorkingGrid\Template\CustomizableHeader;
use Eliepse\WorkingGrid\Template\Template;
use Mpdf\Mpdf;

class GridTemplate extends Template implements CustomizableHeader
{
    public $header_height = 25;

    public $paddings = [5, 20, 10, 30];

    public $model_color = "#cbcbcb";

    public $guide_color = "#bfbfbf";

    public $day = " ";

    public $month = " ";


    public function header(Mpdf $pdf, PageInfo $infos): void
    {
        // - titre du document : LPT 三语宝贝 学前班  姓名:

		    $css = "font-family: {$this->defaultFonts}; text-align: center; font-size: 1rem;";

        $pdf->SetFontSize(16);
		    $pdf->WriteHTML("<h1 style='$css'>{$this->title}</h1>");

        $pdf->SetFontSize(14);

        $pdf->WriteFixedPosHTML(
        	"<div style='font-family: {$this->defaultFonts};'>姓名:</div>",
	        30,
	        16,
	        120,
	        5,
        );

        $month = $this->month . " ";
        $day = $this->day . " ";

        $pdf->WriteFixedPosHTML(
        	"<div style='font-family: {$this->defaultFonts}; text-align: right'>{$month}月 {$day}日</div>",
	        40,
	        16,
	        120,
	        5,
        );

        $pdf->Image(resource_path("images/logo.png"), 170, 5, 20);

        $pdf->SetXY(0, 0);
    }
}
