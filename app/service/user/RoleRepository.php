<?php

class RoleRepository implements Repository
{

	public function find($id, $with = array())
	{
		return Role::with($with)
			->where('id', '=', $id)
			->first();
	}

	public function findByName($name){
		return Role::where('name', '=', $name)->first();
	}

	public function all()
	{
		return Role::all();
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
		// TODO: Implement deleteById() method.
	}
}