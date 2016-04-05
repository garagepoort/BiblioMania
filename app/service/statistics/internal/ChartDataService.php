<?php

use Bendani\PhpCommon\FilterService\Model\ChartConfigurationXProperty;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class ChartDataService
{

    /** @var  BookFilterManager */
    private $bookFilterManager;
    /** @var  \Katzgrau\KLogger\Logger */
    private $logger;
    /**
     * ChartDataService constructor.
     */
    public function __construct()
    {
        $this->bookFilterManager = App::make('BookFilterManager');
        $this->logger = App::make('Logger');
    }


    public function getChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        if($chartConfiguration->type === 'BAR'){
            return $this->getBarChartDataFromConfiguration($userId, $chartConfiguration);
        }
        throw new ServiceException('No chart found for type: ' . $chartConfiguration->type);
    }

    public function getBarChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        $labels = array();

        /** @var \Illuminate\Database\Query\Builder $builder */
        $builder = DB::table('book')->select(DB::raw($chartConfiguration->xProperty . ' as xProperty'), DB::raw("count(*) as total"));
        $builder = $this->join($builder);
        $builder =  $builder->where('personal_book_info.user_id', '=', $userId);
        $builder =  $builder->whereNotNull(DB::raw($chartConfiguration->xProperty));
//        $builder =  $builder->where(DB::raw($chartConfiguration->xProperty . " <> ''"));

        $adapter = new AllFilterValuesFromJsonAdapter(json_decode($chartConfiguration->filters, true));
        $filterValues = $adapter->getFilters();

        foreach($filterValues as $filterValue){
            $builder =  $this->bookFilterManager->handle(FilterHandlerGroup::SQL, $filterValue, $builder);
        }

        $results = $builder->groupBy(DB::raw($chartConfiguration->xProperty))->get();

        list($data, $labels) = $this->createChartDataFromResult($results, $labels);

        $chartData = new ChartData($chartConfiguration->title, $chartConfiguration->type, $labels, $data);
        return $chartData;
    }

    private function join($builder){
        return $builder->join('personal_book_info', 'book_id', '=', 'book.id')
            ->leftJoin('buy_info', 'buy_info.personal_book_info_id', '=', 'personal_book_info.id')
            ->leftJoin('gift_info', 'gift_info.personal_book_info_id', '=', 'personal_book_info.id')
            ->leftJoin('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->leftJoin('date as first_print_info_date', 'first_print_info.publication_date_id', '=', 'first_print_info_date.id')
            ->leftJoin('country as first_print_info_country', 'first_print_info.country_id', '=', 'first_print_info_country.id')
            ->join('book_author', 'book_author.book_id', '=', 'book.id')
            ->join('author', 'book_author.author_id', '=', 'author.id')
            ->join('publisher', 'book.publisher_id', '=', 'publisher.id')
            ->leftJoin('book_tag', 'book_tag.book_id', '=', 'book.id')
            ->leftJoin('date as publication_date', 'book.publication_date_id', '=', 'publication_date.id')
            ->leftJoin('tag', 'tag.id', '=', 'book_tag.tag_id')
            ->leftJoin('date as publicationDate', 'book.publication_date_id', '=', 'publicationDate.id')
            ->leftJoin('reading_date', 'reading_date.personal_book_info_id', '=', 'personal_book_info.id')
            ->leftJoin('genre', 'genre.id', '=', 'book.genre_id');
    }

    /**
     * @param $results
     * @param $labels
     * @return array
     */
    private function createChartDataFromResult($results, $labels)
    {
        $data = array();
        $values = array();
        foreach ($results as $result) {
            if (in_array($result->xProperty, $labels) == false) {
                array_push($labels, $result->xProperty);
            }

            array_push($values, $result->total);
        }
        array_push($data, $values);
        return array($data, $labels);
    }
}