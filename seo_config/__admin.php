<?php

abstract class __seo_conf extends baseModuleAdmin {

    public function config() {
        $regedit = regedit::getInstance();
        $domains = domainsCollection::getInstance()->getList();
        $lang_id = cmsController::getInstance()->getCurrentLang()->getId();
        $params = Array();
        $mode = (string) getRequest('param0');

        foreach($domains as $domain) {
            $domain_id = $domain->getId();
            $domain_name = $domain->getHost();

            $seo_info = Array();
            $seo_info['status:domain'] = $domain_name;
            $seo_info['string:title-' . $domain_id] = $regedit->getVal("//settings/title_prefix/{$lang_id}/{$domain_id}");
            $seo_info['string:keywords-' . $domain_id] = $regedit->getVal("//settings/meta_keywords/{$lang_id}/{$domain_id}");
            $seo_info['string:description-' . $domain_id] = $regedit->getVal("//settings/meta_description/{$lang_id}/{$domain_id}");

            $params[$domain_name] = $seo_info;
        }

        if($mode == "do") {
            $params = $this->expectParams($params);

            foreach($domains as $domain) {
                $domain_id = $domain->getId();
                $domain_name = $domain->getHost();

                $title = $params[$domain_name]['string:title-' . $domain_id];
                $keywords = $params[$domain_name]['string:keywords-' . $domain_id];
                $description = $params[$domain_name]['string:description-' . $domain_id];

                $regedit->setVal("//settings/title_prefix/{$lang_id}/{$domain_id}", $title);
                $regedit->setVal("//settings/meta_keywords/{$lang_id}/{$domain_id}", $keywords);
                $regedit->setVal("//settings/meta_description/{$lang_id}/{$domain_id}", $description);
            }

            $this->chooseRedirect();
        }
// 
        $this->setDataType('settings');
        $this->setActionType('modify');

        $data = $this->prepareData($params, 'settings');
        $this->setData($data);
        return $this->doData();
    }

    public function meta() {

            $regedit = regedit::getInstance();
            $params = Array (
                "config" => Array (
                    "string:meta-login" => null,
                    "string:meta-password" => null
                )
            );

            $mode = getRequest("param0");

            if ($mode == "do"){
                $params = $this->expectParams($params);
                $regedit->setVar("//modules/seo_config/meta-login", $params["config"]["string:meta-login"]);
                $regedit->setVar("//modules/seo_config/meta-password", $params["config"]["string:meta-password"]);
                $this->chooseRedirect();
            }

            $params["config"]["string:meta-login"] = $regedit->getVal("//modules/seo_config/meta-login");
            $params["config"]["string:meta-password"] = $regedit->getVal("//modules/seo_config/meta-password");

            

            $this->setDataType("settings");
            $this->setActionType("modify");

            $data = $this->prepareData($params, "settings");
            $this->setData($data);
            return $this->doData();

        }

    public function getDatasetConfiguration($param = '') {
        return array(
        'methods' => array(
            array('title'=>'Загрузка')
            )
        );
    }

    public function show() {
        $regedit = regedit::getInstance();
        $this->setDataType("list");
        $this->setActionType("view");
        $limit = 20;
        $curr_page = getRequest('p');
        $offset = $curr_page * $limit;

        $total = 2;

        $items = Array();
        $item_arr_1['node:name'] = "name_1";
        $item_arr_1['attribute:value'] = 111;
        $item_arr_2['node:name'] = "name_2";
        $item_arr_2['attribute:value'] = 222;
        $item_arr_3['node:name'] = 'name_3';
        $item_arr_3['attribute:value'] = print_r($regedit->getList("//settings/"));

        $items[] = $item_arr_1;
        $items[] = $item_arr_2;
        $items[] = $item_arr_3;
        $data = array('nodes:element' => $items);
        $this->setData($data, $total);
        $this->setDataRangeByPerPage($limit, $curr_page);
        return $this->doData(); 
    }

	public function tree() {
        //Получение id родительской страницы. Если передан неверный id, будет выброшен exception
        $parent_id = $this->expectElementId('param0');

        $per_page = 25;
        $curr_page = getRequest('p');

        //Подготавливаем выборку
        $sel = new selector('pages');
        $sel->types('hierarchy-type')->name('comments', 'comment');
        $sel->limit($per_page, $curr_page);
        
        // фильтр по автору
        $filter_author_id = intval(getRequest('filter_author_id'));
        if ($filter_author_id) {
            $sel->where('author_id')->equals($filter_author_id);
        }

        //Выполняем выборку. В $result теперь будет лежать массив id страниц - результат выборки
        $result = $sel->result();
        $total = $sel->length();

        //Вывод данных
        //Устанавливаем тип для вывода данных в "list" - список
        $this->setDataType("list");

        //Устанавливаем действие над списокм - "view" - просмотр списка
        $this->setActionType("view");

        //Указываем диапозон данных
        $this->setDataRange($per_page, $curr_page * $per_page);

        //Подготавливаем данные, чтобы потом корректно их вывести
        $data = $this->prepareData($result, "pages");

        //Завершаем вывод
        $this->setData($data, $total);

        return $this->doData();
    }


}	

?>
