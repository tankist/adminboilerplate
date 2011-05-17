<?php

class Model_Mapper_Db_User extends Skaya_Model_Mapper_Db_Abstract {

	const TABLE_NAME = 'Users';

	protected $_mapperTableName = 'Users';

	public function getUserById($id) {
		$userTable = self::_getTableByName(self::TABLE_NAME);
		$userBlob = $userTable->fetchRowById($id);
		return $this->getMappedArrayFromData($userBlob);
	}

	public function getUsers($order = null, $count = null, $offset = null) {
		$userTable = self::_getTableByName(self::TABLE_NAME);
		$userBlob = $userTable->fetchAll(null, $order, $count, $offset);
		return $this->getMappedArrayFromData($userBlob);
	}

	public function getUsersPaginator($order = null) {
		$userTable = self::_getTableByName(self::TABLE_NAME);
		$select = $userTable->select();
		if ($order) {
			$select->order($this->_mapOrderStatement($order));
		}
		$paginator = Skaya_Paginator::factory($select, 'DbSelect');
		$paginator->addFilter(new Zend_Filter_Callback(array(
			'callback' => array($this, 'getMappedArrayFromData')
		)));
		return $paginator;
	}

	public function getUserByEmail($email) {
		$userTable = self::_getTableByName(self::TABLE_NAME);
		$userBlob = $userTable->fetchRowByEmail($email);
		return $this->getMappedArrayFromData($userBlob);
	}

}