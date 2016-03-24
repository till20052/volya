<?php

Loader::loadModule("S");
Loader::loadModel("ExtendedModel", Loader::SYSTEM);
Loader::loadModel("UsersModel");
Loader::loadClass("OldGeoClass");

class UsersSController extends SController
{
	public function execute()
	{
		parent::execute();
		parent::setViewer(null);
	}
	
	public function geoRestructuring()
	{
		parent::execute();
		parent::setViewer(null);
		
		$__conn = array(
			"Белая Церковь" => "Біла церква",
			"Берегово" => "Берегове",
			"Борисполь" => "Бориспіль",
			"Бровары" => "Бровари",
			"Брошнев" => "Брошнів",
			"Бурлацкая Балка",
			"Винница" => "Вінниця",
			"Вишневое" => "Вишневе",
			"Волочиск" => "Волочиськ",
			"Вороблевичи" => "Вороблевичі",
			"Вышгород" => "Вишгород",
			"Гавриловка" => "Гаврилівка",
			"Гута станція",
			"Днепропетровск" => "Дніпропетровськ",
			"Донецк" => "Донецьк",
			"Дрогобыч" => "Дрогобич",
			"Емильчино" => "Ємільчине",
			"Жидачов" => "Жидачів",
			"Запорожье" => "Запоріжжя",
			"Заречье" => "Заріччя",
			"Иванков" => "Іванків",
			"Клавдиево-Тарасово" => "Клавдієво-Тарасове",
			"Красная",
			"Кременчуг" => "Кременчук",
			"Кривой Рог" => "Кривий ріг",
			"Лановцы" => "Ланівці",
			"Луцк" => "Луцьк",
			"Львов" => "Львів",
			"Макаров" => "Макарів",
			"Мироновка" => "Миронівка",
			"Молодежное" => "Молодіжне",
			"Молодков" => "Молодків",
			"Морянцы",
			"Надворная" => "Надвірна",
			"Назавизов" => "Назавизів",
			"Наконечное Второе" => "Наконечне Друге",
			"Наконечное Первое" => "Наконечне Перше",
			"Николаев" => "Миколаїв",
			"Обухов" => "Обухів",
			"Одесса" => "Одеса",
			"Пасечная" => "Пасічна",
			"Перегинское" => "Перегінське",
			"Переяслав-Хмельницкий",
			"Песковка" => "Пісківка",
			"Пнев" => "Пнів",
			"Припять" => "Прип'ять",
			"Раздельная" => "Роздільна",
			"Реклинец" => "Реклинець",
			"Светловодск" => "Світловодськ",
			"Селец" => "Селець",
			"Славське" => "Славсько",
			"Старый Самбор" => "Старий Самбір",
			"Стрый" => "Стрий",
			"Сумы" => "Суми",
			"Тетиев" => "Тетіїв",
			"Фастов" => "Фастів",
			"Харьков" => "Харків",
			"Хмельницкий" => "Хмельницький",
			"Циркуны" => "Циркуни",
			"Цюрупинск" => "Цюрупинськ",
			"Чернигов" => "Чернігів",
			"Черновцы" => "Чернівці",
			"Черняхов" => "Черняхів",
			"Чкалово" => "Чкалове",
			"Яворов" => "Яворів",
			"Ямполь" => "Ямпіль",
			"Ярмолинцы" => "Ярмолинці"
		);
		
		foreach(UsersModel::i()->getList(["geo_koatuu_code IS NULL"], [], [], 10) as $__id)
		{
			$__user = UsersModel::i()->getItem($__id, array(
				"id",
				"region_id",
				"region_name",
				"area_id",
				"area_name",
				"city_id",
				"city_name",
				"street",
				"house_number"
			));
			
			if(isset($__conn[$__user["city_name"]]))
				$__user["city_name"] = $__conn[$__user["city_name"]];
			
			$__token = [];
			foreach(["region_name", "area_name", "city_name", "house_number"] as $__field)
			{
				if($__user[$__field] == "")
					continue;
				
				$__token[] = $__user[$__field];
			}
			
			$__geocoding = array(
				"forward" => json_decode(file_get_contents("http://geocode-maps.yandex.ru/1.x/?geocode=".urlencode(implode(", ", $__token))."&format=json&lang=uk_UA&results=1"), true)
			);
			
			$__geocoding["reverse"] = json_decode(file_get_contents("http://geocode-maps.yandex.ru/1.x/?geocode=".str_replace(" ", ",",$__geocoding["forward"]["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"])."&format=json&kind=district&lang=uk_UA&results=1"), true);
			if( ! (count($__geocoding["reverse"]["response"]["GeoObjectCollection"]["featureMember"]) > 0))
				$__geocoding["reverse"] = json_decode(file_get_contents("http://geocode-maps.yandex.ru/1.x/?geocode=".str_replace(" ", ",",$__geocoding["forward"]["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"])."&format=json&kind=locality&lang=uk_UA&results=1"), true);
			
			$__name = $__geocoding["reverse"]["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["name"];
			$__name = str_replace(array(" район", "село ", "селище ", "міського типу "), "", $__name);
			
			$__cities = OldGeoClass::i()->findCities($__name, null, $__user["region_name"]);
			if( ! (count($__cities) > 0))
			{
				$__name = $__geocoding["forward"]["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["name"];
				$__name = str_replace(array(" район", "село ", "селище ", "міського типу "), "", $__name);
				
				$__cities = OldGeoClass::i()->findCities($__name, null, $__user["region_name"]);
			}
			
			if( ! (count($__cities) > 0))
				Console::log(
						$__user,
						$__geocoding["forward"]["response"]["GeoObjectCollection"]["featureMember"],
						$__geocoding["reverse"]["response"]["GeoObjectCollection"]["featureMember"],
						$__cities,
						str_repeat("-", 80)
				);
			else
			{
				Console::log($__user, $__cities, str_repeat("-", 80));
				UsersModel::i()->update(array(
					"id" => $__user["id"],
					"geo_koatuu_code" => $__cities[0]["id"]
				));
			}
			
			usleep(100000);
		}
	}
}
