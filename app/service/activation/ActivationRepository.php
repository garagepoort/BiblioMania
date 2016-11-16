<?php

use Carbon\Carbon;

class ActivationRepository
{

	protected function getToken()
	{
		return hash_hmac('sha256', str_random(40), config('app.key'));
	}

	public function createActivation($user)
	{
		$activation = $this->getActivation($user);

		if (!$activation) {
			return $this->createToken($user);
		}
		return $this->regenerateToken($user);

	}

	private function regenerateToken($userId)
	{

		$token = $this->getToken();
		UserActivation::where('user_id', '=', $userId)->update([
			'token' => $token,
			'created_at' => new Carbon()
		]);
		return $token;
	}

	private function createToken($userId)
	{
		$token = $this->getToken();

		$userActivation = new UserActivation();
		$userActivation->user_id = $userId;
		$userActivation->token = $token;
		$userActivation->created_at = new Carbon();
		$userActivation->save();

		return $token;
	}

	public function getActivation($userId)
	{
		return UserActivation::where('user_id', '=', $userId)->first();
	}


	public function getActivationByToken($token)
	{
		return UserActivation::where('token', '=', $token)->first();
	}

	public function deleteActivation($token)
	{
		UserActivation::where('token', '=', $token)->delete();
	}
}