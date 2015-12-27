<?php
//SERVICES
App::singleton('UserService', function () {
    return new UserService;
});

App::singleton('ReadingDateService', function () {
    return new ReadingDateService();
});

App::singleton('CountryService', function () {
    return new CountryService(App::make('CountryRepository'));
});

App::singleton('ImageService', function () {
    return new ImageService;
});

App::singleton('GenreService', function () {
    return new GenreService();
});

App::singleton('OeuvreItemLinkValidator', function () {
    return new OeuvreItemLinkValidator();
});

App::singleton('JsonMappingService', function () {
    return new JsonMappingService();
});

App::singleton('LoggingService', function () {
    return new LoggingService();
});

App::singleton('CurrencyService', function () {
    return new CurrencyService();
});

App::singleton('BookFilterManager', function () {
    return new BookFilterManager();
});

App::singleton('ApiAuthenticationService', function () {
    return new ApiAuthenticationService();
});

App::singleton('TagService', function () {
    return new TagService();
});

App::singleton('OeuvreService', function () {
    return new OeuvreService;
});

App::singleton('DateService', function () {
    return new DateService();
});

App::singleton('BookFromAuthorService', function () {
    return new BookFromAuthorService();
});

App::singleton('AuthorService', function () {
    return new AuthorService();
});

App::singleton('BookService', function () {
    return new BookService;
});

App::singleton('BuyInfoService', function () {
    return new BuyInfoService;
});

App::singleton('GiftInfoService', function () {
    return new GiftInfoService;
});

App::singleton('CityService', function () {
    return new CityService;
});

App::singleton('PublisherSerieService', function () {
    return new PublisherSerieService;
});

App::singleton('BookSerieService', function () {
    return new BookSerieService;
});

App::singleton('ReadingDateService', function () {
    return new ReadingDateService;
});

App::singleton('FirstPrintInfoService', function () {
    return new FirstPrintInfoService;
});

App::singleton('FirstPrintInfoRepository', function () {
    return new FirstPrintInfoRepository();
});

App::singleton('PersonalBookInfoService', function () {
    return new PersonalBookInfoService;
});

App::singleton('PublisherService', function () {
    return new PublisherService();
});

App::singleton('LanguageService', function () {
    return new LanguageService;
});

App::singleton('StatisticsService', function () {
    return new StatisticsService();
});

App::singleton('AdminService', function () {
    return new AdminService();
});

App::singleton('DateImporter', function () {
    return new DateImporter();
});

App::singleton('ImportFileMapper', function () {
    return new ImportFileMapper();
});

App::singleton('SpriteCreator', function () {
    return new SpriteCreator();
});

App::singleton('FilterHistoryService', function () {
    return new FilterHistoryService();
});


//logger
App::singleton('Logger', function () {
    return new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
});

App::singleton('BookFormValidator', function () {
    return new BookFormValidator();
});

App::singleton('AuthorFormValidator', function () {
    return new AuthorFormValidator();
});

App::singleton('FileToAuthorParametersMapper', function () {
    return new FileToAuthorParametersMapper();
});

App::singleton('FileToBookParametersMapper', function () {
    return new FileToBookParametersMapper();
});

App::singleton('FileToFirstPrintParametersMapper', function () {
    return new FileToFirstPrintParametersMapper();
});

App::singleton('FileToBuyInfoParametersMapper', function () {
    return new FileToBuyInfoParametersMapper();
});

App::singleton('FileToGiftInfoParametersMapper', function () {
    return new FileToGiftInfoParametersMapper();
});

App::singleton('FileToExtraBookInfoParametersMapper', function () {
    return new FileToExtraBookInfoParametersMapper();
});

App::singleton('FileToPersonalBookInfoParametersMapper', function () {
    return new FileToPersonalBookInfoParametersMapper();
});

App::singleton('FileToCoverInfoParametersMapper', function () {
    return new FileToCoverInfoParametersMapper();
});

App::singleton('FileToOeuvreParametersMapper', function () {
    return new FileToOeuvreParametersMapper();
});


//REPOSITORIES

App::singleton('BookRepository', function () {
    return new BookRepository();
});
App::singleton('ReadingDateRepository', function () {
    return new ReadingDateRepository();
});

App::singleton('PersonalBookInfoRepository', function () {
    return new PersonalBookInfoRepository();
});

App::singleton('UserRepository', function () {
    return new UserRepository();
});

App::singleton('CountryRepository', function () {
    return new CountryRepository();
});

App::singleton('AuthorRepository', function () {
    return new AuthorRepository();
});

App::singleton('BookFromAuthorRepository', function () {
    return new BookFromAuthorRepository();
});

App::singleton('PublisherRepository', function () {
    return new PublisherRepository();
});

App::singleton('LanguageRepository', function () {
    return new LanguageRepository();
});

App::singleton('StatisticsRepository', function () {
    return new StatisticsRepository();
});
