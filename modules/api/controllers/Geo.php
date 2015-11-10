<?php

Loader::loadModule("Api");

Loader::loadClass("GeoClass");

class GeoApiController extends ApiController
{
	public function execute()
	{
		parent::execute();
	}

	public function regions()
	{
		parent::execute();

		$this->json["list"] = GeoClass::i()->regions();

		return true;
	}

	public function region($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["item"] = GeoClass::i()->region($args[0]);

		return true;
	}

	public function cities($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["list"] = GeoClass::i()->cities($args[0]);

		return true;
	}

	public function city($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["item"] = GeoClass::i()->city($args[0]);

		return true;
	}

	public function districts($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["list"] = GeoClass::i()->districts($args[0]);

		return true;
	}

	public function district($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["item"] = GeoClass::i()->district($args[0]);

		return true;
	}

	public function citiesWithDistricts($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["list"] = GeoClass::i()->citiesWithDistricts($args[0]);

		return true;
	}

	public function cityDistricts($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["list"] = GeoClass::i()->cityDistricts($args[0]);

		return true;
	}

	public function cityDistrict($args = [])
	{
		parent::execute();

		if(
			! isset($args[0])
			|| strlen($args[0]) != 10
		)
			return false;

		$this->json["item"] = GeoClass::i()->cityDistrict($args[0]);

		return true;
	}

	public function find($args = [])
	{
		parent::execute();

		$__rand = rand(-999, -1);

		if(
			($__q = stripslashes(Request::getString("q", $__rand))) == strval($__rand)
			|| strlen($__q) < 3
		)
			return false;

		$this->json["list"] = GeoClass::i()->find(
			$__q,
			isset($args[0]) && strlen($args[0]) == 10 ? $args[0] : null
		);

		return true;
	}
}
