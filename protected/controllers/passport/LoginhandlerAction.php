<?php
class LoginhandlerAction extends CAction
{
	public function run()
	{
		$this->controller->render('login');
	}

}