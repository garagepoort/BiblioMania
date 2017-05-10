<?php

class UserActivationController extends Controller
{
	/** @var  ActivationService $activationService */
	private $activationService;

	/**
	 * UserActivationController constructor.
	 */
	public function __construct()
	{
		$this->activationService = App::make('ActivationService');
	}

	public function activateUser($token){
		$user = $this->activationService->activateUser($token);
		auth()->login($user);
		return redirect('/');
	}
}