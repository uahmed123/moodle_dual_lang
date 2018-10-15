<?php
// /////////////////////////////////////////////////////////////////////////
// //
// Moodle configuration file //
// //
// This file should be renamed "config.php" in the top-level directory //
// //
// /////////////////////////////////////////////////////////////////////////
// //
// NOTICE OF COPYRIGHT //
// //
// Moodle - Modular Object-Oriented Dynamic Learning Environment //
// http://moodle.org //
// //
// Copyright (C) 1999 onwards Martin Dougiamas http://moodle.com //
// //
// This program is free software; you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 3 of the License, or //
// (at your option) any later version. //
// //
// This program is distributed in the hope that it will be useful, //
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the //
// GNU General Public License for more details: //
// //
// http://www.gnu.org/copyleft/gpl.html //
// //
// /////////////////////////////////////////////////////////////////////////
unset($CFG); // Ignore this line
global $CFG; // This is necessary here for PHPUnit execution
$CFG = new stdClass();
// =========================================================================
// 1. DATABASE SETUP
// =========================================================================
// First, you need to configure the database where all Moodle data //
// will be stored. This database must already have been created //
// and a username/password created to access it. //
$CFG->dbtype = 'mysqli'; // 'pgsql', 'mariadb', 'mysqli', 'mssql', 'sqlsrv' or 'oci'
$CFG->dblibrary = 'native'; // 'native' only at the moment
// Because we are using a custom image the repo name is appended to the container name.
$CFG->dbhost = 'caperneoignis-mysql'; // eg 'localhost' or 'db.isp.com' or IP
$CFG->dbname = 'moodle'; // database name, eg moodle
$CFG->dbuser = 'moodle'; // your database username
$CFG->dbpass = 'm@0dl3ing'; // your database password
$CFG->prefix = 'mdl_'; // prefix to use for all table names
$CFG->dboptions = array('dbpersist' => false, // should persistent database connections be
    // used? set to 'false' for the most stable
    // setting, 'true' can improve performance
    // sometimes
    'dbsocket' => false, // should connection via UNIX socket be used?
    // if you set it to 'true' or custom path
    // here set dbhost to 'localhost',
    // (please note mysql is always using socket
    // if dbhost is 'localhost' - if you need
    // local port connection use '127.0.0.1')
    'dbport' => '', // the TCP port number to use when connecting
    // to the server. keep empty string for the
    // default port
    'dbhandlesoptions' => false, // On PostgreSQL poolers like pgbouncer don't
    // support advanced options on connection.
    // If you set those in the database then
    // the advanced settings will not be sent.
    'dbcollation' => 'utf8mb4_unicode_ci'
);

// =========================================================================
// 2. WEB SITE LOCATION
// =========================================================================
// Now you need to tell Moodle where it is located. Specify the full
// web address to where moodle has been installed. If your web site
// is accessible via multiple URLs then choose the most natural one
// that your students would use. Do not include a trailing slash
//
// If you need both intranet and Internet access please read
// http://docs.moodle.org/en/masquerading
$CFG->wwwroot = 'http://localhost';
// =========================================================================
// 3. DATA FILES LOCATION
// =========================================================================
// Now you need a place where Moodle can save uploaded files. This
// directory should be readable AND WRITEABLE by the web server user
// (usually 'nobody' or 'apache'), but it should not be accessible
// directly via the web.
//
// - On hosting systems you might need to make sure that your "group" has
// no permissions at all, but that "others" have full permissions.
//
// - On Windows systems you might specify something like 'c:\moodledata'
$CFG->dataroot = '/var/www/moodledata';
// =========================================================================
// 4. DATA FILES PERMISSIONS
// =========================================================================
// The following parameter sets the permissions of new directories
// created by Moodle within the data directory. The format is in
// octal format (as used by the Unix utility chmod, for example).
// The default is usually OK, but you may want to change it to 0750
// if you are concerned about world-access to the files (you will need
// to make sure the web server process (eg Apache) can access the files.
// NOTE: the prefixed 0 is important, and don't use quotes.
$CFG->directorypermissions = 02777;
// =========================================================================
// 5. DIRECTORY LOCATION (most people can just ignore this setting)
// =========================================================================
// A very few webhosts use /admin as a special URL for you to access a
// control panel or something. Unfortunately this conflicts with the
// standard location for the Moodle admin pages. You can work around this
// by renaming the admin directory in your installation, and putting that
// new name here. eg "moodleadmin". This should fix all admin links in Moodle.
// After any change you need to visit your new admin directory
// and purge all caches.
$CFG->admin = 'admin';
// =========================================================================
// 9. PHPUNIT SUPPORT
// =========================================================================
$CFG->phpunit_prefix = 'phpu_';
$CFG->phpunit_dataroot = '/var/www/phpunitdata';
$CFG->phpunit_directorypermissions = 02777; // optional
$CFG->phpunit_profilingenabled = true;
$CFG->proxyhost = '10.168.1.114';
$CFG->proxyport = '3128';
$CFG->proxytype = 'HTTP';
$CFG->proxybypass = '10.168.1.114,10.168.2.132,localhost,127.0.0.1,.ice.dhs.gov,10.168.2.253,gitlabnonprod.sevismod.ice.dhs.gov';
// optional to profile PHPUnit runs.
// =========================================================================
// 11. BEHAT SUPPORT
// =========================================================================
// Behat test site needs a unique www root, data directory
// and database prefix:
//

$CFG->behat_wwwroot = 'http://127.0.0.1';
$CFG->behat_dataroot = '/var/www/behatdata';
$CFG->behat_faildump_path = '/var/www/behatfaildumps';
$CFG->behat_prefix = 'bht_';
// We need this for CI/CD where we set run numbers.
$run = '';
$run = getenv('RUN', true) ?: getenv('RUN');
$tRun = getenv('TOTAL_RUNS', true) ?: getenv('TOTAL_RUNS');
$base_url = $CFG->behat_wwwroot;

// Have to leave parallel run stuff in here, because it will cause single run to mess up.
if ($run) {
    /*
     * most we will ever have is 10 but we are only running one at once, so this should work.
     * in other words, I'm trying to force it to use the defaults, because we will not be doing more then
     * one per runner.
     */
    for ($i = 1; $i <= 10; $i++) {
        $configs[] = array(
            'behat_wwwroot' => $CFG->behat_wwwroot,
            'behat_dataroot' => "/var/www/behatdata/behatrun",
            'behat_prefix' => 'bht_',
            'wd_host' => '',
        );
    }
    $CFG->behat_parallel_run = $configs;
}


$CFG->behat_config = [
    'default' => [
        'extensions' => ['DMore\ChromeExtension\Behat\ServiceContainer\ChromeExtension' => [],
            'Behat\MinkExtension' => ['browser_name' => 'chrome',
                'base_url' => $base_url, 'goutte' => null, 'selenium2' => null,
                'sessions' => [
                    'javascript' => [
                        // This needs to be set to localhost!!!!
                        'chrome' => ['api_url' => 'http://127.0.0.1:9222',
                            'download_behavior' => 'allow',
                            'download_path' => '/download',
                            'validate_certificate' => false]
                    ]
                ]
            ]
        ]
    ]
];
// =========================================================================
// ALL DONE! To continue installation, visit your main page with a browser
// =========================================================================
require_once(__DIR__ . '/lib/setup.php'); // Do not edit
// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
