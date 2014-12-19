<?php 

class AuthorService {

	public function saveOrUpdate($name, $firstname, $date_of_birth, $date_of_death){
		$author_model = Author::where('name', '=', $name)
                ->where('firstname', '=', $firstname)
	            ->where('user_id', '=', Auth::user()->id)
	            ->first();

        if (is_null($author_model)) {
            	$author_model = new Author();
        }
        
        $author_model->name = $name;
        $author_model->firstname = $firstname;
        $author_model->date_of_birth = $date_of_birth;
        $author_model->date_of_death = $date_of_death;
        $author_model->user_id = Auth::user()->id;
    	
    	$author_model->save();
        return $author_model;
	}
}