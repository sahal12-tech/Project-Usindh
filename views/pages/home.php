<?php
/**
 * Home Page View
 */

// Set page title
$title = 'Home';
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Welcome to Faculty Website</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['logged_in']): ?>
                        <div class="alert alert-info">
                            <h5>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</h5>
                            <p>You are logged in as a <strong><?php echo ucfirst($_SESSION['user_role'] ?? 'guest'); ?></strong>.</p>
                            <a href="/dashboard" class="btn btn-outline-primary">Go to Dashboard</a>
                        </div>
                    <?php else: ?>
                        <h2 class="text-center mb-4">Faculty Management System</h2>
                        <p class="text-center">
                            A comprehensive solution for managing departments, facilities, teachers, and user profiles in educational institutions.
                        </p>
                        <div class="text-center mt-4">
                            <a href="/login" class="btn btn-primary me-3">Login</a>
                            <a href="/register" class="btn btn-outline-primary">Register</a>
                        </div>
                        <div class="mt-5 pt-4 border-top">
                            <h5>Key Features:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Department Management</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Facilities Management</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Teacher Profiles</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Role-Based Access Control</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Profile Management</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Responsive Design</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>