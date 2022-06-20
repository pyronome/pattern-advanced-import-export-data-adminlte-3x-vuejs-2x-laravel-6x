        // advied permissions begin
        if ('undefined' !== typeof plugins_permissions.__advied_permissions) {
            let __advied_permissions = plugins_permissions.__advied_permissions;

            if (__advied_permissions['is_admin'] || __advied_permissions['import'] || __advied_permissions['export']) {
                $('li.nav-item.menu-nav-item[data-href="__advanced_plugin"]').css("display", "block");
            }

            if (__advied_permissions['is_admin'] || __advied_permissions['import']) {
                $('li.nav-item.menu-nav-item[data-href="wisiloadvied_import"]').css("display", "block");
            }

            if (__advied_permissions['is_admin'] || __advied_permissions['export']) {
                $('li.nav-item.menu-nav-item[data-href="wisiloadvied_export"]').css("display", "block");
            }

            if (__advied_permissions['is_admin']) {
                $('.sbp-item[advied-permission-token="advied_admin"]').removeClass('sbp-hide');
            }
        }
        // advied permissions end