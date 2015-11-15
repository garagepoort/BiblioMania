<?php


class BookBasicsJsonMapper
{
    public function mapToJson(Book $book)
    {
        $bookBasics = new BookBasicsData();
        $bookBasics->setTitle($book->title);
        $bookBasics->setSubtitle($book->subtitle);
        $bookBasics->setIsbn($book->ISBN);
        $bookBasics->setGenre($book->genre->name);
        $bookBasics->setTags($this->mapTags($book));

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
            return $item['name'];
        }, $book->tags->toArray());
        return $tags;
    }
}