<?php

namespace Bendani\PhpCommon\FilterService\Model;

use Bendani\PhpCommon\Utils\Model\BasicEnum;

class ChartConfigurationXProperty extends BasicEnum{
    const READING_DATE_YEAR = "YEAR(reading_date.date)";
    const GENRE = "genre.name";
}