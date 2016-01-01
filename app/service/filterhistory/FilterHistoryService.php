<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class FilterHistoryService
{

    public function addFiltersToHistory($filters){
        /** @var Filter $filter */
        foreach($filters as $filter){
            $filterHistory = FilterHistory::where('filter_id', "=", $filter->getId())->first();
            if($filterHistory === null){
                $filterHistory = new FilterHistory();
                $filterHistory->filter_id = $filter->getId();
            }

            $filterHistory->times_used = $filterHistory->times_used + 1;
            $filterHistory->save();
        }
    }

    public function getMostUsedFilters()
    {
        return FilterHistory::limit(4)->orderBy('times_used', 'DESC')->get();
    }
}