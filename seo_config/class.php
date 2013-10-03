<?php
	 class seo_config extends def_module {
	 	public function __construct() {
	 		parent::__construct();

	 		if (cmsController::getInstance()->getCurrentMode() == 'admin') {
	 			$this->__loadLib('__admin.php');
	 			$this->__implement('__seo_conf');
 
	 			$configTabs = $this->getConfigTabs();
				if ($configTabs) {
					$configTabs->add("config");
					$configTabs->add('meta');				
				}

	 			$commonTabs = $this->getCommonTabs();
				if($commonTabs) {
					$commonTabs->add('tree');
					$commonTabs->add('show');
					
				}
	 				 			
	 		} else {
	 			$this->__loadLib('__custom.php');
				$this->__implement('__custom_seo_conf');
	 		}
	 	}
	 };

?>