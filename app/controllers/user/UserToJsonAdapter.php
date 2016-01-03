<?php

class UserToJsonAdapter
{

    private $id;
    private $username;

    /**
     * UserToJsonAdapter constructor.
     */
    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->username = $user->username;
    }


    public function mapToJson(){
        return array(
            'id'=> $this->id,
            'username'=> $this->username
        );
    }
}