<?php

class TagController extends BaseController
{

    /** @var TagJsonMapper $tagJsonMapper */
    private $tagJsonMapper;
    /** @var TagService $tagService */
    private $tagService;

    public function __construct()
    {
        $this->tagJsonMapper = App::make('TagJsonMapper');
        $this->tagService = App::make('TagService');
    }

    public function getTags(){
        return $this->tagJsonMapper->mapArrayToJson($this->tagService->getAllTags());
    }
}