<?php
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 22/08/15
 * Time: 03:04
 */
class OeuvreController extends Controller
{

    /** @var  OeuvreToParameterMapper */
    private $oeuvreToParameterMapper;
    /** @var  OeuvreService */
    private $oeuvreService;
    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;
    /** @var  OeuvreItemRepository */
    private $oeuvreItemRepository;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  BookService */
    private $bookService;
    /** @var  JsonMappingService */
    private $jsonMappingService;

    function __construct()
    {
        $this->oeuvreService = App::make('OeuvreService');
        $this->oeuvreToParameterMapper = App::make('OeuvreToParameterMapper');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
        $this->oeuvreItemRepository = App::make('OeuvreItemRepository');
        $this->bookRepository = App::make('BookRepository');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getOeuvreFromAuthor($id){
        $oeuvre = $this->oeuvreItemRepository->getFromAuthor($id);
        if($oeuvre == null){
            throw new ServiceException('Oeuvre from author not found');
        }
        return array_map(function($item){
            $oeuvreItemToJsonAdapter = new OeuvreItemToJsonAdapter($item);
            return $oeuvreItemToJsonAdapter->mapToJson();
        }, $oeuvre->all());
    }

    public function deleteOeuvreItem($id){
        $this->oeuvreService->deleteOeuvreItem($id);
    }

    public function getOeuvreItem($id){
        $oeuvreItem = $this->oeuvreService->find($id);
        Ensure::objectNotNull("oeuvre item", $oeuvreItem);
        $oeuvreItemToJsonAdapter = new OeuvreItemToJsonAdapter($oeuvreItem);
        return $oeuvreItemToJsonAdapter->mapToJson();
    }

    public function linkBookToOeuvreItem($oeuvreId){
        $mapInputToJson = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->oeuvreService->linkBookToOeuvreItem($oeuvreId, $mapInputToJson);
    }
    public function deleteBookFromOeuvreItem($oeuvreId){
        $mapInputToJson = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->oeuvreService->deleteLinkedBookFromOeuvreItem($oeuvreId, $mapInputToJson);
    }

    public function getOeuvreItemLinkedBooks($id){
        /** @var BookFromAuthor $oeuvreItem */
        $oeuvreItem = $this->oeuvreService->find($id);
        Ensure::objectNotNull("oeuvre item", $oeuvreItem);
        return array_map(function($book){
            $bookToJsonAdapter = new BookToJsonAdapter($book);
            return $bookToJsonAdapter->mapToJson();
        }, $oeuvreItem->books->all());
    }

    public function updateOeuvreItem(){
        $this->oeuvreService->updateOeuvreItem($this->jsonMappingService->mapInputToJson(Input::get(), new UpdateOeuvreItemFromJsonAdapter()));
    }

    public function getOeuvreByBook($id){
        /** @var Book $book */
        $book = $this->bookRepository->find($id);
        if($book == null){
            throw new ServiceException('Book not found');
        }
        return $this->getOeuvreFromAuthor($book->mainAuthor()->id);
    }

    public function saveOeuvreItemsToAuthor(){
        $createRequests = $this->jsonMappingService->mapInputArrayToJson(Input::get(), new CreateOeuvreItemFromJsonAdapter());
        foreach($createRequests as $createRequest){
            $this->oeuvreService->createOeuvreItem($createRequest);
        }
    }

}