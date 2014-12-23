<?php 

class AuthorService {

	public function saveOrUpdate($name, $infix, $firstname, $authorImage = null, $date_of_birth = null, $date_of_death = null){
		$author_model = Author::where('name', '=', $name)
                ->where('firstname', '=', $firstname)
                ->where('infix', '=', $infix)
	            ->first();

        if (is_null($author_model)) {
            	$author_model = new Author();
        }
        
        $author_model->name = $name;
        $author_model->firstname = $firstname;
        $author_model->infix = $infix;
        $author_model->date_of_birth = $date_of_birth;
        $author_model->date_of_death = $date_of_death;
        $author_model->image = $authorImage;
    	
    	$author_model->save();
        return $author_model;
	}
}