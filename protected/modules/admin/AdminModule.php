<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'admin.components.*',
		));
	}
}
