<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class HostRelationModel extends RelationModel {
	protected $tableName = 'host';

	protected $_link = array(
			'service' => array(
					'class_name' => 'service',
					'mapping_type' => self::MANY_TO_MANY,
					'foreign_key' => 'host_id',
					'relation_foreign_key' => 'service_id',
					'relation_table' => 'ops_service_host'
				),
			'system' => array(
					'class_name' => 'system',
					'mapping_type' => self::MANY_TO_MANY,
					'foreign_key' => 'host_id',
					'relation_foreign_key' => 'system_id',
					'relation_table' => 'ops_system_host'
				),
			'env' => array(
					'class_name' => 'env',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'env_id'
				)
		);
}