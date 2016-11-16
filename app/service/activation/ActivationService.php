<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ActivationService
{

	/** @var  Mailer $mailer */
	protected $mailer;
	/** @var  ActivationRepository $activationRepo */
	protected $activationRepo;

	protected $resendAfter = 24;

	public function __construct()
	{
		$this->mailer = App::make('Illuminate\Mail\Mailer');
		$this->activationRepo = App::make('ActivationRepository');
	}

	public function sendActivationMail($user)
	{

		if ($user->activated || !$this->shouldSend($user)) {
			return;
		}

		$token = $this->activationRepo->createActivation($user->id);

		$link = route('user.activate', $token);
		$message = sprintf('Activate account <a href="%s">%s</a>', $link, $link);

		$this->mailer->raw($message, function (Message $m) use ($user) {
			$m->to($user->email)->subject('Activation mail');
		});


	}

	public function activateUser($token)
	{
		$activation = $this->activationRepo->getActivationByToken($token);

		if ($activation === null) {
			throw new ServiceException('Not a valid activation token');
		}

		$user = User::find($activation->user_id);

		$user->activated = true;

		$user->save();

		$this->activationRepo->deleteActivation($token);

		return $user;

	}

	private function shouldSend($user)
	{
		$activation = $this->activationRepo->getActivation($user->id);
		return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
	}

}