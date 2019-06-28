<?php

namespace App\Http\Controllers;

use App\Graphic;
use App\WorkginGrids\GridTemplate;
use App\WorkginGrids\GridTemplateTutorial;
use Carbon\Carbon;
use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\WorkingGrid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class PDFController
{
    use ValidatesRequests;

    /**
     * @param Request $request
     * @throws \Throwable
     */
    public function workingGridPDF(Request $request)
    {
        /*
         * Validation of the request. Note that some fields
         * are not required and needs to be handle in the
         * PDF generation/design process.
         * */
        $this->validate($request, [
            'className' => 'required|string|max:50',
            'characters' => 'required|string|min:1',
            'columns' => 'required|integer|min:6',
            'lines' => 'required|integer|min:1',
            'models' => 'required|int|min:0|max:20',
            'emptyLines' => 'required|int|min:0|max:50',
            'date' => 'sometimes|nullable|date:Y-m-d',
            'month' => 'sometimes|integer|between:1,12',
            'strokeHelp' => 'sometimes|boolean',
        ]);

        if (!empty($date = $request->get('date')))
            $date = Carbon::createFromFormat('Y-m-d', $date);

        $requestChars = trim($request->get('characters'));
        $words = [];

        /*
         * We extract according a single-caracter word pattern
         * and according a multi-caracters word pattern. Only chinese
         * caracters are extracted. Word or character separators can
         * be any non-chinese character.
         * */
        preg_match_all("/\p{Han}/u", $requestChars, $singleCharMatches);
        preg_match_all("/\p{Han}+/u", $requestChars, $multiCharsMatches);


        /*
         * Decide if the user requested multi-caracters words
         * or single-caracters words.
         * */
        $wordsMatches = count($multiCharsMatches[0]) > 1 ? $multiCharsMatches[0] : $singleCharMatches[0];

        /**
         * Fetches graphical data (svg  strokes) from database
         * according to the caracters present in the request
         * @var Collection $wordsGraphics
         */
        $wordsGraphics = Graphic::query()
            ->select(['character', 'strokes'])
            ->whereIn('character', $singleCharMatches[0])
            ->get();


        // Casting words matches to objects
        foreach ($wordsMatches as $wordMatch) {

            $word = new Word([]);

            /*
             * Adds every caracter separatly in the word with
             * its associated strokes data, if they exists.
             */
            foreach ($this->mbStringToArray($wordMatch) as $char)
                if ($charGraph = $wordsGraphics->firstWhere('character', '===', $char))
                    $word->addDrawable(new Character($charGraph->character, $charGraph->strokes));

            // Prevent empty words to be added
            if ($word->count())
                $words[] = $word;

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
        $template->day = $date ? $date->day : ' ';
        $template->month = $date ? $date->month : ' ';

        // Render and return the template
        WorkingGrid::inlinePrint($template, $words);
    }


    /**
     * Split an multibyte string into an array
     * @param $string
     * @return array
     */
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
