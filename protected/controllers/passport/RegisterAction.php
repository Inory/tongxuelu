<?php
class RegisterAction extends Action
{
	public function run()
	{
		if(isset($_POST['action']) && $_POST['action'] === 'checkEmail')
		{
			$user = User::model()->find('email = ?', array($_POST['email']));
			if($user !== null)
			{
				$this->returnSimpleErrorJson();
			}
			else
			{
				$this->returnSuccessJson();
			}
		}

		$model = new User;
		if(isset($_POST['user']))
		{
			
			$model->attributes = $_POST['user'];
			$model->save();

		}

		$this->controller->render(
			'register',
			array('model' => $model)
		);
	}

}