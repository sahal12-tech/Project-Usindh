<?php
/**
 * Facility Model
 * Handles facility data operations
 */

class Facility extends Model {
    /**
     * Table name
     */
    protected $table = 'facilities';

    /**
     * Get all facilities
     * @return array List of facilities
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY name");
        return $stmt->fetchAll();
    }

    /**
     * Get facilities by type
     * @param string $type Facility type (Computer Lab, Electronics Lab, Telecommunication Lab, Library)
     * @return array List of facilities of the specified type
     */
    public function getByType($type) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE type = :type ORDER BY name");
        $stmt->execute(['type' => $type]);
        return $stmt->fetchAll();
    }

    /**
     * Get facility by ID
     * @param int $id Facility ID
     * @return array|false Facility data or false if not found
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Count all facilities
     * @return int Number of facilities
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM {$this->table}");
        $result = $stmt->fetch();
        return (int)$result['count'];
    }

    /**
     * Create a new facility
     * @param array $data Facility data
     * @return int ID of the newly created facility
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
     * Update facility
     * @param int $id Facility ID
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
     * Delete facility
     * @param int $id Facility ID
     * @return bool Success status
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>