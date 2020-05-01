<?php

namespace App\Http\Controllers\Api;

use App\Character;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Class PrepareGridCNController
 *
 * @package App\Http\Controllers\Api
 */
final class PrepareGridCNController
{
	private string $uid;
	private Collection $words;
	private string $title;
	private ?Carbon $date;
	private array $options;
	private string $hanFilter = '/[^\p{Han}]/u';
	private string $pinyinFilter = '/[^ a-z0-9üāēīōūǖáéíóúǘǎěǐǒǔǚàèìòùǜ]/i';


	/**
	 * Prepare the grid by caching words attributes (except vectors paths),
	 * layout options and others needed data. Then it returns a url to the
	 * user, that leads to the the actual generation of the grid.
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function __invoke(Request $request)
	{
		$this->uid = Str::random(8);
		$this->title = "LPT 三语宝贝" . $request->get('title', " ");
		$this->date = !empty($date = $request->get('date')) ? Carbon::createFromFormat('Y-m-d', $date) : null;
		$this->options = [
			"columns_amount" => intval($request->get('columns', 9)),
			"additional_lines" => intval($request->get('emptyLines', 0)),
			"model_amount" => intval($request->get('models', 3)),
			"with_strokes" => boolval($request->get('strokes', false)),
			"with_pinyin" => boolval($request->get('pinyin', false)),
		];

		// Prepare words
		$processingWords = $this->sanitizeAndSplitWords($request->get('words', []));
		$dictionary = $this->fetchDefinitions($processingWords->pluck("hans")->flatten(1)->unique());
		$this->words = $this->combinePinyin($processingWords, $dictionary);

		$this->cachePreparedData();

		return response()->json(["url" => route("exercice.chinese-grid.pdf", $this->uid)]);
	}


	/**
	 * Sanitize values of each given word and split them into an array of characters
	 *
	 * @param array $words
	 *
	 * @return Collection
	 */
	private function sanitizeAndSplitWords(array $words): Collection
	{
		return collect(array_map(
			function ($word) {
				return [
					"hans" => mb_str_split(preg_replace($this->hanFilter, "", $word["value"]), 1),
					"pinyins" => mb_split("\s+", preg_replace($this->pinyinFilter, "", $word["pinyin"] ?? "")),
				];
			},
			$words
		));
	}


	/**
	 * Fetch definitions for the chinese characters used in the given words
	 *
	 * @param Collection $characters
	 *
	 * @return EloquentCollection
	 */
	private function fetchDefinitions(Collection $characters): EloquentCollection
	{
		return Character::query()
			->select(['character', 'pinyin'])
			->whereIn('character', $characters)
			->get();
	}


	/**
	 * Remap each word to be an array of associated han and pinyin.
	 * A single word, ends up with this structure:
	 * [
	 *   ["han" => "下", "pinyin" => "xià"],
	 *   ["han" => "雨", "pinyin" => "yǔ"]
	 * ]
	 *
	 * @param Collection $words
	 * @param EloquentCollection $dictionary
	 *
	 * @return Collection
	 */
	private function combinePinyin(Collection $words, EloquentCollection $dictionary): Collection
	{
		return $words->map(function (array $word) use ($dictionary) {
			$characters = [];
			foreach ($word["hans"] as $key => $han) {
				// Try to find the character definition if no pinyin has been provided
				if (empty($pinyin = $word["pinyins"][ $key ] ?? null)) {
					$pinyin = optional($dictionary->firstWhere("character", $han))->pinyin[0] ?? null;
				}
				$characters[] = ["han" => $han, "pinyin" => $pinyin,];
			}
			return $characters;
		});
	}


	/**
	 * Add the prepared grid attributes to the cache
	 *
	 * @return bool
	 */
	private function cachePreparedData(): bool
	{
		return Cache::put(
			"exercice.prepared." . $this->uid,
			[
				"title" => $this->title,
				"date" => $this->date,
				"options" => $this->options,
				"words" => $this->words,
			],
			CarbonInterval::minutes(15)
		);
	}
}