<?php
/**
 * User Model
 * Handles user authentication and profile management
 */

class User extends Model {
    /**
     * Table name
     */
    protected $table = 'users';

    /**
     * Find user by email
     * @param string $email User's email
     * @return array|false User data or false if not found
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Find user by username
     * @param string $username Username
     * @return array|false User data or false if not found
     */
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    /**
     * Find user by ID
     * @param int $id User ID
     * @return array|false User data or false if not found
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Create a new user
     * @param array $data User data (username, email, password_hash, role, etc.)
     * @return int ID of the newly created user
     */
    public function create($data) {
        // Hash the password if provided as plain text
        if (isset($data['password']) && !isset($data['password_hash'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

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
     * Update user information
     * @param int $id User ID
     * @param array $data Data to update
     * @return bool Success status
     */
    public function update($id, $data) {
        // Hash password if provided as plain text
        if (isset($data['password']) && !isset($data['password_hash'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

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
     * Delete a user
     * @param int $id User ID
     * @return bool Success status
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Verify password
     * @param string $password Plain text password
     * @param string $hashed_password Hashed password from database
     * @return bool True if password matches
     */
    public function verifyPassword($password, $hashed_password) {
        return password_verify($password, $hashed_password);
    }

    /**
     * Count total users
     * @return int Number of users
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM {$this->table}");
        $result = $stmt->fetch();
        return (int)$result['count'];
    }
}
?>