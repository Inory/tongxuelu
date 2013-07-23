<?php
class LoginAction extends CAction
{
	public function run()
	{
		$this->controller->render('login');
	}
}