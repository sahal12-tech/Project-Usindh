<?php
/**
 * Department Model
 * Handles department data operations
 */

class Department extends Model {
    /**
     * Table name
     */
    protected $table = 'departments';

    /**
     * Get all departments
     * @return array List of departments
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY name");
        return $stmt->fetchAll();
    }

    /**
     * Get department by ID
     * @param int $id Department ID
     * @return array|false Department data or false if not found
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Count all departments
     * @return int Number of departments
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM {$this->table}");
        $result = $stmt->fetch();
        return (int)$result['count'];
    }

    /**
     * Create a new department
     * @param array $data Department data
     * @return int ID of the newly created department
     */
    public function create($data) {
        // Add timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Build the query
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    /**
     * Update department
     * @param int $id Department ID
     * @param array $data Data to update
     * @return bool Success status
     */
    public function update($id, $data) {
        // Add updated timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Build the SET clause
        $setClause = '';
        $params = [];
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
            $params[":$key"] = $value;
        }
        $setClause = rtrim($setClause, ', ');

        // Add the ID parameter
        $params[':id'] = $id;

        $stmt = $this->db->prepare("UPDATE {$this->table} SET $setClause WHERE id = :id");
        return $stmt->execute($params);
    }

    /**
     * Delete department
     * @param int $id Department ID
     * @return bool Success status
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>