<?php
class PassportController extends Controller
{
	public function actions()
	{
		return array(
			'loginhandler'=>'application.controllers.passport.loginhandlerAction',

			'thirdpartylogin'=>'application.controllers.passport.ThirdpartyloginAction',
			'callback'=>'application.controllers.passport.CallbackAction',

			'register'=>'application.controllers.passport.RegisterAction',
			'registerhandler'=>'application.controllers.passport.RegisterhandlerAction',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('login','loginhandler','thirdpartylogin','callback','register','registerhandler'),
				'users'=>array('?'), // only alow guest
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('logout'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function actionLogin()
	{
		$this->render('login');
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}