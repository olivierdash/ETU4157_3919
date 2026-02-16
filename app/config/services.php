<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use flight\debug\tracy\TracyExtensionLoader;
use Tracy\Debugger;

/*********************************************
 *         FlightPHP Service Setup           *
 *********************************************
 * This file registers services and integrations
 * for your FlightPHP application. Edit as needed.
 *
 * @var array  $config  From config.php
 * @var Engine $app     FlightPHP app instance
 **********************************************/

/*********************************************
 *           Tracy Debugger Setup            *
 **********************************************/
Debugger::enable(); // Auto-detects environment
Debugger::$logDirectory = __DIR__ . '/../log'; // Fixed: removed undefined $ds variable
Debugger::$strictMode = true;
// Debugger::$maxLen = 1000;
// Debugger::$maxDepth = 5;
// Debugger::$editor = 'vscode';
// Debugger::$email = 'your@email.com';

if (Debugger::$showBar === true && php_sapi_name() !== 'cli') {
	(new TracyExtensionLoader($app));
}

/**********************************************
 *           Database Service Setup           *
 **********************************************/
// PostgreSQL Configuration
$dsn = 'pgsql:host=' . $config['database']['host'] 
     . ';port=' . ($config['database']['port'] ?? 5432) 
     . ';dbname=' . $config['database']['dbname'];

// PDO Options - Important for proper connection handling
$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Fetch associative arrays by default
    PDO::ATTR_EMULATE_PREPARES => false,  // Use real prepared statements
    PDO::ATTR_STRINGIFY_FETCHES => false,  // Keep data types (don't convert to strings)
];

// Use PdoQueryCapture in development for query logging, PdoWrapper in production
$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;

// Register the database service with all parameters
$app->register('db', $pdoClass, [ 
    $dsn, 
    $config['database']['user'] ?? null, 
    $config['database']['password'] ?? null,
    $pdoOptions,  // PDO options array
    Debugger::$showBar === true  // Track APM queries in development
]);

/**********************************************
 *         Third-Party Integrations           *
 **********************************************/
// Add service registrations below as needed
// Google OAuth Example:
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis Example:
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);