<?php
return array(
        'TMPL_PARSE_STRING' =>array(
                '__PUBLIC__' => '/Application/Admin/View/Public'
                ),
        'URL_MODEL'                => '2',
        'URL_CASE_INSENSITIVE'         => false,
        'SESSION_OPTIONS' => array('type'=>'Db','expire'=>'3600'),
        'TMPL_ACTION_ERROR'     =>  'Public/tpl/msg',
        'TMPL_ACTION_SUCCESS'   =>  'Public/tpl/msg',

        'RBAC_SUPERADMIN'               =>      'admin',
        'ADMIN_AUTH_KEY'                =>      'superadmin',
        'USER_AUTH_ON'                  =>      true,
        'USER_AUTH_TYPE'                =>      1,
        'USER_AUTH_KEY'                 =>      'uid',
        'NOT_AUTH_MODULE'               =>      '',
        'NOT_AUTH_ACTION'               =>      'logout',
        'RBAC_ROLE_TABLE'               =>      'ops_role',
        'RBAC_USER_TABLE'               =>      'ops_role_user',
        'RBAC_ACCESS_TABLE'             =>      'ops_access',
        'RBAC_NODE_TABLE'               =>      'ops_node'

);
