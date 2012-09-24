<?php defined('C5_EXECUTE') or die('Access Denied');

class UsersApiRouteController extends ApiRouteController {

	public function run($ID = false) {
		$int = Loader::helper('validation/numbers');
		switch (API_REQUEST_METHOD) {
			case 'GET':
				if($ID && $ID != 0) {
					if($int->integer($ID)) {
						return $this->getUser($ID);
					} else {
						$this->setCode(400);
						$this->respond(array('error' => 'Bad Request'));
					}
				} else {
					return $this->getList();
				}
			
			default: //BAD REQUEST
				$this->setCode(400);
				$this->respond(array('error' => 'Bad Request'));
		}
	}

	private function getUser($ID) {
		$user = UserInfo::getByID($ID); //get the super complicated user object
		if(!is_object($user) || $user->isError()) { //lets check if this user exists...
			$this->setCode(404); //NOPE time to 404!
			$this->respond(array('error' => 'User Not Found'));
		}
		return $this->cleanUser($user);

	}

	private function getList() {

		$maxlimit = C5_API_USERS_LIMIT;
		$limit = C5_API_USERS_LIMIT_DEFAULT;
		$offset = 0;

		if(isset($_GET['limit']) && $_GET['limit'] > 0 && $_GET['limit'] <= $maxlimit) {
			$limit = $_GET['limit'];
		}
		if(isset($_GET['offset']) && $_GET['offset'] > 0) {
			$offset = $_GET['offset'];
		}	

		$pl = new UserList();
		
		$list = $pl->get($limit, $offset);
		//$list = $pl->get(2, $offset);
		$nlist = array();
		foreach($list as $user) {
			$nlist[] = $this->cleanUser($user);
		}
		//print_r($nlist);
		return $nlist;

	}

	private function cleanUser($user) {
		print_r($user);exit;
		$attributes = UserAttributeKey::getList();
		$natt = array();
		foreach($attributes as $att) {
			$val = $user->getAttribute($att->getAttributeKeyHandle());
			$natt[$att->getAttributeKeyHandle()] = (string) $val;
		}
		$attr = array('attributes' => $natt);
		$pobj = $this->filterObject($user, array('uID', 'uDateAdded', 'uIsActive', 'uName', 'uEmail', 'uTimezone'));
		return $this->object_merge($pobj, $attr);
	}

}