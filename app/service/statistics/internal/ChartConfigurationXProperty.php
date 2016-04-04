<?php

namespace Bendani\PhpCommon\FilterService\Model;

use Bendani\PhpCommon\Utils\Model\BasicEnum;

class ChartConfigurationXProperty extends BasicEnum{
    const READING_DATE_YEAR = "YEAR(reading_date.date)";
    const GENRE = "genre.name";
    const TAG = "tag.name";
    const PUBLICATION_YEAR = "publication_date.year";
    const GIFT_YEAR = "YEAR(gift_info.receipt_date)";
    const BUY_YEAR = "YEAR(buy_info.buy_date)";
    const GIFT_FROM = "gift_info.from";
}