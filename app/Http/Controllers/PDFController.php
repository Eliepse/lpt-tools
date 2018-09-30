<?php

namespace App\Http\Controllers;

use App\Graphic;
use Eliepse\Character;
use Eliepse\PDFWorkingGrid;
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
            'title'      => 'required|string|nullable|max:50',
            'characters' => 'required|string|min:1',
            'strokeHelp' => 'sometimes|boolean',
            'columns'    => 'required|int|min:6|max:20',
//            'lines'      => 'required|int|min:6|max:20',
            'models'     => 'required|int|min:0|max:20',
        ]);


        $characters = $this->mbStringToArray($request->get('characters'));

        /** @var Collection $graph */
        /** @noinspection PhpUndefinedMethodInspection */
        $graph = Graphic::select(['character', 'strokes'])
            ->whereIn('character', $characters)
            ->get();

        $grid = new PDFWorkingGrid(
            $request->get('title'),
            $request->get('strokeHelp', false),
            $request->get('columns', 9),
            $request->get('lines', null)
        );

        $grid->setModels($request->get('models', 3));

//        $graph->whereIn('character', $characters, true)

        foreach ($characters as $character) {

            if ($graphic = $graph->firstWhere('character', '===', $character)) {

                $grid->addCharacter(new Character($graphic->character, $graphic->strokes));

            }


        }

        $grid->output();

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
