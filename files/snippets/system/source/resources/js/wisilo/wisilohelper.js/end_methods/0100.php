    ,
    "hasUserADVIEDAuthorized": function(page_variables, token="") {
        var authorize = {};
        authorize["status"] = true;
        authorize["type"] = "";
        authorize["msg"] = "";

        if (page_variables.is_admin) {
            return authorize;
        }

        if ('undefined' === typeof page_variables.plugins_permissions) {
            authorize["status"] = false;
            authorize["type"] = "custom";
            authorize["msg"] = "Plugin permissions are undefined.";
            return authorize;
        }

        if ('undefined' === typeof page_variables.plugins_permissions.__advied_permissions) {
            authorize["status"] = false;
            authorize["type"] = "custom";
            authorize["msg"] = "Advanced Import/Export Data permissions are undefined.";
            return authorize;
        }

        let __advied_permissions = page_variables.plugins_permissions.__advied_permissions;

        if (__advied_permissions['is_admin']) {
            return authorize;
        }

        if ("" != token) {
            if ("import" == token) {
                if (!__advied_permissions['import']) {
                    authorize["status"] = false;
                    authorize["type"] = "custom";
                    authorize["msg"] = "You haven't access import page.";
                    return authorize;
                }
            } else if ("export" == token) {
                if (!__advied_permissions['export']) {
                    authorize["status"] = false;
                    authorize["type"] = "custom";
                    authorize["msg"] = "You haven't access export page.";
                    return authorize;
                }
            } else {
                // importtemplate & exporttemplate pages
                authorize["status"] = false;
                authorize["type"] = "custom";
                authorize["msg"] = "You haven't access this page.";
                return authorize;
            }
        }

        return authorize;
    }