<?php
	 class seo_config extends def_module {
	 	public function __constructor() {
	 		parent::__construct();

	 		if (cmsController::getInstance()->getCurrentMode() == 'admin') {
	 			$this->__loadLib('__admin.php');
	 			$this->__implement('__seo_conf');
	 				 			
	 		} else {
	 			$this->__loadLib('__custom.php');
				$this->__implement('__custom_seo_conf');
	 		}
	 	}
	 };

?>