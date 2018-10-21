<?php


namespace App\WorkginGrids;


use Eliepse\WorkingGrid\PageInfo;
use Eliepse\WorkingGrid\Template\CustomizableHeader;
use Eliepse\WorkingGrid\Template\Template;
use Eliepse\WorkingGrid\Template\WithDrawingTutorial;
use Mpdf\Mpdf;

class GridTemplateTutorial extends Template implements CustomizableHeader, WithDrawingTutorial
{

    public $header_height = 25;

    public $paddings = [5, 20, 10, 30];

    public $model_color = "#9e9e9e";

    public $guide_color = "#8c8c8c";


    public function header(Mpdf $pdf, PageInfo $infos): void
    {
        // - titre du document : LPT 三语宝贝 学前班第_课  姓名:_ 第_周
        $pdf->SetFontSize(16);

        $pdf->Cell(210, 0, $this->title . "第 课", false, false, 'C', 0, 0, 0, '', 'T', 'T');

        $pdf->SetFontSize(14);

        $pdf->SetXY(30, 16);
        $pdf->Cell(120, 5, "姓名:", false, false, "L");;

        $pdf->SetXY(30, 16);
        $pdf->Cell(120, 5, "第 周", false, false, "R");

        $pdf->Image(resource_path("images/logo.png"), 170, 5, 20);

        $pdf->SetXY(0, 0);
    }

}