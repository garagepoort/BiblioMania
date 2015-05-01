<?php

abstract class LineMapping
{
    const BookTitle = 9;
    const BookSubtitle = 48;
    const BookISBN = 10;
    const BookSummary = 62;
    const BookPublicationDate = 59;
    const BookPublisher = 12;
    const BookPublisherCountry = 41;
    const BookLanguage= 61;
    const BookRetailPrice= 47;

    const ExtraBookInfoPages = 57;
    const ExtraBookInfoPrint = 27;

    const PersonalBookInfoInCollection = 64;
    const PersonalBookInfoRead = 66;
    const PersonalBookInfoReadingDate = 42;
    const PersonalBookInfoRating = 44;

    const FirstAuthorName = 2;
    const FirstAuthorFirstName = 0;
    const FirstAuthorInfix = 1;
    const AuthorImage = 18;
    const AuthorOeuvre = 46;

    const SecondAuthorName = 5;
    const SecondAuthorFirstName = 3;
    const SecondAuthorInfix = 4;

    const ThirdAuthorName = 8;
    const ThirdAuthorFirstName = 6;
    const ThirdAuthorInfix = 7;

    const FirstPrintTitle = 55;
    const FirstPrintLanguage = 54;
    const FirstPrintCountry = 50;
    const FirstPrintPublicationDate = 53;
    const FirstPrintPublisherName = 56;

    const BuyInfoBuyDate = 15;
    const BuyInfoPricePayed = 16;
    const BuyInfoShop = 65;

    const GiftInfoDate = 15;
    const GiftInfoFrom = 33;

    const CoverInfoImagePath = 19;
    const CoverInfoType = 13;
}