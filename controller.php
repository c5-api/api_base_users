<?php defined('C5_EXECUTE') or die("Access Denied.");

class ApiBaseUsersPackage extends Package {

	protected $pkgHandle = 'api_base_users';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '0.9';

	public function getPackageName() {
		return t("Api:Base:Users");
	}

	public function getPackageDescription() {
		return t("Get information about specific users");
	}

	public function on_start() {
		Config::getAndDefine('C5_API_USERS_LIMIT', 50);
		Config::getAndDefine('C5_API_USERS_LIMIT_DEFAULT', 10);

		$classes = array();
		$classes['ApiUsersRouteModel'] = array('model', 'api/route/users', 'api_base_users');

		Loader::registerAutoload($classes);
	}

	public function install() {
		$this->on_start();
		$installed = Package::getByHandle('api');
		if(!is_object($installed)) {
			throw new Exception(t('Please install the "API" package before installing %s', $this->getPackageName()));
		}

		parent::install();

		$pkg = Package::getByHandle($this->pkgHandle);
		ApiRoute::add('users', t('List users and get information about different users'), $pkg);

		$p = SinglePage::add('/dashboard/api/settings/users',$pkg);
		$p->update(array('cName'=> '/users'));

		$sel = array();
		$sel['user'][] = 'uID';
		$sel['user'][] = 'uDateAdded';
		$sel['user'][] = 'uIsActive';
		$sel['user'][] = 'uName';

		ApiUsersRouteModel::saveSelected($sel);

		ApiUsersRouteModel::saveType();//whitelist
	}
	
	public function uninstall() {
		ApiRouteList::removeByPackage($this->pkgHandle);//remove all the apis
		parent::uninstall();
	}

}