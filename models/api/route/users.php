<?php defined('C5_EXECUTE') or die('Access Denied');

class ApiUsersRouteModel extends Object {
	public static function populateList() {
		$a = array();
		$a['user']['uID'] = t('User ID');
		$a['user']['uLastLogin'] = t('Last Login');
		$a['user']['uLastIP'] = t('Last IP');
		$a['user']['uIsValidated'] = t('Is Validated');
		$a['user']['uPreviousLogin'] = t('Previous Login');
		$a['user']['uIsFullRecord'] = t('Is Complete Profile');
		$a['user']['uNumLogins'] = t('Number of Logins');
		$a['user']['uDateAdded'] = t('Date Added');
		$a['user']['uIsActive'] = t('Is Active');
		$a['user']['uLastOnline'] = t('Last Online');
		$a['user']['uHasAvatar'] = t('Has Avatar');
		$a['user']['uName'] = t('Username');
		$a['user']['uEmail'] = t('Email');
		//$a['user']['uPassword'] = t('Hashed Password');
		$a['user']['uTimezone'] = t('Timezone');


		$a['attributes'] = self::populateAttributes();
		return $a;
	}

	public static function populateAttributes() {
		$attributes = UserAttributeKey::getList();
		$a = array();
		foreach($attributes as $attr) {
			$a[$attr->getAttributeKeyHandle()] = $attr->getAttributeKeyName();
		}
		return $a;
	}

	public static function getSelected() {
		$pkg = Package::getByHandle('api_base_users');
		$conf = $pkg->config('SELECTED');
		return unserialize($conf);
	}

	public static function saveSelected($conf) {
		$ser = serialize($conf);
		$pkg = Package::getByHandle('api_base_users');
		$pkg->saveConfig('SELECTED', $ser);
	}

	public static function saveType($type = 'whitelist') {
		$pkg = Package::getByHandle('api_base_users');
		$pkg->saveConfig('TYPE', $type);
	}

	public static function getType() {
		$pkg = Package::getByHandle('api_base_users');
		$conf = $pkg->config('TYPE');
		return $conf;
	}
}