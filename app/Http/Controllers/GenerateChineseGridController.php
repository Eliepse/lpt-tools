<?php


namespace App\Http\Controllers;


use App\Character as CharacterModel;
use App\Graphic;
use App\WorkginGrids\GridTemplate;
use App\WorkginGrids\GridTemplatePinyin;
use App\WorkginGrids\GridTemplateStrokes;
use App\WorkginGrids\GridTemplateStrokesPinyin;
use Carbon\Carbon;
use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\WorkingGrid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GenerateChineseGridController
{
	public function __invoke(Request $request)
	{
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
		 *
		 * @var Collection $charsGraphics
		 */
		$charsGraphics = Graphic::query()
			->select(['character', 'strokes'])
			->whereIn('character', $singleCharMatches[0])
			->get();

		/**
		 * Fetches pinyin from database
		 */
		$charsPinyin = CharacterModel::query()
			->select(['character', 'pinyin'])
			->whereIn('character', $singleCharMatches[0])
			->get();

		// Casting words matches to objects
		foreach ($wordsMatches as $wordMatch) {

			$word = new Word([]);

			/*
			 * Adds every caracter separatly in the word with
			 * its associated strokes data, if they exists.
			 */
			foreach ($this->mbStringToArray($wordMatch) as $char) {
				if ($charGraph = $charsGraphics->firstWhere('character', '===', $char)) {
					$charDictionary = $charsPinyin->firstWhere('character', '===', $char);
					$word->addDrawable(new Character(
						$charGraph->character,
						$charGraph->strokes,
						$charDictionary->pinyin[0] ?? null
					));
				}
			}

			// Prevent empty words to be added
			if ($word->count())
				$words[] = $word;

		}

		// Add empty lines
		for ($i = 0; $i < intval($request->get('emptyLines', 0)); $i++)
			$words[] = new Word([new Character("", [])]);

		// Instanciate the correct template
		if ($request->has('strokes') && $request->has('pinyin')) {

			$template = new GridTemplateStrokesPinyin();

		} else if ($request->has('strokes')) {

			$template = new GridTemplateStrokes();

		} else if ($request->has('pinyin')) {

			$template = new GridTemplatePinyin();

		} else {

			$template = new GridTemplate();

		}

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
	 *
	 * @param $string
	 *
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