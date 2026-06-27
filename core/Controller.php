<?php
/**
 * Base Controller
 * Provides common functionality for all controllers
 */

class Controller {
    /**
     * Load a model
     * @param string $model Name of the model to load
     * @return object Model instance
     */
    public function model($model) {
        // Require the model file
        $modelFile = __DIR__ . '/../models/' . $model . '.php';
     * @param array $data Data to pass to the view
     */
    public function view($view, $data = []) {
        // Build absolute path to view file
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewFile)) {
            // Extract data to variables for easier access in the view
            extract($data);

            // Start output buffering
            ob_start();

            // Include the view file
            require_once $viewFile;

            // Get the buffered content
            $content = ob_get_clean();

            // Load the default layout and pass the content to it
            $layoutFile = __DIR__ . '/../views/layouts/default.php';
            if (file_exists($layoutFile)) {
                // Set the content variable for the layout
                $contentView = $content;
                require_once $layoutFile;
            } else {
                // If no layout file, just output the content
                echo $content;
            }
        } else {
            // If view doesn't exist, show an error
            die("View file not found: " . $viewFile);
        }
    }

    /**
     * Redirect to a different URL
     * @param string $url URL to redirect to
     */
    public function redirect($url) {
        // Add base URL if not already present
        if (strpos($url, "http") !== 0) {
            $url = BASE_URL . ltrim($url, "/");
        }
        header("Location: " . $url);
        exit;
    }

    /**
     * Check if user is logged in
     * @return bool True if logged in, false otherwise
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Check if user has required role
     * @param string|array $role Required role(s)
     * @return bool True if user has required role, false otherwise
     */
    protected function hasRole($role) {
        if (!$this->isLoggedIn()) {
            return false;
        }

        $userRole = $_SESSION['user_role'] ?? '';

        if (is_array($role)) {
            return in_array($userRole, $role);
        } else {
            return $userRole === $role;
        }
    }

    /**
     * Require login - redirect to login page if not logged in
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Please log in to access this page';
            $this->redirect('/login');
        }
    }

    /**
     * Require role - redirect if user doesn't have required role
     */
    protected function requireRole($role) {
        $this->requireLogin();

        if (!$this->hasRole($role)) {
            $_SESSION['error'] = 'You do not have permission to access this page';
            $this->redirect('/dashboard');
        }
    }
}
?>