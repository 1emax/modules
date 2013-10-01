<?php
    class mymodule extends def_module {

        public function __construct() {
            parent::__construct();  // Вызываем конструктор родительского класса def_module

            // В зависимости от режима работы системы, подключаем различные методы
            if(cmsController::getInstance()->getCurrentMode() == "admin") {
                // подгружаем файл с абстрактным классом __mymodule_adm для админки
                $this->__loadLib("__admin.php");
                // подключаем ("импортируем") методы класса __mymodule_adm
                // для расширения функционала в режиме администрирования
                $this->__implement("__mymodule_adm");
            } else {
                // подгружаем файл с абстрактным классом __custom_mymodule для клиентской части
                $this->__loadLib("__custom.php");
                // подключаем ("импортируем") методы класса __custom_mymodule
                // для расширения функционала в клиентском режиме
                $this->__implement("__custom_mymodule");
            }
        }

        /**
           * Этот метод вызывает система для того, чтобы определить как редактировать
           * и добавлять элементы каждого типа, контролируемые нашим модулем.
           * Присутствие этого метода не обязательно, если модуль оперирует только 
           * объектами и не создает страниц

           * @param String $element_id идентификатор страницы, над которой можно совершить действия
           * @param String $element_type базовый метод, связанный с этой страницей
           * @return Array должен возвращать список из двух элементов, первый элемент которого
           * ссылка на добавление подстраницы, второй - ссылка на редактирование страницы. 
           * Если один из элементов false, то соответствующее действие не доступно.
        */
        public function getEditLink($element_id, $element_type) {
            $element = umiHierarchy::getInstance()->getElement($element_id);

            switch($element_type) {
                case "rubric": {
                    // ссылка на добавление страницы (page)
                    $link_add = $this->pre_lang . "/admin/mymodule/add/{$element_id}/page/";
                    // ссылка на редактирование рубрики (rubric)
                    $link_edit = $this->pre_lang . "/admin/mymodule/edit/{$element_id}/";

                    return Array($link_add, $link_edit);
                    break;
                }

                case "page": {
                    // ссылка на редактирование страницы
                    $link_edit = $this->pre_lang . "/admin/mymodule/edit/{$element_id}/";
                    // запрещаем добавлять подстраницы для типа "page", первый элемент списка = false
                    return Array(false, $link_edit);
                    break;
                }

                default: {
                    return false;
                }
            }
        }

        /**
        * Этот метод вызывается системой для определение ссылки на редактирование объекта
        *
        * @param String $objectId идентификатор объекта, над которым можно совершить действия
        * @param String $baseTypeName базовый метод, связанный с типом данных этого объекта
        * @return String ссылка на редактирование конкретного объекта
        */
        public function getObjectEditLink($objectId, $baseTypeName) {
             return $this->pre_lang . "/admin/mymodule/editobject/{$objectId}/";
        }

        /**
        * Этот метод вызывается системой для определение ссылки на редактирование типа данных
        * а также определения ссылки на добавление подтипа к текущему типу
        *
        * @param String $typeId идентификатор объекта, над которым можно совершить действия
        * @return Array где элемент с ключом create-link определяет ссылку на добавление подтипа, а 
        *               элемент с ключом edit-link - на редактирование переданого типа, если какое-либо
        *               из действий недоступно, присвойте ключу значение false
        */
        public function getObjectTypeEditLink($typeId) {
             return array(
                         'create-link' => $this->pre_lang . "/admin/mymodule/addtype/{$typeId}/",
                         'edit-link'   => $this->pre_lang . "/admin/mymodule/edittype/{$typeId}/",
                         );
        }

        public function page($i_curr_page = false) {
            // реализация метода page
            // этот публичный метод также является макросом
            // его можно вызвать:
            // - "напрямую" http://example.com/mymodule/page - тогда он выполнится в дефолтном шаблоне
            // - в tpl-шаблоне, напрмер так %mymodule page('%pid%')%
            // - в xslt-шаблоне document('udata://mymodule/page/1234')
            
            // TODO: реализация метода
            return "Hello world!";
        }


    };
?>