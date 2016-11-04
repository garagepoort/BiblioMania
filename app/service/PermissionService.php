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
				'READ_BOOKS',
				'CREATE_BOOK',
				'UPDATE_BOOK',
				'DELETE_BOOK',

				'UPDATE_OEUVRE_ITEM',
				'READ_OEUVRE_ITEM',
				'DELETE_OEUVRE_ITEM',
				'CREATE_OEUVRE_ITEM',
				'LINK_OEUVRE_ITEM',
				'UNLINK_OEUVRE_ITEM'
			),
			'USER' => array(
				'READ_BOOKS'
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