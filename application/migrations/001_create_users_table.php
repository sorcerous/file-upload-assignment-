<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Users_Table extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => TRUE,
            ),
            'mobile_number' => array(
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => TRUE,
            ),
            'profile_picture' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            )
        ));
        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }
}
