<?php

class UserToJsonAdapter
{

    private $id;
    private $username;
    private $permissions;

    /**
     * UserToJsonAdapter constructor.
     * @param User $user
     */
    public function __construct(User $user, $permissions)
    {
        $this->id = $user->id;
        $this->username = $user->username;
        $this->permissions = $permissions;
    }


    public function mapToJson(){
        return array(
            'id'=> $this->id,
            'username'=> $this->username,
            'permissions'=> $this->permissions
        );
    }
}