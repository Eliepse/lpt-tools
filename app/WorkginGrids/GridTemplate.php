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
        // - titre du document : LPT 三语宝贝 学前班  姓名:_
        $pdf->SetFontSize(16);

        $pdf->Cell(210, 0, $this->title, false, false, 'C', 0, 0, 0, '', 'T', 'T');

        $pdf->SetFontSize(14);

        $pdf->SetXY(30, 16);
        $pdf->Cell(120, 5, "姓名:", false, false, "L");;

        $month = mb_strlen($this->month) === 2 ? $this->month . " " : $this->month . " ";
        $day = mb_strlen($this->day) === 2 ? $this->day . " " : $this->day . " ";

        $pdf->SetXY(40, 16);
        $pdf->Cell(120, 5, "{$month}月 {$day}日", false, false, "R");

        $pdf->Image(resource_path("images/logo.png"), 170, 5, 20);

        $pdf->SetXY(0, 0);
    }
}
