<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Untitled project',
    'language'=>'ru',
    'sourceLanguage'=>'ru',
    'theme'=>'front',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.helpers.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.vendors.phpexcel.PHPExcel',
        'application.components.shoppingCart.*',
				'application.extensions.yiidebugtb.*', 
	),





	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'11111',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

        'jbackup'=>array(
            'path' => __DIR__.'/../../_backup/', //Directory where backups are saved
            'layout' => '//layouts/column2', //2-column layout to display the options
            'filter' => 'accessControl', //filter or filters to the controller
            'bootstrap' => false, //if you want the module use bootstrap components
            'download' => true, // if you want the option to download
            'restore' => true, // if you want the option to restore
            'database' => true, //whether to make backup of the database or not
            //directory to consider for backup, must be made array key => value array ($ alias => $ directory)
            'directoryBackup'=>array(
                'folder/'=> __DIR__.'/../folder/',
            ),
            //directory sebe not take into account when the backup
            'excludeDirectoryBackup'=>array(
                __DIR__.'/../folder/folder2/',
            ),
            //files sebe not take into account when the backup
            'excludeFileBackup'=>array(
                __DIR__.'/../folder/folder1/cfile.png',
            ),
            //directory where the backup should be done default Yii::getPathOfAlias('webroot')
            'directoryRestoreBackup'=>__DIR__.'/../../'
        ),

        'user'=>array(
            'hash' => 'md5',
            'sendActivationMail' => true,
            'loginNotActiv' => false,
            'activeAfterRegister' => false,
            'autoLogin' => true,
            'registrationUrl' => array('/user/registration'),
            'recoveryUrl' => array('/user/recovery'),
            'loginUrl' => array('/user/login'),
            'returnUrl' => array('/site'),
            'returnLogoutUrl' => array('/user/login'),
        ),

	),

	// application components
	'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        /*'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),*/
		// uncomment the following to use a MySQL database

		'db'=>array(
        'connectionString' => 'mysql:host=localhost;dbname=pos',
    'emulatePrepare'   => true,
    'username'         => 'root',
    'password'         => '',
    'charset'          => 'utf8',
    'tablePrefix'      => 'stock_',
    'schemaCachingDuration'=> 3600,
    // включаем профайлер
    'enableProfiling'=>true,
    // показываем значения параметров
    'enableParamLogging' => true,
    
/*  
			'connectionString' => ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') ? 'mysql:host=localhost;dbname=ital
' : 'mysql:host=mysql24.hosting.ua;dbname=cqr-off_buhgalter',
			'emulatePrepare' => true,
			'username' => ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') ? 'root' : 'cqr-off_buhgalte',
			'password' => ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') ? '' : 'Gogogo88',
			'charset' => 'utf8',
      'tablePrefix'=>'stock_',
      'enableParamLogging'=>true,
*/ 
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes' => array(
        array(
            'class' => 'CWebLogRoute',
            'categories' => 'application',
            'levels'=>'error, warning, trace, profile, info',
        ),
        array( // configuration for the toolbar
          'class'=>'XWebDebugRouter',
          'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
          'levels'=>'error, warning, trace, profile, info',
          'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
        ),
			),
		),
    
  'shoppingCart' =>
    array(
        'class' => 'application.components.shoppingCart.EShoppingCart',
    ),


	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'bra1nwave@yandex.ua',
	),
);
