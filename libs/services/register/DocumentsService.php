<?php

namespace libs\services\register\documents;

use libs\models\register\documents\CategoriesModel;
use libs\models\register\documents\DocumentsModel;
use libs\models\register\documents\ImagesModel;

\Loader::loadModel("register.documents.CategoriesModel");
\Loader::loadModel("register.documents.DocumentsModel");
\Loader::loadModel("register.documents.ImagesModel");
\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");

class DocumentsService
{

	public function getCategories()
	{
		return CategoriesModel::i()->getCompiledList();
	}

	public function saveCategory($data)
	{
		if(
			! isset($data['id'])
			|| ! CategoriesModel::i()->update($data)
		)
			$data['id'] = CategoriesModel::i()->insert($data);

		return $data['id'];
	}

	public function getCategory($id){
		return CategoriesModel::i()->getItem($id);
	}

	public function removeImages($documentId)
	{
		foreach(ImagesModel::i()->getList(['did = :did'], ['did' => $documentId]) as $id)
			ImagesModel::i()->deleteItem($id);
	}

	public function saveDocument($data)
	{
		$images = [];
		if(isset($data['images']))
		{
			$images = $data['images'];
			unset($data['images']);
		}

		if(
			! isset($data['id'])
			|| ! DocumentsModel::i()->update($data)
		)
			$data['id'] = DocumentsModel::i()->insert($data);

		$this->removeImages($data['id']);

		foreach($images as $image)
			ImagesModel::i()->insert([
				'did' => $data['id'],
				'hash' => $image
			]);

		return $data['id'];
	}

	public function getDocument($id){
		$__item = DocumentsModel::i()->getItem($id);
		$__category = CategoriesModel::i()->getItem($__item["cid"]);
		$__item["title"] = $__category["title"]." №".($__item["number"] != "" ? $__item["number"] : $__item["id"]);
		$__item["images"] = $this->getImages($id);
		return $__item;
	}

	public function getDocuments($minimize = false)
	{
		$__list = [];

		foreach(DocumentsModel::i()->getCompiledList([], [], ["id DESC"]) as $__item)
		{
			$__category = CategoriesModel::i()->getItem($__item["cid"]);
			$__item["title"] = $__category["title"]." №".($__item["number"] != "" ? $__item["number"] : $__item["id"]);

			if( ! $minimize)
			{
				$__item["images"] = $this->getImages($__item["id"]);
				$__list[] = $__item;
			}
			else
				$__list[] = $__item;
		}

		return $__list;
	}

	public function findDocument($number)
	{
		$__list = array();

		foreach(DocumentsModel::i()->getCompiledList(["number LIKE '" . $number . "%'"], [], ["id DESC"]) as $__item)
		{
			$__category = CategoriesModel::i()->getItem($__item["cid"]);
			$__item["title"] = $__category["title"]." №".($__item["number"] != "" ? $__item["number"] : $__item["id"]);

			$__list[] = $__item;
		}

		return $__list;
	}

	public function getImages($did)
	{
		$__list = [];
		foreach(ImagesModel::i()->getCompiledList(['did = :did'], ['did' => $did]) as $image)
			$__list[] = $image["hash"];

		return $__list;
	}
}