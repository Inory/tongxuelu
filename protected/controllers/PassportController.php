<?php
class PassportController extends Controller
{
	public function actions()
	{
		return array(
			'login'=>'application.controllers.passport.LoginAction',
			'register'=>'application.controllers.passport.RegisterAction',
		);
	}
}