<?php


namespace App\WorkginGrids;


use Eliepse\WorkingGrid\CustomizableHeader;
use Eliepse\WorkingGrid\PageInfo;
use Eliepse\WorkingGrid\WorkingGrid;
use Mpdf\Mpdf;

class LPTGrid extends WorkingGrid implements CustomizableHeader
{

    public $headerHeight = 20;

    public $pagePaddings = [5, 20, 10, 30];

    public $modelColor = "#9e9e9e";

    public $guideColor = "#8c8c8c";


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