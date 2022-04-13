    // Advanced Import/Export Plugin
    public function hasAdviedPermission($token) {
        if (Gate::allows('isAdmin'))
        {
            return true;
        }
        
        $plugin_permissions = $this->getUserPluginsPermissions();
		$has_permission = false;

		if (isset($plugin_permissions['__advied_permissions'])) {
			$__advied_permissions = $plugin_permissions['__advied_permissions'];

			if (isset($__advied_permissions['is_admin'])) {
				if (1 == intval($__advied_permissions['is_admin'])) {
					$has_permission = true;
				}
			}
			
			if (!$has_permission) {
				if (isset($__advied_permissions[$token])) {
					if (1 == intval($__advied_permissions[$token])) {
						$has_permission = true;
					}
				}
			}
		}

        return $has_permission;
    }
    // Advanced Import/Export Plugin