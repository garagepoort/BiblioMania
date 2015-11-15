<?php


class BookBasicsToJsonAdapter
{
    public function mapToJson(Book $book)
    {
        $bookBasics = new UpdateBookBasicsFromJsonAdapter();
        $bookBasics->setTitle($book->title);
        $bookBasics->setSubtitle($book->subtitle);
        $bookBasics->setIsbn($book->ISBN);
        $bookBasics->setGenre($book->genre->name);
        $bookBasics->setTags($this->mapTags($book));

        if($book->publication_date != null){
            $bookBasics->setPublicationDate($this->mapDate($book->publication_date));
        }
        if ($book->publisher != null) {
            $bookBasics->setPublisher($book->publisher->name);
        }
        if ($book->language != null) {
            $bookBasics->setLanguage($book->language->language);
        }
        if ($book->country != null) {
            $bookBasics->setCountry($book->country->name);
        }

        return $bookBasics->toJson();
    }

    /**
     * @param Book $book
     * @return array
     */
    public function mapTags(Book $book)
    {
        $tags = array_map(function ($item) {
            $tagData = new TagData();
            $tagData->setText($item['name']);
            return $tagData;
        }, $book->tags->toArray());
        return $tags;
    }

    public function mapDate(Date $date){
        $dateJsonData = new DateJsonData();
        $dateJsonData->setDay($date->day);
        $dateJsonData->setMonth($date->month);
        $dateJsonData->setYear($date->year);
        return $dateJsonData;
    }
}