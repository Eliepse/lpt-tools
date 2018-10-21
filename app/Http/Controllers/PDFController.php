<?php

namespace App\Http\Controllers;

use App\Graphic;
use App\WorkginGrids\GridTemplate;
use App\WorkginGrids\GridTemplateTutorial;
use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\WorkingGrid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PDFController extends Controller
{


    /**
     * @param Request $request
     * @throws \Throwable
     */
    public function workingGridPDF(Request $request)
    {

        $this->validate($request, [
            'className'  => 'required|string|max:50',
            'characters' => 'required|string|min:1',
            'strokeHelp' => 'sometimes|boolean',
            'columns'    => 'required|int|min:6|max:20',
            'lines'      => 'required|int|min:1|max:20',
            'models'     => 'required|int|min:0|max:20',
            'emptyLines' => 'required|int|min:0|max:20',
        ]);

        $requestCharacters = trim($request->get('characters'));
        $words = [];


        preg_match_all("/\p{Han}/u", $requestCharacters, $charactersRaw);
        preg_match_all("/\p{Han}+/u", $requestCharacters, $wordsRaw);

        $charactersRaw = $charactersRaw[0];
        $wordsRaw = count($wordsRaw[0]) > 1 ? $wordsRaw[0] : $charactersRaw;

        /** @var Collection $graph */
        /** @noinspection PhpUndefinedMethodInspection */
        $graph = Graphic::select(['character', 'strokes'])
            ->whereIn('character', $charactersRaw)
            ->get();


        // Create content
        foreach ($wordsRaw as $wordRaw) {

            $word = new Word([]);

            foreach ($this->mbStringToArray($wordRaw) as $characterRaw) {

                if ($characterGraph = $graph->firstWhere('character', '===', $characterRaw)) {

                    $word->addDrawable(new Character($characterGraph->character, $characterGraph->strokes));

                }

            }

            if (count($word)) {

                $words[] = $word;

            }

        }

        // Add empty lines
        for ($i = 0; $i < intval($request->get('emptyLines', 0)); $i++)
            $words[] = new Word([new Character("", [])]);

        // Instanciate the correct template
        $template = $request->get('strokeHelp', false)
            ? new GridTemplateTutorial()
            : new GridTemplate();

        // Configure the template
        $template->title = "LPT 三语宝贝" . $request->get('className', " ");
        $template->columns_amount = $request->get('columns', 9);
        $template->row_max = $request->get('lines', null);
        $template->model_amount = $request->get('models', 3);

        // Render the template
        WorkingGrid::inlinePrint($template, $words);

    }


    private function mbStringToArray($string)
    {
        $strlen = mb_strlen($string);
        $array = [];
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, "UTF-8");
            $string = mb_substr($string, 1, $strlen, "UTF-8");
            $strlen = mb_strlen($string);
        }

        return $array;
    }


}
