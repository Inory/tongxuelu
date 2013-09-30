<?php
class ThirdpartyloginAction extends CAction
{
	public function run($source)
	{
		switch ($source) {
			case 'sina' : $this->sina();break;
			case 'qq' : $this->tencent();break;
			default:
				break;
		}
	}

	protected function sina()
	{
		$sina = new Sina();
		Kaori_Session::set('next', 'success');
		Kaori_Session::set('source', 'sina');
		$body = $sina->buildGetAuthCodeHtml();
		echo $body;
	}

	protected function tencent()
	{
		$tencent = new Tencent();
		Kaori_Session::set('next', 'success');
		Kaori_Session::set('source', 'tencent');
		$body = $tencent->buildGetAuthCodeHtml();
		echo $body;
	}
}