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

	App::singleton('AuthorService', function()
	{
	    return new AuthorService;
	});

	App::singleton('ReadingDateService', function()
	{
	    return new ReadingDateService;
	});

	App::singleton('FirstPrintInfoService', function()
	{
	    return new FirstPrintInfoService;
	});

	App::singleton('PersonalBookInfoService', function()
	{
	    return new PersonalBookInfoService;
	});

	App::singleton('PublisherService', function()
	{
	    return new PublisherService;
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