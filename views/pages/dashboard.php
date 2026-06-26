<?php
/**
 * Dashboard View
 */

// Set page title
$title = 'Dashboard';
?>
<div class="container mt-4">
    <?php if (isset($_SESSION['user_id']) && $_SESSION['logged_in']): ?>
        <h1 class="mb-4">Dashboard</h1>
        <p class="lead">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</p>

        <?php if (isset($stats) && is_array($stats)): ?>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Departments</h5>
                            <p class="card-text display-4"><?php echo $stats['departments_count'] ?? 0; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Teachers</h5>
                            <p class="card-text display-4"><?php echo $stats['teachers_count'] ?? 0; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Facilities</h5>
                            <p class="card-text display-4"><?php echo $stats['facilities_count'] ?? 0; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark h-100">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text display-4"><?php echo $stats['users_count'] ?? 0; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $userRole = $_SESSION['user_role'] ?? '';
                        if ($userRole === 'admin' || $userRole === 'dean' || $userRole === 'hod'): ?>
                            <a href="/departments" class="btn btn-outline-primary w-100 mb-2">
                                <i class="fas fa-building me-2"></i> Manage Departments
                            </a>
                            <a href="/facilities" class="btn btn-outline-info w-100 mb-2">
                                <i class="fas fa-school me-2"></i> Manage Facilities
                            </a>
                            <a href="/teachers" class="btn btn-outline-success w-100 mb-2">
                                <i class="fas fa-chalkboard-teacher me-2"></i> Manage Teachers
                            </a>
                        <?php endif; ?>
                        <a href="/teachers" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-user-tag me-2"></i> Browse Faculty Directory
                        </a>
                        <a href="/facilities" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-map-marked-alt me-2"></i> Explore Campus Facilities
                        </a>
                        <a href="/profile" class="btn btn-outline-light w-100">
                            <i class="fas fa-user me-2"></i> My Profile
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">New department added</h6>
                                        <small class="text-muted">5 minutes ago</small>
                                    </div>
                                    <p class="mb-1">Computer Science department has been added to the system.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Teacher profile updated</h6>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                    <p class="mb-1">Professor John Smith updated his research interests.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">New facility registered</h6>
                                        <small class="text-muted">Yesterday</small>
                                    </div>
                                    <p class="mb-1">The new robotics lab is now available for booking.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h4>Please log in to access your dashboard</h4>
            <p class="mb-0">
                <a href="/login" class="alert-link">Click here to log in</a>
            </p>
        </div>
    <?php endif; ?>
</div>