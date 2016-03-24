<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class NewsImagesModel extends ExtendedModel
{
	protected $table = "news_images";
	/**
	 * @param string $instance
	 * @return NewsImagesModel
	 */
	public static function i($instance = "NewsImagesModel")
	{
		return parent::i($instance);
	}

	public function getImagesByMaterialId($materialId)
	{
		$__list = [];

		foreach(parent::getList(["material_id = :material_id"], ["material_id" => $materialId]) as $__id)
			$__list[] = parent::getItem($__id, ["symlink"])["symlink"];

		return $__list;
	}
}
