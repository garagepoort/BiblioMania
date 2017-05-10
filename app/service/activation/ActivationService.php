<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ActivationService
{

	/** @var  Mailer $mailer */
	private $mailer;
	/** @var  ActivationRepository $activationRepository */
	private $activationRepository;
	/** @var UserRepository $userRepository */
	private $userRepository;

	public function __construct()
	{
		$this->mailer = App::make('Illuminate\Mail\Mailer');
		$this->activationRepository = App::make('ActivationRepository');
		$this->userRepository = App::make('UserRepository');
	}

	public function sendActivationMail($user)
	{
		if ($user->activated) {
			return;
		}

		$token = $this->activationRepository->createActivation($user->id);

		$link = route('user.activate', $token);
		$message = sprintf('Activate your BiblioMania account: <a href="%s">%s</a>', $link, $link);

		$this->mailer->raw($message, function (Message $m) use ($user) {
			$m->to($user->email)->subject('BiblioMania activation mail');
		});
	}

	public function activateUser($token)
	{
		$activation = $this->activationRepository->getActivationByToken($token);
		Ensure::objectNotNull('activation', $activation, 'Not a valid activation token');

		$user = $this->userRepository->find($activation->user_id);
		$user->activated = true;
		$this->userRepository->saveUser($user);

		$this->activationRepository->deleteActivation($token);

		return $user;
	}

}