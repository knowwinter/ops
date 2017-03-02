<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class UserRelationModel extends RelationModel {
	protected $tableName = 'user';

	protected $_link = array(
			'role' => array(
					'class_name' => 'role',
					'mapping_type' => self::MANY_TO_MANY,
					'foreign_key' => 'user_id',
					'relation_foreign_key' => 'role_id',
					'relation_table' => 'ops_role_user'
				),
			'system' => array(
					'class_name' => 'system',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'system_id'

				),
			'project' => array(
					'class_name' => 'project',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'project_id'
				)
		);
}