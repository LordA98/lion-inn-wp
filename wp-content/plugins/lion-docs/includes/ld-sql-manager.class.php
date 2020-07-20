<?php

// Needed for dbDelta foo 
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
// Debugging functions 
require_once(plugin_dir_path(__FILE__).'/ld-debug.php');

/**
 * Class to Manage Database
 */
class LDSQLManager {

    /**
     * WordPress Database Object
     */
    private $wpdb;
	
	/**
	 * LESQLManager Constructor
	 */
	public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    /**
     * Create the 4 Tables Needed for the Plugin
     */
    public function createTables() {
        $this->createTable("groups");
        $this->createTable("files");
        $this->createTable("docs");
        $this->createTable("default");
    }

    /**
     * Create a Database Table
     * 
     * @param string $table The name of the database to be created
     */
    private function createTable($table) {
        // Get correct SQL file
        $sql = file_get_contents( WP_PLUGIN_DIR  . "/lion-docs/assets/sql/create_" . $table . "_table.sql" );

        // Set table name
        $sql = str_replace("tableplaceholder", $this->wpdb->prefix . "ld_" . $table, $sql);

        // If sql contains a foreign key - add prefix
        if (strpos($sql, 'FOREIGN KEY') !== false) {
            $sql = str_replace("prefixplaceholder", $this->wpdb->prefix . "ld", $sql);
        }

        // Set charset 
        $sql = str_replace("charsetplaceholder", $this->wpdb->get_charset_collate(), $sql);

        // log_me($sql);

        dbDelta($sql);
    }

    /**
     * Remove Plugin Tables
     */
    public function deleteTables() {
        $this->deleteTable("default");
        $this->deleteTable("docs");
        $this->deleteTable("files");
        $this->deleteTable("groups");
    }

    /**
     * Delete a Database Table
     * 
     * @param string $table The name of the database to delete
     */
    private function deleteTable($table) {
        $sql = file_get_contents( WP_PLUGIN_DIR  . "/lion-docs/assets/sql/delete_table.sql" );

        // Set table name
        $sql = str_replace("tableplaceholder", $this->wpdb->prefix . "ld_" . $table, $sql);

        $this->wpdb->query($sql);
    }

    /**
     * Insert into Database
     * 
     * @param string $table Table to insert into
     * @param array $params To insert into database
     */
    public function insert($table, $params) {
        $table = $this->wpdb->prefix . "ld_" . $table;

        $this->wpdb->insert($table, $params);
    }
    
    /**
     * Get Data from Database
     * 
     * @param string $table Table to select from
     * @param array $where Where clause
     * 
     * @return array $menus All menu's in db 
     */
    public function get($table, $where = array()) {
        // If a where clause is provided, use SELECT WHERE
        if($where) {
            $sql = file_get_contents( WP_PLUGIN_DIR  . "/lion-docs/assets/sql/select_where_" . $table . ".sql" );

            $i = 0;
            $whereSql = "";
            foreach($where as $key => $value) {
                if($i++ == 0) {
                    $whereSql .= "{$key} = '{$value}'"; // one / first where clause
                } else {
                    $whereSql .= " AND {$key} = '{$value}'"; // multiple where clauses
                }
            }

            $sql = str_replace("where_placeholder", $whereSql, $sql);
        } else {
            $sql = file_get_contents( WP_PLUGIN_DIR  . "/lion-docs/assets/sql/select_all_" . $table . ".sql" );
        }

        // Replace db prefix placeholder in SQL 
        $sql = str_replace("prefixplaceholder", $this->wpdb->prefix . "ld", $sql);        

        // Run SELECT query
        $results = $this->wpdb->get_results($sql);

        return $results;
    }

    /**
     * Update data in the database
     * 
     * @param string $table Table to select from
     * @param array $params Fields and values to update
     * @param array $where Which row to update
     */
    public function update($table, $params, $where) {
        $table = $this->wpdb->prefix . "ld_" . $table;

        $this->wpdb->update($table, $params, $where);
    }

    /**
     * Delete from Database
     * 
     * @param string $table Table to delete from
     * @param array $where Where clause 
     */
    public function delete($table, $where) {
        $table = $this->wpdb->prefix . "ld_" . $table;

        $this->wpdb->delete($table, $where);
    }

    /**
     * Alter foreign keys checks for database
     */
    public function foreign_key_checks($value) {        
        $this->wpdb->query("SET FOREIGN_KEY_CHECKS=$value;");
    }

}
