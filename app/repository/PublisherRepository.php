<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 11/04/15
 * Time: 09:50
 */

class PublisherRepository implements iRepository{

    public function find($id, $with = array())
    {
        return Publisher::with($with)->find($id);
    }

    public function all()
    {
        return Publisher::all();
    }

    public function save($entity)
    {
        $entity->save();
    }

    public function delete($entity)
    {
        $entity->delete();
    }

    public function deleteById($id)
    {
        return Publisher::find($id)->delete();
    }

    public function getCountriesFromPublisher($publisher_id)
    {
        return DB::select("SELECT distinct country.name from country
                            where country.id in
                            (select first_print_info.country_id from first_print_info where first_print_info.publisher_id = $publisher_id
                              UNION
                              select book.publisher_country_id from book where book.publisher_id = $publisher_id)");
    }
}