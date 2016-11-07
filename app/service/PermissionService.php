<?php

use Bendani\PhpCommon\Utils\Ensure;
use Katzgrau\KLogger\Logger;

class PermissionService
{

	private $permissions = array();
	/** @var  UserRepository */
	private $userRepository;
	/** @var  Logger */
	private $logger;

	public function __construct()
	{
		$this->logger = App::make('Logger');
		$this->userRepository = App::make('UserRepository');
		$this->permissions = array(
			'BOOK_ADMIN' => array(
				'READ_BOOK',
				'CREATE_BOOK',
				'UPDATE_BOOK',
				'DELETE_BOOK',

				'UPDATE_OEUVRE_ITEM',
				'READ_OEUVRE_ITEM',
				'DELETE_OEUVRE_ITEM',
				'CREATE_OEUVRE_ITEM',
				'LINK_OEUVRE_ITEM',
				'UNLINK_OEUVRE_ITEM',

				'READ_AUTHOR',
				'CREATE_AUTHOR',
				'UPDATE_AUTHOR',
				'DELETE_AUTHOR',
				'LINK_AUTHOR',
				'UNLINK_AUTHOR',

				'READ_FIRST_PRINT',
				'CREATE_FIRST_PRINT',
				'UPDATE_FIRST_PRINT',
				'DELETE_FIRST_PRINT',
				'LINK_FIRST_PRINT',
				'UNLINK_FIRST_PRINT',

				'READ_SERIE',
				'UPDATE_SERIE',
				'DELETE_SERIE',
				'LINK_SERIE',
				'UNLINK_SERIE',

				'READ_READING_DATE',
				'CREATE_READING_DATE',
				'UPDATE_READING_DATE',
				'DELETE_READING_DATE',

				'READ_PERSONAL_BOOK_INFO',
				'CREATE_PERSONAL_BOOK_INFO',
				'UPDATE_PERSONAL_BOOK_INFO',

				'LINK_WISHLIST',
				'UNLINK_WISHLIST'
			),
			'USER' => array(
				'READ_BOOK',
				'READ_AUTHOR',
				'READ_OEUVRE_ITEM',
				'READ_SERIE',

				'READ_READING_DATE',
				'CREATE_READING_DATE',
				'UPDATE_READING_DATE',
				'DELETE_READING_DATE',

				'READ_PERSONAL_BOOK_INFO',
				'CREATE_PERSONAL_BOOK_INFO',
				'UPDATE_PERSONAL_BOOK_INFO',

				'LINK_WISHLIST',
				'UNLINK_WISHLIST'
			)
		);
	}

	public function getPermissionsForUser($userId)
	{
		$user = $this->userRepository->find($userId);
		Ensure::objectNotNull('user', $user);

		$allPermissions = array();

		foreach ($user->roles as $role) {
			$this->logger->info($role->name);
			if (array_key_exists($role->name, $this->permissions)) {
				$allPermissions = array_merge($allPermissions, $this->permissions[$role->name]);
			}
		}
		return $allPermissions;
	}

	public function hasUserPermission($userId, $permission)
	{
		$user = $this->userRepository->find($userId);
		Ensure::objectNotNull('user', $user);

		foreach ($user->roles as $role) {
			if (array_key_exists($role->name, $this->permissions) && in_array($permission, $this->permissions[$role->name])) {
				return true;
			}
		}
		return false;

	}
}