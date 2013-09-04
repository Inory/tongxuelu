<?php
class ClassController extends Controller
{
	public function actions()
	{
		return array(
			'view'=>'application.controllers.class.ViewAction',
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			// array('allow', // only alow guest
			// 	'actions'=>array(),
			// 	'users'=>array('?'), 
			// ),
			// array('allow',  // allow all users
			// 	'actions'=>array(),
			// 	'users'=>array('*'),
			// ),
			array('allow', // allow authenticated user
				'actions'=>array('view'),
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