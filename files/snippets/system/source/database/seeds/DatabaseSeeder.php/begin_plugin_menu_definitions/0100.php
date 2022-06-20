        $menu_item = [];
        $menu_item['text'] = 'Advanced';
        $menu_item['href'] = '__advanced_plugin';
        $menu_item['icon'] = 'fas fa-ad';
        $menu_item['visibility'] = 1;
        $menu_item['parent'] = '';
        array_push($menu, $menu_item);

        $menu_item = [];
        $menu_item['text'] = 'Import';
        $menu_item['href'] = 'wisiloadvied_import';
        $menu_item['icon'] = 'fas fa-file-upload';
        $menu_item['visibility'] = 1;
        $menu_item['parent'] = '__advanced_plugin';
        array_push($menu, $menu_item);

        $menu_item = [];
        $menu_item['text'] = 'Export';
        $menu_item['href'] = 'wisiloadvied_export';
        $menu_item['icon'] = 'fas fa-file-download';
        $menu_item['visibility'] = 1;
        $menu_item['parent'] = '__advanced_plugin';
        array_push($menu, $menu_item);

        $wisilo = new Wisilo();
        $wisilo->updateWisiloMenu($menu);