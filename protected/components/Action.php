<?php
class Action extends CAction
{

	public function returnJson($data)
	{
		echo json_encode($data);
		Yii::app()->end();
	}

	public function returnSuccessJson($msg='', $data='')
	{
		echo json_encode(array('c' => 0, 'msg' => $msg, 'data' => $data));
		Yii::app()->end();
	}

	public function returnErrorJson($code, $msg, $data='')
	{
		echo json_encode(array('c' => $code, 'msg' => $msg, 'data' => $data));
		Yii::app()->end();
	}

	public function returnSimpleErrorJson($msg = '')
	{
		echo json_encode(array('c' => 1, 'msg' => $msg));
		Yii::app()->end();
	}
}