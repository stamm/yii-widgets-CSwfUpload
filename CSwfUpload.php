<?php
class CSwfUpload extends CWidget
{
	public $postParams=array();
	public $config=array();

	public function run()
	{
		$assets = dirname(__FILE__).'/swfupload';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		$cs = Yii::app()->getClientScript();

		$cs->registerScript(__CLASS__.'swfuv',"var swfuPath='" . $baseUrl . "';", CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl . '/swfupload.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl . '/handlers.js', CClientScript::POS_END);
		$cs->registerCssFile($baseUrl . '/swfupload.css');

		$postParams = array('PHPSESSID'=>session_id());
		if(isset($this->postParams))
		{
				$postParams = array_merge($postParams, $this->postParams);
		}
		$config = array(
			'post_params'=> $postParams,
			'flash_url'=> $baseUrl. '/swfupload.swf',
			'button_image_url'=> $baseUrl .'/images/SmallSpyGlassWithTransperancy_17x18.png',
		);	//'jsHandlerUrl'=>$baseUrl.'/handlers.js' //Relative path

		$config = array_merge($config, $this->config);
		$config = CJavaScript::encode($config);
		$cs->registerScript(__CLASS__, "
		var swfu;
			swfu = new SWFUpload($config);
		");
	}
}