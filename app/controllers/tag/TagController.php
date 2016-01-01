<?php

class TagController extends BaseController
{

    /** @var TagService $tagService */
    private $tagService;

    public function __construct()
    {
        $this->tagService = App::make('TagService');
    }

    public function getTags()
    {
        return array_map(
            function ($item) {
                $tagToJsonAdapter = new TagToJsonAdapter($item);
                return $tagToJsonAdapter->mapToJson();
            },
            $this->tagService->getAllTags()->all());
    }
}