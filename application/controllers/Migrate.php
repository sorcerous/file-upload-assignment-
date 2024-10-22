<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Migration $migration
 * @property CI_Benchmark $benchmark
 * @property CI_Hooks $hooks
 * @property CI_Config $config
 * @property CI_Log $log
 * @property CI_Utf8 $utf8
 * @property CI_URI $uri
 * @property CI_Router $router
 * @property CI_Output $output
 * @property CI_Security $security
 * @property CI_Input $input
 * @property CI_Lang $lang
 * @property CI_DB_mysqli_driver $db
 */
class Migrate extends CI_Controller {
    // Change visibility to public for $db and other necessary properties
    public $benchmark;
    public $hooks;
    public $config;
    public $log;
    public $utf8;
    public $uri;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $db; // Make sure $db is public

    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index() {
        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migrations executed successfully!";
        }
    }
}
