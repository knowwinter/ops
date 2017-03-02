<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class SystemRelationModel extends RelationModel {
	protected $tableName = 'system';

	protected $_link = array(
			'deploy_rule' => array(
					'class_name' => 'deploy_rule',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'deploy_rule_id'

				),
			'service' => array(
					'class_name' => 'service',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'depend_service_id'
				),
			'project' => array(
					'class_name' => 'project',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'project_id'
				),
			'user' => array(
					'class_name' => 'user',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'owner_id'
				),
			'host' => array(
					'class_name' => 'host',
					'mapping_type' => self::MANY_TO_MANY,
					'foreign_key' => 'system_id',
					'relation_foreign_key' => 'host_id',
					'relation_table' => 'ops_system_host'
				),
		);
}