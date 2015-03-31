<?php
	//user
	App::singleton('UserService', function()
	{
	    return new UserService;
	});

	App::singleton('CountryService', function()
	{
	    return new CountryService(App::make('CountryRepository'));
	});

	App::singleton('ImageService', function()
	{
	    return new ImageService;
	});

	App::singleton('OeuvreService', function()
	{
	    return new OeuvreService;
	});

	App::singleton('DateService', function()
	{
	    return new DateService();
	});

	App::singleton('BookFromAuthorService', function()
	{
	    return new BookFromAuthorService();
	});

	App::singleton('AuthorService', function()
	{
	    return new AuthorService();
	});

	App::singleton('BookService', function()
	{
	    return new BookService;
	});

	App::singleton('BuyInfoService', function()
	{
	    return new BuyInfoService;
	});

	App::singleton('GiftInfoService', function()
	{
	    return new GiftInfoService;
	});

	App::singleton('CityService', function()
	{
	    return new CityService;
	});

	App::singleton('PublisherSerieService', function()
	{
	    return new PublisherSerieService;
	});


	App::singleton('BookSerieService', function()
	{
	    return new BookSerieService;
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

	App::singleton('CountryRepository', function()
	{
		return new CountryRepository;
	});

	//logger
	App::singleton('Logger', function()
	{
	    return new Katzgrau\KLogger\Logger(app_path().'/storage/logs');
	});

	App::singleton('BookFormValidator', function()
	{
		return new BookFormValidator();
	});