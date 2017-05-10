<?php

namespace e2e\datasetbuilders;

class CreateUserRequestBuilder implements \CreateUserRequest
{

    private $username;
    private $password;
    private $email;

    function getUsername()
    {
        return $this->username;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getEmail()
    {
        return $this->email;
    }

    public function withUsername($username)
    {
        $this->username = $username;
        return $this;
    }


    public function withEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function withPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public static function buildDefault(){
        $createUserRequest = new CreateUserRequestBuilder();
        $createUserRequest
            ->withUsername('testUser')
            ->withEmail('test@test.be')
            ->withPassword('test');
        return $createUserRequest;
    }
}
