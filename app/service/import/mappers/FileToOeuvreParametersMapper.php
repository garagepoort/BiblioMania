<?php

class FileToOeuvreParametersMapper {


    /**
     * @param $oeuvre
     * @return array
     */
    public function map($oeuvre){
        $bookFromAuthorParameters = array();

        $oeuvre = explode('\n', $oeuvre);
        foreach ($oeuvre as $title) {
            if ($title != '') {

                $title = str_replace('*', '', $title);
                $title = trim($title);
                $year = $this->get_string_between($title);

                $title = str_replace($year, '', $title);
                $title = str_replace('(', '', $title);
                $title = str_replace(')', '', $title);
                $title = trim($title);

                $bookFromAuthor = new BookFromAuthorParameters($title, $year);
                array_push($bookFromAuthorParameters, $bookFromAuthor);
            }
        }
        return $bookFromAuthorParameters;
    }

    private function get_string_between($string)
    {
        $pattern = '/(18|19|20)[0-9][0-9]/';
        $found = preg_match($pattern, $string, $results);
        if ($found) {
            $result = str_replace('(', '', $results[0]);
            $result = str_replace(')', '', $result);
            return $result;
        }
        return '';
    }
}