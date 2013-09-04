<?php
class PassportController extends Controller
{
	public function actions()
	{
		return array(
			'login'=>'application.controllers.passport.LoginAction',
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
}