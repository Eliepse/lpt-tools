<?php


namespace App\Http\Controllers;


use App\Http\Requests\GenerateEnglishGridRequest;
use App\WorkginGrids\EnglishGridLayout;
use App\WorkginGrids\PinyinGridLayout;
use Eliepse\WritingGrid\WordList;
use Mpdf\MpdfException;

/**
 * Class GenerateEnglishGridController
 *
 * @package App\Http\Controllers
 */
class GenerateEnglishGridController
{
	/**
	 * @param GenerateEnglishGridRequest $request
	 *
	 * @throws MpdfException
	 */
	public function __invoke(GenerateEnglishGridRequest $request)
	{
		$words = array_map('trim', explode(',', $request->get('words')));

		$layout = $request->get('pinyin', false) ? new PinyinGridLayout() : new EnglishGridLayout();
		$layout->title = $request->get('title');

		$list = new WordList();

		foreach ($words as $word) {
			$list->addWord($word);
		}

		$layout->render($list);
	}
}