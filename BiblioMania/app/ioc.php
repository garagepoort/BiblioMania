<?php
	//user
	App::singleton('UserService', function()
	{
	    return new UserService;
	});

	App::singleton('UserRepository', function()
	{
	    return new UserRepository;
	});