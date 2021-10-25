    public function getAdviedPermissionConfig() {
		$permission_items = [];

		$index = 0;
        $permission_items[$index]['meta_key'] = '__advied_permissions';
        $permission_items[$index]['title'] = __('Advanced Import Export Data');
		
		$item_index = 0;
        $permission_items[$index]['items'][$item_index]['value'] = 'advied_admin';
        $permission_items[$index]['items'][$item_index]['title'] = 'Admin';
		
		return $permission_items;
	}

	public function isAdviedAdmin($token) {
        if (Gate::allows('isAdmin'))
        {
            return true;
        }
        
        $userPermissions = $this->getUserPermissionData();
		$has_permission = false;

        if (isset($userPermissions['__advied_permissions']) && isset($userPermissions['__advied_permissions'][$token])) {
            $has_permission = ('Y' == $userPermissions['__advied_permissions'][$token]);
        }

        return $has_permission;
    }