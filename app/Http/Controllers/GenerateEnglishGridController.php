<?php


namespace App\Http\Controllers;


use App\Http\Requests\GenerateEnglishGridRequest;
use App\WorkginGrids\EnglishGridLayout;
use Eliepse\WritingGrid\WordList;

class GenerateEnglishGridController
{
	public function __invoke(GenerateEnglishGridRequest $request)
	{
		$words = array_map('trim', explode(',', $request->get('words')));

		$layout = new EnglishGridLayout();
		$layout->title = $request->get('title');

		$list = new WordList();

		foreach ($words as $word) {
			$list->addWord($word);
		}

		$layout->render($list);
	}
}