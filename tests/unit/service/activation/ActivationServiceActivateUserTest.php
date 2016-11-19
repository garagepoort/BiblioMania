<?php

class ActivationServiceActivateUserTest extends TestCase
{
	const ACTIVATION_TOKEN = "activationToken";
	const USER_ID = 213;

	/** @var ActivationService $activationService */
	private $activationService;
	/** @var ActivationRepository $activationRepository */
	private $activationRepository;
	/** @var UserRepository $userRepository */
	private $userRepository;

	/** @var UserActivation $userActivation */
	private $userActivation;
	/** @var User $user */
	private $user;

	public function setUp(){
	    parent::setUp();

		$this->user = $this->mockEloquent('User');
		$this->userActivation = $this->mockEloquent('UserActivation');
		$this->userActivation->shouldReceive('getAttribute')->with('user_id')->andReturn(self::USER_ID);
		$this->userRepository = $this->mock('UserRepository');
		$this->activationRepository = $this->mock('ActivationRepository');

		$this->activationService = App::make('ActivationService');
	}

	 /**
	  * @expectedException \Bendani\PhpCommon\Utils\Exception\ServiceException
	  * @expectedExceptionMessage Not a valid activation token
	  */
	public function test_throwsExceptionWhenActivationWithGivenTokenNotFound(){
		$this->activationRepository->shouldReceive('getActivationByToken')->with(self::ACTIVATION_TOKEN)->andReturn(null);

		$this->activationService->activateUser(self::ACTIVATION_TOKEN);
	}

	public function test_createsActivationCorrectly(){
		$this->user->shouldReceive('setAttribute')->with('activated', true)->once();
		$this->userRepository->shouldReceive('saveUser')->with($this->user)->once();
		$this->userRepository->shouldReceive('find')->with(self::USER_ID)->andReturn($this->user);
		$this->activationRepository->shouldReceive('getActivationByToken')->with(self::ACTIVATION_TOKEN)->once()->andReturn($this->userActivation);
		$this->activationRepository->shouldReceive('deleteActivation')->with(self::ACTIVATION_TOKEN)->once();

		$this->activationService->activateUser(self::ACTIVATION_TOKEN);
	}

}