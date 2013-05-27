<?php

class PageModule extends CWebModule
{
	public function init()
	{
		$this->configure(app()->configLocator->get('page'));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
