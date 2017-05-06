<?php

use Illuminate\Mail\Mailer;

class ActivationServiceSendActivationMailTest extends TestCase
{
	const USER_ID = 123;
	const ACTIVATION_TOKEN = "activationToken";

	/** @var ActivationService $activationService */
	private $activationService;
	/** @var ActivationRepository $activationRepository */
	private $activationRepository;
	/** @var Mailer $mailer */
	private $mailer;

	/** @var User $user */
	private $user;

	public function setUp(){
	    parent::setUp();

		$this->mailer = $this->mock('Illuminate\Mail\Mailer');

		$this->user = $this->mockEloquent('User');
		$this->user->shouldReceive('getAttribute')->with('id')->andReturn(self::USER_ID);
		$this->user->shouldReceive('getAttribute')->with('activated')->andReturn(false)->byDefault();

		$this->activationRepository = $this->mock('ActivationRepository');

		$this->activationService = App::make('ActivationService');
	}
	
	public function test_doesNothingWhenGivenUserIsAlreadyActivated(){
		$this->user->shouldReceive('getAttribute')->with('activated')->andReturn(true);
		$this->activationRepository->shouldReceive('createActivation')->never();

		$this->activationService->sendActivationMail($this->user);
	}

	public function test_createsActivationCorrectly(){
		$this->activationRepository->shouldReceive('createActivation')->with(self::USER_ID)->once()->andReturn(self::ACTIVATION_TOKEN);
		$this->mailer->shouldReceive('raw')->once();

		$this->activationService->sendActivationMail($this->user);
	}

}