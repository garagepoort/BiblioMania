<?php

abstract class LineMapping
{
    public static $BookTitle = "INVALID";
    public static $BookSubtitle = "INVALID";
    public static $BookISBN = "INVALID";
    public static $BookSummary = "INVALID";
    public static $BookState = "INVALID";
    public static $BookPublicationDate = "INVALID";
    public static $BookPublisher = "INVALID";
    public static $BookPublisherCountry = "INVALID";
    public static $BookLanguage = "INVALID";
    public static $BookGenre = "INVALID";
    public static $BookRetailPrice = "INVALID";

    public static $ExtraBookInfoPages = "INVALID";
    public static $ExtraBookInfoPrint = "INVALID";
    public static $ExtraBookInfoTranslator = "INVALID";
    public static $ExtraBookInfoCondition = "INVALID";
    public static $ExtraBookInfoTags = "INVALID";

    public static $PersonalBookInfoInCollection = "INVALID";
    public static $PersonalBookInfoRead = "INVALID";
    public static $PersonalBookInfoReadingDate = "INVALID";
    public static $PersonalBookInfoRating = "INVALID";

    public static $FirstAuthor = "INVALID";
    public static $SecondAuthor = "INVALID";
//    public static FirstAuthorName = 2;
//    public static FirstAuthorFirstName = 0;
//    public static FirstAuthorInfix = 1;
    public static $AuthorImage = "INVALID";
    public static $AuthorOeuvre = "INVALID";

    public static $FirstPrintTitle = "INVALID";
    public static $FirstPrintLanguage = "INVALID";
    public static $FirstPrintCountry = "INVALID";
    public static $FirstPrintPublicationDate = "INVALID";
    public static $FirstPrintPublisherName = "INVALID";
    public static $FirstPrintSubTitle = "INVALID";

    public static $BuyInfoBuyDate = "INVALID";
    public static $BuyInfoPricePayed = "INVALID";
    public static $BuyInfoShop = "INVALID";

    public static $GiftInfoDate = "INVALID";
    public static $GiftInfoFrom = "INVALID";

    public static $CoverInfoImagePath = "INVALID";
    public static $CoverInfoType = "INVALID";

    public static function initializeMapping($values)
    {
        $counter = 0;
        foreach($values as $value){
            $value = StringUtils::replace($value, "\r\n", "");
            $value = trim($value,'"');

            if($value == "Auteur"){
                LineMapping::$FirstAuthor = $counter;
            }
            if($value == "Titel"){
                LineMapping::$BookTitle = $counter;
            }
            if($value == "ISBN"){
                LineMapping::$BookISBN = $counter;
            }
            if($value == "Uitgever"){
                LineMapping::$BookPublisher = $counter;
            }
            if($value == "Tags"){
                LineMapping::$ExtraBookInfoTags = $counter;
            }
            if($value == "Conditie"){
                LineMapping::$BookState = $counter;
            }
            if($value == "Medium"){
                LineMapping::$CoverInfoType = $counter;
            }
            if($value == "Aanschafdatum"){
                LineMapping::$BuyInfoBuyDate = $counter;
                LineMapping::$GiftInfoDate = $counter;
            }
            if($value == "Aanschafprijs"){
                LineMapping::$BuyInfoPricePayed = $counter;
            }
            if($value == "Afbeelding Voorkant"){
                LineMapping::$CoverInfoImagePath = $counter;
            }
            if($value == "Conditie"){
                LineMapping::$ExtraBookInfoCondition = $counter;
            }
            if($value == "Druk"){
                LineMapping::$ExtraBookInfoPrint = $counter;
            }
            if($value == "Gekregen van:"){
                LineMapping::$GiftInfoFrom = $counter;
            }
            if($value == "Gelezen?"){
                LineMapping::$PersonalBookInfoRead = $counter;
            }
            if($value == "Genre"){
                LineMapping::$BookGenre = $counter;
            }
            if($value == "Land"){
                LineMapping::$BookPublisherCountry = $counter;
            }
            if($value == "Lees Datum"){
                LineMapping::$PersonalBookInfoReadingDate = $counter;
            }
            if($value == "Locatie"){
                LineMapping::$PersonalBookInfoInCollection = $counter;
            }
            if($value == "Mijn Waardering"){
                LineMapping::$PersonalBookInfoRating = $counter;
            }
            if($value == "Oeuvre"){
                LineMapping::$AuthorOeuvre = $counter;
            }
            if($value == "Omslag Prijs"){
                LineMapping::$BookRetailPrice = $counter;
            }
            if($value == "Ondertitel"){
                LineMapping::$BookSubtitle = $counter;
            }
            if($value == "Origineel Land"){
                LineMapping::$FirstPrintCountry = $counter;
            }
            if($value == "Originele Publicatiedatum"){
                LineMapping::$FirstPrintPublicationDate = $counter;
            }
            if($value == "Originele Taal"){
                LineMapping::$FirstPrintLanguage = $counter;
            }
            if($value == "Originele Titel"){
                LineMapping::$FirstPrintTitle = $counter;
            }
            if($value == "Originele Ondertitel"){
                LineMapping::$FirstPrintSubTitle = $counter;
            }
            if($value == "Originele Uitgever"){
                LineMapping::$FirstPrintPublisherName = $counter;
            }
            if($value == "pagina's"){
                LineMapping::$ExtraBookInfoPages = $counter;
            }
            if($value == "Publicatie Datum"){
                LineMapping::$BookPublicationDate = $counter;
            }
            if($value == "Taal"){
                LineMapping::$BookLanguage = $counter;
            }
            if($value == "Vertaler"){
                LineMapping::$ExtraBookInfoTranslator = $counter;
            }
            if($value == "Winkel"){
                LineMapping::$BuyInfoShop = $counter;
            }
            if($value == "Verhaal"){
                LineMapping::$BookSummary = $counter;
            }
            if($value == "Koppelingen"){
                LineMapping::$AuthorImage = $counter;
            }
            if($value == "Hulpauteur"){
                LineMapping::$SecondAuthor = $counter;
            }
            $counter++;
        }
    }


}