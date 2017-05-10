<?php

class TagToElasticMapper
{

	public function mapTags($tags){
		return array_map(function ($tag) {
			return ['id' => intval($tag->id), 'name' => $tag->name];
		}, $tags);
	}
}