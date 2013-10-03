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
            $seo_info['string:title'] = $regedit->getVal("//settings/title_prefix/{$lang_id}/{$domain_id}");
            $seo_info['string:keywords-' . $domain_id] = $regedit->getVal("//settings/meta_keywords/{$lang_id}/{$domain_id}");
            $seo_info['string:description-' . $domain_id] = $regedit->getVal("//settings/meta_description/{$lang_id}/{$domain_id}");

            $params[$domain_name] = $seo_info;
        }

        if($mode == "do") {
            $params = $this->expectParams($params);

            foreach($domains as $domain) {
                $domain_id = $domain->getId();
                $domain_name = $domain->getHost();

                $title = $params[$domain_name]['string:title'];
                $keywords = $params[$domain_name]['string:keywords'];
                $description = $params[$domain_name]['string:description'];

                $regedit->setVal("//settings/title_prefix/{$lang_id}/{$domain_id}", $title);
                $regedit->setVal("//settings/meta_keywords/{$lang_id}/{$domain_id}", $keywords);
                $regedit->setVal("//settings/meta_description/{$lang_id}/{$domain_id}", $description);
            }

            $this->chooseRedirect();
        }

        $this->setDataType('settings');
        $this->setActionType('modify');

        $data = $this->prepareData($params, 'settings');
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