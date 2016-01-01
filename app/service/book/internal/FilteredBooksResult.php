<?php

class FilteredBooksResult
{

    private $totalAmountOfBooks;
    private $totalAmountOfBooksOwned;
    private $totalValue;
    private $paginatedItems;

    /**
     * FilteredBooksResult constructor.
     * @param $totalAmountOfBooks
     * @param $totalAmountOfBooksOwned
     * @param $totalValue
     * @param $paginatedItems
     */
    public function __construct($totalAmountOfBooks, $totalAmountOfBooksOwned, $totalValue, $paginatedItems)
    {
        $this->totalAmountOfBooks = $totalAmountOfBooks;
        $this->totalAmountOfBooksOwned = $totalAmountOfBooksOwned;
        $this->totalValue = $totalValue;
        $this->paginatedItems = $paginatedItems;
    }

    /**
     * @return mixed
     */
    public function getTotalAmountOfBooks()
    {
        return $this->totalAmountOfBooks;
    }

    /**
     * @return mixed
     */
    public function getTotalAmountOfBooksOwned()
    {
        return $this->totalAmountOfBooksOwned;
    }

    /**
     * @return mixed
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * @return mixed
     */
    public function getPaginatedItems()
    {
        return $this->paginatedItems;
    }

}