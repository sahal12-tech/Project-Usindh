<?php
/**
 * Base Model
 * Provides common database functionality for all models
 */

class Model {
    /**
     * Database connection
     * @var PDO
     */
    protected $db;

    /**
     * Constructor - initialize database connection
     */
    public function __construct() {
        $this->db = getDb(); // Get the global PDO instance from Database.php
    }
}
?>