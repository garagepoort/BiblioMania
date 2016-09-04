<?php

namespace App\Providers;

use ApiAuthenticationService;
use AuthorFormValidator;
use AuthorRepository;
use AuthorService;
use BookElasticIndexer;
use BookFilterManager;
use BookFormValidator;
use BookFromAuthorService;
use BookIsPersonalFilterHandler;
use BookReadFilterHandler;
use BookReadingDateFilterHandler;
use BookRepository;
use BookSerieService;
use BookService;
use BuyInfoService;
use ChartConfigurationService;
use CityService;
use CountryRepository;
use CountryService;
use CurrencyService;
use DateImporter;
use DateService;
use ElasticBooleanFilterHandler;
use ElasticDateFilterHandler;
use ElasticNumberFilterHandler;
use ElasticOptionsFilterHandler;
use ElasticStringFilterHandler;
use FileToAuthorParametersMapper;
use FileToBookParametersMapper;
use FileToBuyInfoParametersMapper;
use FileToCoverInfoParametersMapper;
use FileToExtraBookInfoParametersMapper;
use FileToFirstPrintParametersMapper;
use FileToGiftInfoParametersMapper;
use FileToOeuvreParametersMapper;
use FileToPersonalBookInfoParametersMapper;
use FilterHandlerGroup;
use FilterHistoryService;
use FilterType;
use FirstPrintInfoRepository;
use FirstPrintInfoService;
use GenreService;
use GiftInfoService;
use Illuminate\Support\ServiceProvider;
use ImageService;
use ImportFileMapper;
use JsonMappingService;
use Katzgrau\KLogger\Logger;
use LanguageRepository;
use LanguageService;
use OeuvreItemLinkValidator;
use OeuvreItemRepository;
use OeuvreService;
use PersonalBookInfoRepository;
use PersonalBookInfoService;
use PublisherRepository;
use PublisherSerieRepository;
use PublisherSerieService;
use PublisherService;
use ReadingDateRepository;
use ReadingDateService;
use SpriteCreator;
use SqlDateRangeFilterHandler;
use SqlDateRangeOrFilterHandler;
use SqlEqualsFilterHandler;
use SqlFullDateRangeFilterHandler;
use SqlOptionsFilterHandler;
use SqlReadFilterHandler;
use SqlStringFilterHandler;
use StatisticsRepository;
use TagRepository;
use TagService;
use UserRepository;
use UserService;
use WishlistRepository;
use WishlistService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('UserService', function () {
            return new UserService;
        });

        $this->app->singleton('ReadingDateService', function () {
            return new ReadingDateService();
        });

        $this->app->singleton('CountryService', function ($app) {
            return new CountryService($app->make('CountryRepository'));
        });

        $this->app->singleton('ImageService', function () {
            return new ImageService;
        });

        $this->app->singleton('ChartConfigurationService', function () {
            return new ChartConfigurationService();
        });

        $this->app->singleton('GenreService', function () {
            return new GenreService();
        });

        $this->app->singleton('WishlistRepository', function () {
            return new WishlistRepository();
        });

        $this->app->singleton('PublisherSerieRepository', function () {
            return new PublisherSerieRepository();
        });

        $this->app->singleton('BookElasticIndexer', function () {
            return new BookElasticIndexer();
        });

        $this->app->singleton('WishlistService', function () {
            return new WishlistService();
        });

        $this->app->singleton('OeuvreItemLinkValidator', function () {
            return new OeuvreItemLinkValidator();
        });

        $this->app->singleton('JsonMappingService', function () {
            return new JsonMappingService();
        });

        $this->app->singleton('CurrencyService', function () {
            return new CurrencyService();
        });

        $this->app->singleton('BookFilterManager', function () {
            $elasticHandlers = array(
                FilterType::BOOK_TITLE=>new ElasticStringFilterHandler('title'),
                FilterType::BOOK_TAG=>new ElasticOptionsFilterHandler('tags.id'),
                FilterType::BOOK_RETAIL_PRICE=>new ElasticNumberFilterHandler('retailPrice.amount'),
                FilterType::BOOK_LANGUAGE=>new ElasticOptionsFilterHandler('language'),
                FilterType::BOOK_RATING=>new ElasticOptionsFilterHandler('personalBookInfos.readingDates.rating'),
                FilterType::BOOK_READ=>new BookReadFilterHandler(),
                FilterType::BOOK_READING_DATE=>new BookReadingDateFilterHandler(),
                FilterType::BOOK_AUTHOR=>new ElasticOptionsFilterHandler('authors.id'),
                FilterType::BOOK_BUY_DATE=>new ElasticDateFilterHandler('personalBookInfos.buyInfo.buy_date'),
                FilterType::BOOK_RETRIEVE_DATE=>new ElasticDateFilterHandler('personalBookInfos.retrieveDate'),
                FilterType::BOOK_BUY_PRICE=>new ElasticNumberFilterHandler('personalBookInfos.buyInfo.price'),
                FilterType::BOOK_IS_PERSONAL=>new BookIsPersonalFilterHandler(),
                FilterType::BOOK_OWNED=>new ElasticBooleanFilterHandler('personalBookInfos.inCollection'),
                FilterType::BOOK_PUBLISHER=>new ElasticOptionsFilterHandler('publisher'),
                FilterType::BOOK_COUNTRY=>new ElasticOptionsFilterHandler('country'),
                FilterType::BOOK_GENRE=>new ElasticOptionsFilterHandler('genre'),
                FilterType::BOOK_BUY_GIFT_FROM=>new ElasticOptionsFilterHandler('personalBookInfos.giftInfo.from'),
            );
            $sqlHandlers = array(
                FilterType::BOOK_TITLE=>new SqlStringFilterHandler('book.title'),
                FilterType::BOOK_TAG=>new SqlOptionsFilterHandler('tag.id'),
                FilterType::BOOK_RETAIL_PRICE=>new SqlEqualsFilterHandler('book.retail_price'),
                FilterType::BOOK_LANGUAGE=>new SqlOptionsFilterHandler('book.language_id'),
                FilterType::BOOK_RATING=>new SqlOptionsFilterHandler('reading_date.rating'),
                FilterType::BOOK_READ=>new SqlReadFilterHandler(),
                FilterType::BOOK_RETRIEVE_DATE=>new SqlDateRangeOrFilterHandler('buy_info.buy_date', 'gift_info.receipt_date'),
                FilterType::BOOK_READING_DATE=>new SqlDateRangeFilterHandler('reading_date.date'),
                FilterType::BOOK_AUTHOR=>new SqlOptionsFilterHandler('author.id'),
                FilterType::BOOK_BUY_DATE=>new SqlFullDateRangeFilterHandler('buy_info.buy_date'),
                FilterType::BOOK_BUY_PRICE=>new SqlEqualsFilterHandler('buy_info.price_payed'),
                FilterType::BOOK_PUBLISHER=>new SqlOptionsFilterHandler('publisher.id'),
                FilterType::BOOK_COUNTRY=>new SqlOptionsFilterHandler('book.publisher_country_id'),
                FilterType::BOOK_GENRE=>new SqlOptionsFilterHandler('genre.id'),
                FilterType::BOOK_BUY_GIFT_FROM=>new SqlOptionsFilterHandler('gift_info.from'),
            );
            $bookFilterManager = new BookFilterManager();
            $bookFilterManager->registerHandlers(FilterHandlerGroup::ELASTIC, $elasticHandlers);
            $bookFilterManager->registerHandlers(FilterHandlerGroup::SQL, $sqlHandlers);
            return $bookFilterManager;
        });

        $this->app->singleton('ApiAuthenticationService', function () {
            return new ApiAuthenticationService();
        });

        $this->app->singleton('TagRepository', function () {
            return new TagRepository();
        });

        $this->app->singleton('TagService', function () {
            return new TagService();
        });

        $this->app->singleton('OeuvreService', function () {
            return new OeuvreService;
        });

        $this->app->singleton('DateService', function () {
            return new DateService();
        });

        $this->app->singleton('BookFromAuthorService', function () {
            return new BookFromAuthorService();
        });

        $this->app->singleton('AuthorService', function () {
            return new AuthorService();
        });

        $this->app->singleton('BookService', function () {
            return new BookService;
        });

        $this->app->singleton('BuyInfoService', function () {
            return new BuyInfoService;
        });

        $this->app->singleton('GiftInfoService', function () {
            return new GiftInfoService;
        });

        $this->app->singleton('CityService', function () {
            return new CityService;
        });

        $this->app->singleton('PublisherSerieService', function () {
            return new PublisherSerieService;
        });

        $this->app->singleton('BookSerieService', function () {
            return new BookSerieService;
        });

        $this->app->singleton('ReadingDateService', function () {
            return new ReadingDateService;
        });

        $this->app->singleton('FirstPrintInfoService', function () {
            return new FirstPrintInfoService;
        });

        $this->app->singleton('FirstPrintInfoRepository', function () {
            return new FirstPrintInfoRepository();
        });

        $this->app->singleton('PersonalBookInfoService', function () {
            return new PersonalBookInfoService;
        });

        $this->app->singleton('PublisherService', function () {
            return new PublisherService();
        });

        $this->app->singleton('LanguageService', function () {
            return new LanguageService;
        });

        $this->app->singleton('DateImporter', function () {
            return new DateImporter();
        });

        $this->app->singleton('ImportFileMapper', function () {
            return new ImportFileMapper();
        });

        $this->app->singleton('SpriteCreator', function () {
            return new SpriteCreator();
        });

        $this->app->singleton('FilterHistoryService', function () {
            return new FilterHistoryService();
        });


        //logger
        $this->app->singleton(Logger::class, function () {
            return new Logger(storage_path().'/logs');
        });

        $this->app->singleton('BookFormValidator', function () {
            return new BookFormValidator();
        });

        $this->app->singleton('AuthorFormValidator', function () {
            return new AuthorFormValidator();
        });

        $this->app->singleton('FileToAuthorParametersMapper', function () {
            return new FileToAuthorParametersMapper();
        });

        $this->app->singleton('FileToBookParametersMapper', function () {
            return new FileToBookParametersMapper();
        });

        $this->app->singleton('FileToFirstPrintParametersMapper', function () {
            return new FileToFirstPrintParametersMapper();
        });

        $this->app->singleton('FileToBuyInfoParametersMapper', function () {
            return new FileToBuyInfoParametersMapper();
        });

        $this->app->singleton('FileToGiftInfoParametersMapper', function () {
            return new FileToGiftInfoParametersMapper();
        });

        $this->app->singleton('FileToExtraBookInfoParametersMapper', function () {
            return new FileToExtraBookInfoParametersMapper();
        });

        $this->app->singleton('FileToPersonalBookInfoParametersMapper', function () {
            return new FileToPersonalBookInfoParametersMapper();
        });

        $this->app->singleton('FileToCoverInfoParametersMapper', function () {
            return new FileToCoverInfoParametersMapper();
        });

        $this->app->singleton('FileToOeuvreParametersMapper', function () {
            return new FileToOeuvreParametersMapper();
        });


//REPOSITORIES

        $this->app->singleton('BookRepository', function () {
            return new BookRepository();
        });
        $this->app->singleton('ReadingDateRepository', function () {
            return new ReadingDateRepository();
        });

        $this->app->singleton('PersonalBookInfoRepository', function () {
            return new PersonalBookInfoRepository();
        });

        $this->app->singleton('UserRepository', function () {
            return new UserRepository();
        });

        $this->app->singleton('CountryRepository', function () {
            return new CountryRepository();
        });

        $this->app->singleton('AuthorRepository', function () {
            return new AuthorRepository();
        });

        $this->app->singleton('OeuvreItemRepository', function () {
            return new OeuvreItemRepository();
        });

        $this->app->singleton('PublisherRepository', function () {
            return new PublisherRepository();
        });

        $this->app->singleton('LanguageRepository', function () {
            return new LanguageRepository();
        });

        $this->app->singleton('StatisticsRepository', function () {
            return new StatisticsRepository();
        });

    }
}