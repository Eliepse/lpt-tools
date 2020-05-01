<?php /** @noinspection PhpPrivateFieldCanBeLocalVariableInspection */

namespace App\Http\Controllers;

use App\Graphic;
use App\WorkginGrids\GridTemplate;
use App\WorkginGrids\GridTemplatePinyin;
use App\WorkginGrids\GridTemplateStrokes;
use App\WorkginGrids\GridTemplateStrokesPinyin;
use Carbon\Carbon;
use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\WorkingGrid;
use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class GenerateChineseGridController
 *
 * @package App\Http\Controllers
 */
class GenerateChineseGridController
{
	private Collection $words;
	private string $title;
	private ?Carbon $date;
	private array $options;
	private EloquentCollection $shapesDictionary;


	/**
	 * Load prepared data from cache and generate the exercice
	 *
	 * @param Request $request
	 * @param string $uid
	 *
	 * @throws HttpException
	 */
	public function __invoke(Request $request, string $uid)
	{
		if (Cache::missing("exercice.$uid")) {
			throw new HttpException(410, "This exercice is undefined or expired, please generate a new one.");
		}

		$cache = Cache::get("exercice.$uid");
		$this->words = $cache["words"];
		$this->title = $cache["title"];
		$this->date = $cache["date"];
		$this->options = $cache["options"];

		$this->fetchShapesDictionary($this->words->pluck("*.han")->flatten(1)->unique());

		$drawables = [
			...$this->mapCacheToDrawableWords(),
			...$this->getAdditionalLinesAsDrawables(),
		];

		$template = $this->getTemplate();
		$this->configureTemplate($template);

//		dd($this->getAdditionalLinesAsDrawables());

		// Render and return the template
		WorkingGrid::inlinePrint($template, $drawables);
	}


	/**
	 * @param Collection $characters
	 *
	 * @return void
	 */
	private function fetchShapesDictionary(Collection $characters): void
	{
		$this->shapesDictionary = Graphic::query()
			->select(['character', 'strokes'])
			->whereIn('character', $characters)
			->get();
	}


	/**
	 * Convert words from cache to drawable objects.
	 *
	 * @return array
	 */
	private function mapCacheToDrawableWords(): array
	{
		return $this->words->map(fn($word) => $this->mapToWord($word))->filter()->toArray();
	}


	/**
	 * Transfor a character from cache to a drawable character.
	 * If the character is not present in the Graphics database, null is returned.
	 *
	 * @param array $word
	 *
	 * @return Word|null
	 */
	private function mapToWord(array $word): ?Word
	{
		$characters = array_filter(array_map(function ($character) {
			["han" => $han, "pinyin" => $pinyin] = $character;
			/** @var Graphic $shape */
			$shape = $this->shapesDictionary->firstWhere("character", $han);
			return !empty($shape) ? new Character($han, $shape->strokes, $pinyin) : null;
		}, $word));
		return !empty($characters) ? new Word($characters) : null;
	}


	/**
	 * @return array
	 */
	private function getAdditionalLinesAsDrawables(): array
	{
		$emptyWord = new Word([new Character("", [], " ")]);
		return array_fill(0, $this->options["additional_lines"], $emptyWord);
	}


	/**
	 * @return GridTemplate|GridTemplatePinyin|GridTemplateStrokes|GridTemplateStrokesPinyin
	 */
	private function getTemplate(): GridTemplate
	{
		["with_pinyin" => $w_pinyin, "with_strokes" => $w_strokes] = $this->options;

		if ($w_pinyin && $w_strokes) {
			return new GridTemplateStrokesPinyin();
		}

		if ($w_strokes) {
			return new GridTemplateStrokes();
		}

		if ($w_pinyin) {
			return new GridTemplatePinyin();
		}

		return new GridTemplate();
	}


	/**
	 * @param GridTemplate $template
	 */
	private function configureTemplate(GridTemplate $template): void
	{
		$template->title = $this->title;
		$template->columns_amount = $this->options["columns_amount"];
//		$template->row_max = $this->options["row_max"];
		$template->model_amount = $this->options["model_amount"];
		$template->day = $this->date->day ?? ' ';
		$template->month = $this->date->month ?? ' ';
	}
}