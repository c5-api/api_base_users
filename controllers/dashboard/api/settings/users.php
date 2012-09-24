<?php defined('C5_EXECUTE') or die('Access Denied');

class DashboardApiSettingsUsersController extends DashboardBaseController {
	
	public function view($updated = false) {
		if($updated) {
			switch ($updated) {
				case 'saved':
					$this->set('success', t('Settings Saved'));
					break;

				case 'invalid_token':
					$this->set('error', Loader::helper('validation/token')->getErrorMessage());
					break;
			}
		}

		$list = ApiUsersRouteModel::populateList();
		$selected = ApiUsersRouteModel::getSelected();

		$this->set('types', array_keys($list));
		$this->set('list', $list);
		$this->set('selected', $selected);

	}

	public function save() {
		ApiUsersRouteModel::saveSelected($this->post());
		$this->redirect('/dashboard/api/settings/users', 'saved');
	}

}