<?php
/**
 * Teacher Model
 * Handles teacher data operations
 */

class Teacher extends Model {
    /**
     * Table name
     */
    protected $table = 'teachers';

    /**
     * Get all teachers
     * @return array List of teachers
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT t.*, d.name as department_name FROM {$this->table} t LEFT JOIN departments d ON t.department_id = d.id ORDER BY t.last_name, t.first_name");
        return $stmt->fetchAll();
    }

    /**
     * Get teacher by ID
     * @param int $id Teacher ID
     * @return array|false Teacher data or false if not found
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT t.*, d.name as department_name FROM {$this->table} t LEFT JOIN departments d ON t.department_id = d.id WHERE t.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Get teachers by department ID
     * @param int $departmentId Department ID
     * @return array List of teachers in the department
     */
    public function getByDepartment($departmentId) {
        $stmt = $this->db->prepare("SELECT t.*, d.name as department_name FROM {$this->table} t LEFT JOIN departments d ON t.department_id = d.id WHERE t.department_id = :departmentId ORDER BY t.last_name, t.first_name");
        $stmt->execute(['departmentId' => $departmentId]);
        return $stmt->fetchAll();
    }

    /**
     * Count all teachers
     * @return int Number of teachers
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM {$this->table}");
        $result = $stmt->fetch();
        return (int)$result['count'];
    }

    /**
     * Create a new teacher
     * @param array $data Teacher data
     * @return int ID of the newly created teacher
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
     * Update teacher
     * @param int $id Teacher ID
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
     * Delete teacher
     * @param int $id Teacher ID
     * @return bool Success status
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>