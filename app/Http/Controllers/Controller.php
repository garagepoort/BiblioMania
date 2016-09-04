<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller_;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends Controller_
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
