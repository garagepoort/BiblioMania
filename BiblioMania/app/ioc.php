<?php
	//user
	App::singleton('UserService', function()
	{
	    return new UserService;
	});

	App::singleton('CountryService', function()
	{
	    return new CountryService;
	});

	App::singleton('LanguageService', function()
	{
	    return new LanguageService;
	});

	App::singleton('UserRepository', function()
	{
	    return new UserRepository;
	});

	//logger
	App::singleton('Logger', function()
	{
	    return new Katzgrau\KLogger\Logger(app_path().'/storage/logs');
	});