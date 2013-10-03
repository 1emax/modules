<?php

	$INFO = array();

	$INFO['name'] = 'seo_config';
    $INFO['title'] = "SEO Config";
    $INFO['config'] = '1';
    $INFO['description'] = "SEO Config";
	$INFO['filename'] = 'modules/seo_config/class.php';
	$INFO['ico'] = 'ico_seo_config';
	$INFO['default_method'] = 'page';
    $INFO['default_method_admin'] = 'tree';

    $INFO['func_perms'] = '';
    $INFO['func_perms/view'] = 'Просмотр страниц модуля';
    $INFO['func_perms/admin'] = 'Администрирование модуля';

    $COMPONENTS = array();

    $COMPONENTS[0] = "./classes/modules/seo_config/.htaccess";
    $COMPONENTS[1] = './classes/modules/seo_config/class.php';
    $COMPONENTS[2] = './classes/modules/seo_config/__admin.php';
    $COMPONENTS[3] = './classes/modules/seo_config/lang.php';
    $COMPONENTS[4] = './classes/modules/seo_config/i18n.php';
    $COMPONENTS[4] = './classes/modules/seo_config/i18n.en.php';
    $COMPONENTS[5] = './classes/modules/seo_config/permissions.php';

?>