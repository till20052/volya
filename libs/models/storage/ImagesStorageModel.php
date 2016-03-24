<?php

Loader::loadModel("StorageModel");

class ImagesStorageModel extends StorageModel
{
	/**
	 * 
	 * @param string $instance
	 * @return ImagesStorageModel
	 */
	public static function i($instance = "ImagesStorageModel")
	{
		return parent::i($instance);
	}
}
