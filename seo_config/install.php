<?php

	$INFO = array();

	$INFO['name'] = 'seo_config';
	$INFO['filename'] = 'seo_config/class.php';
	$INFO['ico'] = 'ico_seo_config';
	$INFO['default_method'] = 'page';
    $INFO['default_method_admin'] = 'tree';

    $INFO['func_perms'] = '';
    $INFO['func_perms/view'] = 'Просмотр страниц модуля';
    $INFO['func_perms/admin'] = 'Администрирование модуля';

    $COMPONENTS = array();

    $COMPONENTS[0] = "./classes/modules/seo/.htaccess";
    $COMPONENTS[1] = './classes/modules/mymodule/class.php';
    $COMPONENTS[2] = './classes/modules/mymodule/__admin.php';
    $COMPONENTS[3] = './classes/modules/mymodule/lang.php';
    $COMPONENTS[4] = './classes/modules/mymodule/i18n.php';
    $COMPONENTS[4] = './classes/modules/mymodule/i18n.en.php';
    $COMPONENTS[5] = './classes/modules/mymodule/permissions.php';

?>