<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadModel("GeoModel");

class GeoClass1 extends ExtendedClass
{
	private $__lang = "ua";
	private $__collator;
	private $__normilizationRules = [
		[
			// області
			'pattern' => '[0-7][1-9]0{8}',
			'type' => 'region'
		],
		[
			'pattern' => [
				// міста зі особливим статусом
				'(80|85)0{8}',
				// міста обласного підпорядкування
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])0{5}',
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])6(0[1-9]|[1-4][1-9])0{2}',
				// міста районного підпорядкування
				'[0-7][1-9]2(0[1-9]|[1-9][0-9])1(0[1-9]|[1-9][0-9])0{2}',
				// міста, що входять до складу міськради
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])7(0[1-9]|[1-9][0-9])0{2}',

				'853(0[1-9]|[1-9][0-9])1(0[1-9]|[1-9][0-9])0{2}'
			],
			'type' => 'city',
			'prefix' => 'м. ',
			'postfix' => ''
		],
		[
			'pattern' => [
				// райони в містах обласного підпорядкування;
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])3(0[1-9]|[1-9][0-9])0{2}',
				// райони міст, що мають спеціальний статус
				'(80|85)3(0[1-9]|[1-9][0-9])0{5}'
			],
			'type' => 'city_district',
			'postfix' => ' район'
		],
		[
			// райони АР Крим, області
			'pattern' => '[0-7][1-9]2(0[1-9]|[1-9][0-9])0{5}',
			'type' => 'district'
		],
		[
			'pattern' => [
				// селища міського типу, що входять до складу міськради
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])4(0[1-9]|[1-4][0-9]|5[1-9]|[6-9][0-9])0{2}',
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])6([5-9][1-9])0{2}',
				'14135670{3}',
				'[0-7][1-9]2(0[1-9]|[1-9][0-9])4(5[1-9])0{2}',
				// селища міського типу, що входять до складу райради
				'[0-7][1-9]2(0[1-9]|[1-9][0-9])5(5[1-9]|[6-9][0-9])0{2}',
				'853(0[1-9]|[1-9][0-9])6(5[1-9]|[6-9][0-9])0{2}'
			],
			'type' => 'urban_village',
			'prefix' => 'смт. '
		],
		[
			'pattern' => [
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])4(0[1-9]|[1-4][0-9]|5[1-9]|[6-9][0-9])(0[1-9]|[1-9][0-9])',
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])6(0[1-9]|[1-4][1-9])(0[1-9]|[1-9][0-9])',
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])6([5-9][1-9])(0[1-9]|[1-9][0-9])',
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])7(0[1-9]|[1-9][0-9])(0[1-9]|[1-9][0-9])',
				// села, що входять до складу райради міста, міськради
				'[0-7][1-9]1(0[1-9]|[1-9][0-9])9[0-9]{2}(0[1-9]|[1-9][0-9])',

				'[0-7][1-9]2(0[1-9]|[1-9][0-9])1(0[1-9]|[1-9][0-9])(0[1-9]|[1-9][0-9])',
				'[0-7][1-9]2(0[1-9]|[1-9][0-9])5(5[1-9]|[6-9][0-9])(0[1-9]|[1-9][0-9])',
				// села, що входять до складу райради
				'[0-7][1-9]2(0[1-9]|[1-9][0-9])8[0-9]{2}(0[1-9]|[1-9][0-9])',

				'853(0[1-9]|[1-9][0-9])6[0-9]{2}(0[1-9]|[1-9][0-9])',
				'853(0[1-9]|[1-9][0-9])9(0[1-9]|[1-9][0-9])(0[1-9]|[1-9][0-9])'
			],
			'type' => 'village',
			'prefix' => 'с. '
		],
		[
			'pattern' => '(.*)'
		]
	];

	private function __compareById($item1, $item2)
	{
		return $this->__collator->compare($item1["id"], $item2["id"]);
	}

	private function __compareByTitle($item1, $item2)
	{
		return $this->__collator->compare($item1["title"], $item2["title"]);
	}

	private function __normalizeItem($item)
	{
		$__title = [];
		foreach(preg_split('/\s+/u', $item["title"]) as $__token)
		{
			$__mode = MB_CASE_TITLE;

			if(in_array($__token, ['ОБЛАСТЬ', 'РАЙОН']))
				$__mode = MB_CASE_LOWER;

			$__title[] = mb_convert_case($__token, $__mode, 'UTF-8');
		}

		foreach($this->__normilizationRules as $__rule)
		{
			$__flag = false;

			if( ! is_array($__rule['pattern']))
				$__rule['pattern'] = [$__rule['pattern']];

			foreach($__rule['pattern'] as $__pattern)
			{
				if( ! preg_match('/'.$__pattern.'/', $item["id"]))
					continue;

				$__flag = true;
				break;
			}

			if($__flag)
				break;
		}

		$__item = [
			'id' => $item['id'],
			'title' => (isset($__rule["prefix"]) ? $__rule["prefix"] : '')
				. implode(' ', $__title)
				. (isset($__rule["postfix"]) ? $__rule["postfix"] : '')
		];

		if(isset($__rule['type']))
			$__item['type'] = $__rule['type'];

		return $__item;
	}

	private function __getPatternByType($type)
	{
		foreach($this->__normilizationRules as $__rule)
		{
			if($__rule["type"] != $type)
				continue;

			if( ! is_array($__rule['pattern']))
				$__rule['pattern'] = [$__rule['pattern']];

			return $__rule['pattern'];
		}

		return false;
	}

	private function __isCodeMatched($code, $type)
	{
		foreach($this->__getPatternByType($type) as $__pattern)
		{
			if( ! preg_match('/'.$__pattern.'/', $code))
				continue;

			return true;
		}

		return false;
	}

	private function __getItem($cond)
	{
		if(count(($__list = GeoModel::i()->getList($cond, [], [], 1))) != 1)
			return false;

		$__item = $this->__normalizeItem(GeoModel::i()->getItem($__list[0], [
			"code AS id",
			"title_".$this->__lang." AS title"
		], ["id", "title"]));

		return $__item;
	}

	private function __getList($cond, $options = [])
	{
		$__list = [];

		$__tokens = GeoModel::i()->getList($cond, [], ["id ASC"]);

		if(isset($options['return']))
		{
			if($options['return'] == 'count')
				return count($__tokens);
		}

		foreach($__tokens as $__id)
			$__list[] = GeoModel::i()->getItem($__id, [
				"code AS id",
				"title_".$this->__lang." AS title"
			]);

		usort($__list, [$this, isset($options['sortBy']) && in_array(strtolower($options['sortBy']), ['id', 'title'])
			? '__compareBy'.ucfirst($options['sortBy'])
			: '__compareByTitle']);

		foreach($__list as $__i => $__item)
			$__list[$__i] = $this->__normalizeItem($__item);

		return array_values($__list);
	}
	
	/**
	 * @param string $instance
	 * @return GeoClass1
	 */
	public static function i($instance = "GeoClass1")
	{
		return parent::i($instance);
	}

	public function __construct()
	{
		$this->__collator = new Collator("uk_UA");
	}
	
	public function regions()
	{
		return $this->__getList(["code REGEXP '[0-9]{2}0{8}'"]);
	}
	
	public function region($code)
	{
		if( ! $this->__isCodeMatched($code, 'region'))
			return false;

		return $this->__getItem([
			"code REGEXP '".substr($code, 0, 2)."0{8}'"
		]);
	}

	public function districts($code)
	{
		return $this->__getList([
			"code REGEXP '".substr($code, 0, 2)."2(0[1-9]|[1-9][0-9])0{5}'"
		]);
	}

	public function district($code)
	{
		if( ! $this->__isCodeMatched($code, 'district'))
			return false;

		return $this->__getItem([
			"code REGEXP '".substr($code, 0, 5)."0{5}'"
		]);
	}

	public function cities($code)
	{
		$__code = substr($code, 0, 2)."1(0[1-9]|[1-9][0-9])0{5}";

		if(preg_match("/[0-9]{2}2[0-9]{2}1[0-9]{4}/", $code))
			$__code = substr($code, 0, 5)."1(0[1-9]|[1-9][0-9])0{2}";

		return $this->__getList(["code REGEXP '".$__code."'"]);
	}

	public function city($code)
	{
		if( ! $this->__isCodeMatched($code, 'city'))
			return false;

		$__code = substr($code, 0, 5)."0{5}";

		if(
			preg_match('/[0-7][1-9]2(0[1-9]|[1-9][0-9])1(0[1-9]|[1-9][0-9])0{2}/', $code)
			|| preg_match('/[0-9]{2}3(0[1-9]|[1-9][0-9])1(0[1-9]|[1-9][0-9])0{2}/', $code)
		)
			$__code = substr($code, 0, 8)."0{2}";
		elseif(preg_match('/(80|85)0{8}/', $code))
			$__code = substr($code, 0, 2)."0{8}";

		return $this->__getItem([
			"code REGEXP '".$__code."'"
		]);
	}

	public function citiesWithDistricts($code)
	{
		return $this->__getList([
			"code REGEXP '".substr($code, 0, 2)."[1-2](0[1-9]|[1-9][0-9])0{5}'"
		]);
	}

	public function cityDistricts($code, $options = [])
	{
		if(strlen(rtrim($code, 0)) > 5)
			return [];

		$__code = substr($code, 0, 5)."3(0[1-9]|[1-9][0-9])0{2}";

		if(preg_match('/(80|85)[0-9]{8}/', $code))
			$__code = substr($code, 0, 2)."3(0[1-9]|[1-9][0-9])0{5}";

		return $this->__getList([
			"code REGEXP '".$__code."'"
		], $options);
	}

	public function cityDistrict($code)
	{
		if( ! $this->__isCodeMatched($code, 'city_district'))
			return false;

		$__code = substr($code, 0, 8)."0{2}";

		if(preg_match('/(80|85)[0-9]{8}/', $code))
			$__code = substr($code, 0, 5)."0{5}";

		return $this->__getItem([
			"code REGEXP '".$__code."'"
		]);
	}

	public function urbanVillage($code)
	{
		if( ! $this->__isCodeMatched($code, 'urban_village'))
			return false;

		return $this->__getItem([
			"code REGEXP '".substr($code, 0, 8)."0{2}'"
		]);
	}

	public function village($code)
	{
		if( ! $this->__isCodeMatched($code, 'village'))
			return false;

		return $this->__getItem([
			"code REGEXP '".$code."'"
		]);
	}

	public function find($q, $code = null)
	{
		$__or = [];
		$__list = [];

		foreach($this->__normilizationRules as $__rule)
		{
			if(
				! isset($__rule['type'])
				|| ! in_array($__rule['type'], ['city', 'urban_village', 'village'])
			)
				continue;

			if( ! is_array($__rule['pattern']))
				$__rule['pattern'] = [$__rule['pattern']];

			foreach($__rule['pattern'] as $__pattern)
				$__or[] = "code REGEXP '".$__pattern."'";
		}

		$__cond = [
			'OR' => $__or,
			"title_".$this->__lang." LIKE '%{$q}%'"
		];

		if( ! is_null($code))
		{
			if(preg_match('/[0-9]{2}0{8}/', $code))
				$__cond[] = "code REGEXP '".substr($code, 0, 2)."[0-9]{8}'";
			elseif(preg_match('/[0-9]{2}[1-3](0[1-9]|[1-9][0-9])0{5}/', $code))
				$__cond[] = "code REGEXP '".substr($code, 0, 5)."[0-9]{5}'";
		}

		foreach($this->__getList($__cond, ['sortBy' => 'id']) as $__item){
			$__html = $__item["title"];

			if(($__fp = strpos(mb_strtolower($__html, 'UTF-8'), mb_strtolower($q, 'UTF-8'))) > 0)
				$__html = substr($__html, 0, $__fp)
					.'<span>'.substr($__html, $__fp, strlen($q)).'</span>'
					.substr($__html, $__fp + strlen($q));

			if(($__region = $this->region(substr($__item['id'], 0, 2).str_repeat('0', 8))) != false)
				$__item['region'] = $__region['title'];

			if(($__district = $this->district(substr($__item['id'], 0, 5).str_repeat('0', 5))) != false)
				$__item['district'] = $__district['title'];

			if(
				$__item['type'] != 'city'
				&& ($__city = $this->city(substr($__item['id'], 0, 5).str_repeat('0', 5))) != false
			)
				$__item['city'] = $__city['title'];

			$__list[] = $__item + [
				"html" => $__html
			];
		}

		return $__list;
	}

	public function location($code, $option = [])
	{
		$__item = ['location' => ''];
		$__tokens = [];
		$__patterns = [
			'type' => '/(\:type)/',
			'id' => '/(\:id)/'
		];

		// region, city with special value
		if(
			($__token = $this->region(substr($code, 0, 2).str_repeat('0', 8))) != false
			|| ($__token = $this->city(substr($code, 0, 2).str_repeat('0', 8))) != false
		)
			$__tokens[] = $__token;

		// city, district,
		if(
			($__token = $this->city(substr($code, 0, 5).str_repeat('0', 5))) != false
			|| ($__token = $this->district(substr($code, 0, 5).str_repeat('0', 5))) != false
		){
			$__flag = true;

			foreach($__tokens as $__tmp)
			{
				if($__tmp['id'] != $__token['id'])
					continue;

				$__flag = false;
				break;
			}

			if($__flag)
				$__tokens[] = $__token;
		}

		// district in city, urban village, village
		if(
			($__token = $this->village($code)) != false
			|| ($__token = $this->city(substr($code, 0, 8).str_repeat('0', 2))) != false
			|| ($__token = $this->urbanVillage(substr($code, 0, 8).str_repeat('0', 2))) != false
			|| ($__token = $this->cityDistrict(substr($code, 0, 8).str_repeat('0', 2))) != false
		){
			$__flag = true;

			foreach($__tokens as $__tmp)
			{
				if($__tmp['id'] != $__token['id'])
					continue;

				$__flag = false;
				break;
			}

			if($__flag)
				$__tokens[] = $__token;
		}

		foreach($__tokens as $__token)
		{
			$__item[$__token["type"]] = $__token;

			$__replacementValues = [];
			foreach(array_keys($__patterns) as $__key)
				$__replacementValues[] = $__token[$__key];

			if(isset($option['locationUrlPattern']))
				$__item["location"][] = "<a href=\""
					.preg_replace(array_values($__patterns), $__replacementValues, $option['locationUrlPattern'])
					."\">".$__token["title"]."</a>";
			else
				$__item["location"][] = $__token["title"];
		}

		$__item["location"] = implode((isset($option['locationSplitter'])
			? $option['locationSplitter']
			: ' / '), $__item["location"]);

		return $__item;
	}
}
