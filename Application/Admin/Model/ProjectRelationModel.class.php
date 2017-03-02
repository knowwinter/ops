<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class ProjectRelationModel extends RelationModel {
	protected $tableName = 'project';

	protected $_link = array(
			'user' => array(
					'class_name' => 'user',
					'mapping_type' => self::BELONGS_TO,
					'foreign_key' => 'architect_id'
				),
			
		);
}