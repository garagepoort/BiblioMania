<?php

class OeuvreService {

	public function linkNewOeuvreFromAuthor($author_id, $oeuvreText){
		$titles = explode("\n", $oeuvreText);
        $bookFromAuthorService = App::make('BookFromAuthorService');
        
        foreach ($titles as $title) {
            $res = explode(" - ", $title);
            $bookFromAuthorService->save($author_id, $res[1], $res[0]);
        }

	}
}