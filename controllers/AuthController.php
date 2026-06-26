<?php
/**
 * Authentication Controller
 * Handles user authentication (login, logout, registration, profile)
 */

class AuthController extends Controller {
    /**
     * Show login page
     */
    public function login() {
        // If user is already logged in, redirect to dashboard
        if (isset($_SESSION['user_id']) && $_SESSION['logged_in']) {
            $this->redirect('/dashboard');
            return;
        }

        $this->view('auth/login');
    }

    /**
     * Process login form submission
     */
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Basic validation
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please fill in all fields';
            $_SESSION['old_email'] = $email;
            $this->redirect('/login');
            return;
        }

        // Find user by email
        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $_SESSION['error'] = 'Invalid email or password';
            $_SESSION['old_email'] = $email;
            $this->redirect('/login');
            return;
        }

        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            $_SESSION['error'] = 'Invalid email or password';
            $_SESSION['old_email'] = $email;
            $this->redirect('/login');
            return;
        }

        // Check if account is active
        if (empty($user['is_active']) || $user['is_active'] == 0) {
            $_SESSION['error'] = 'Your account has been deactivated. Please contact an administrator.';
            $this->redirect('/login');
            return;
        }

        // Login successful - set session variables
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();

        // Clear any old error messages
        unset($_SESSION['error']);
        unset($_SESSION['old_email']);

        // Redirect to dashboard
        $this->redirect('/dashboard');
    }

    /**
     * Show registration page
     */
    public function register() {
        // If user is already logged in, redirect to dashboard
        if (isset($_SESSION['user_id']) && $_SESSION['logged_in']) {
            $this->redirect('/dashboard');
            return;
        }

        $this->view('auth/register');
    }

    /**
     * Process registration form submission
     */
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'student';

        // Basic validation
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = 'Please fill in all fields';
            $this->redirect('/register');
            return;
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Passwords do not match';
            $this->redirect('/register');
            return;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password must be at least 6 characters long';
            $this->redirect('/register');
            return;
        }

        // Check if email already exists
        $userModel = $this->model('User');
        $existingUser = $userModel->findByEmail($email);

        if ($existingUser) {
            $_SESSION['error'] = 'Email address is already registered';
            $this->redirect('/register');
            return;
        }

        // Check if username already exists
        $existingUsername = $userModel->findByUsername($username);

        if ($existingUsername) {
            $_SESSION['error'] = 'Username is already taken';
            $this->redirect('/register');
            return;
        }

        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare user data
        $userData = [
            'username' => $username,
            'email' => $email,
            'password_hash' => $password_hash,
            'role' => $role,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Create new user
        $userId = $userModel->create($userData);

        if ($userId) {
            // Registration successful - log in the user automatically
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $username;
            $_SESSION['user_role'] = $role;
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();

            // Set success message
            $_SESSION['success'] = 'Registration successful! Welcome to the Faculty Website.';

            // Redirect to dashboard
            $this->redirect('/dashboard');
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
            $this->redirect('/register');
        }
    }

    /**
     * Logout user
     */
    public function logout() {
        // Destroy the session
        session_unset();
        session_destroy();

        // Redirect to login page
        $this->redirect('/login');
    }

    /**
     * Show user profile
     */
    public function profile() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id']) || !$_SESSION['logged_in']) {
            $this->redirect('/login');
            return;
        }

        // Get user data from model
        $userModel = $this->model('User');
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user) {
            // User not found in database (shouldn't happen if session is valid)
            session_destroy();
            $this->redirect('/login');
            return;
        }

        // Update session with latest user data
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];

        // Load profile view
        $this->view('auth/profile', ['user' => $user]);
    }

    /**
     * Update user profile
     */
    public function updateProfile() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id']) || !$_SESSION['logged_in']) {
            $this->redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
            return;
        }

        $userId = $_SESSION['user_id'];
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Get current user data
        $userModel = $this->model('User');
        $currentUser = $userModel->findById($userId);

        if (!$currentUser) {
            session_destroy();
            $this->redirect('/login');
            return;
        }

        // Validate current password if changing password
        if (!empty($new_password)) {
            if (empty($current_password)) {
                $_SESSION['error'] = 'Please enter your current password to change your password';
                $this->redirect('/profile');
                return;
            }

            if (!password_verify($current_password, $currentUser['password_hash'])) {
                $_SESSION['error'] = 'Current password is incorrect';
                $this->redirect('/profile');
                return;
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'New passwords do not match';
                $this->redirect('/profile');
                return;
            }

            if (strlen($new_password) < 6) {
                $_SESSION['error'] = 'New password must be at least 6 characters long';
                $this->redirect('/profile');
                return;
            }
        }

        // Check if email is being changed and if it's already taken by another user
        if ($email !== $currentUser['email']) {
            $existingUser = $userModel->findByEmail($email);
            if ($existingUser && $existingUser['id'] != $userId) {
                $_SESSION['error'] = 'Email address is already registered to another account';
                $this->redirect('/profile');
                return;
            }
        }

        // Check if username is being changed and if it's already taken by another user
        if ($username !== $currentUser['username']) {
            $existingUsername = $userModel->findByUsername($username);
            if ($existingUsername && $existingUsername['id'] != $userId) {
                $_SESSION['error'] = 'Username is already taken';
                $this->redirect('/profile');
                return;
            }
        }

        // Prepare update data
        $updateData = [
            'username' => $username,
            'email' => $email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Add password to update data if changing password
        if (!empty($new_password)) {
            $updateData['password_hash'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        // Update user in database
        if ($userModel->update($userId, $updateData)) {
            // Update session data
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $username;
            $_SESSION['last_activity'] = time();

            $_SESSION['success'] = 'Profile updated successfully';
            $this->redirect('/profile');
        } else {
            $_SESSION['error'] = 'Failed to update profile. Please try again.';
            $this->redirect('/profile');
        }
    }

    /**
     * Forgot password page (placeholder)
     */
    public function forgotPassword() {
        $this->view('auth/forgot_password');
    }

    /**
     * Reset password page (placeholder)
     */
    public function resetPassword() {
        $this->view('auth/reset_password');
    }
}
?>