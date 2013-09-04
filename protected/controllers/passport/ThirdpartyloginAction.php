<?php
class ThirdpartyloginAction extends CAction
{
	public function run($source)
	{
		session_start();
		switch ($source) {
			case 'sina' : $this->sina();break;
			case 'tencent' : $this->tencent();break;
			default:
				break;
		}
	}

	protected function sina()
	{
		$sina = new Sina();
		$_SESSION['next'] = 'success';
		$body = $sina->buildGetAuthCodeHtml();
		echo $body;
	}

	protected function tencent()
	{

	}
}