    ,
    "hasUserADVIEDAuthorized": function(page_variables, token="") {
        var authorize = {};
        authorize["status"] = true;
        authorize["type"] = "";

        if (page_variables.is_admin) {
            return authorize;
        }

        if ("" != token) {
            if (authorize["status"]) {
                if ('undefined' !== typeof page_variables.permissions.__advied_permissions) {
                    let advied_permissions = page_variables.permissions.__advied_permissions;
                    if (!advied_permissions[token]) {
                        authorize["status"] = ('Y' == advied_permissions[token]);
                        authorize["type"] = 'update_permission';
                        if (token.includes("view")) {
                            authorize["type"] = 'read_permission';
                        }
                    }
                }
            }
        }

        return authorize;
    }