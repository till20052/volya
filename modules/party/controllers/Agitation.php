<?php

Loader::loadModule("Party");

Loader::loadClass("PagerClass", Loader::SYSTEM);

Loader::loadModel("AgitationsModel");
Loader::loadModel("AgitationsCategoriesModel");

class AgitationPartyController extends PartyController
{
	public function execute()
	{
		parent::execute();
		
		$this->selected = "agitation";
		$this->filter = array();
		
		HeadClass::addLess("/less/frontend/party/agitation.less");
		
		$this->menuClickable = true;
		
		$__cond = ["is_public = :is_public"];
		$__bind = ["is_public" => 1];
		
		$__categoriesIds = array();
		
		$__list = array();
		foreach(AgitationsModel::i()->getList($__cond, $__bind, ["created_at DESC"]) as $__id)
		{
			$__item = AgitationsModel::i()->getItem($__id, ["id", "category_id", "categories_ids"]);
			
			if( ! is_array($__item["categories_ids"]))
				$__item["categories_ids"] = array();
			
			if($__item["category_id"] > 0)
				$__item["categories_ids"] = array_merge($__item["categories_ids"], [$__item["category_id"]]);
			
			unset($__item["category_id"]);
			
			$__categoriesIds = array_merge_recursive($__categoriesIds, array_diff($__item["categories_ids"], $__categoriesIds));
			
			$__list[] = $__item;
		}
		
		$__category = Request::get("category");
		if( ! is_null($__category) && in_array($__category, $__categoriesIds))
		{
			$this->filter["category"] = $__category;
			
			foreach($__list as $__i => $__item)
			{
				if(in_array($__category, $__item["categories_ids"]))
					continue;
				
				unset($__list[$__i]);
			}
			
			$__list = array_values($__list);
		}
		
		$this->pager = new PagerClass($__list, Request::getInt("page"), 12);
		
		$this->list = array();
		foreach($this->pager->getList() as $__item)
			$this->list[] = AgitationsModel::i()->getItem($__item["id"], ["image", "file"]);
		
		$this->categories = array();
		foreach($__categoriesIds as $__id)
		{
			if( ! ($__category = AgitationsCategoriesModel::i()->getItem($__id, ["id", "name"])))
				continue;
			
			$this->categories[] = [
				"id" => $__category["id"],
				"name" => $__category["name"][Router::getLang()]
			];
		}
	}
}
