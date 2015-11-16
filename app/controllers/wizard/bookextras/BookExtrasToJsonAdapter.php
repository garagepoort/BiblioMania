<?php


class BookExtrasToJsonAdapter
{
    public function mapToJson(Book $book)
    {
        $bookExtras = new UpdateBookExtrasFromJsonAdapter();
        $bookExtras->setCoverPriceCurrency($book->currency);
        $bookExtras->setCoverPrice($book->retail_price);
        $bookExtras->setPages($book->number_of_pages);
        $bookExtras->setPrint($book->print);
        $bookExtras->setTranslator($book->translator);
        $bookExtras->setOldTags($book->old_tags);
        $bookExtras->setState($book->state);
        $bookExtras->setSummary($book->summary);

        if($book->serie != null){
            $bookExtras->setBookSeries($book->serie->name);
        }
        if($book->publisher_serie != null){
            $bookExtras->setPublisherSeries($book->publisher_serie->name);
        }

        return $bookExtras->toJson();
    }

}