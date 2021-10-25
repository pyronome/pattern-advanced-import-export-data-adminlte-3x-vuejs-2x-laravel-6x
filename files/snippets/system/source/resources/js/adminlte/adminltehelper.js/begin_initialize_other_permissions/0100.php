        // advied permissions begin
        if ('undefined' !== typeof page_variables.permissions.__advied_permissions) {
            let advied_permissions = page_variables.permissions.__advied_permissions;
            Object.keys(advied_permissions).map((key) => {
                if (advied_permissions[key]) {
                    $('.sbp-item[advied-permission-token="' + key + '"]').removeClass('sbp-hide').addClass('sbp-show');
                } else {
                    $('.sbp-item[advied-permission-token="' + key + '"]').addClass('sbp-hide').removeClass('sbp-show');
                }
            });
        }
        // advied permissions end