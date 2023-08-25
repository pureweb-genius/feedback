<?php

return [

	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
    'login'=>[
        'controller' => 'account',
        'action' => 'login',
    ],
    'logout'=>[
        'controller' => 'account',
        'action' => 'logout',
    ],

    'review' => [
        'controller' => 'review',
        'action' => 'index',
    ],
    'review/store'=>[
        'controller' => 'review',
        'action' => 'store',
    ],
    'review/load'=>[
        'controller' => 'review',
        'action' => 'load',
    ],
    'review/delete'=>[
        'controller' => 'review',
        'action' => 'delete',
    ],
    'review/update'=>[
        'controller' => 'review',
        'action' => 'update',
    ],

	
];