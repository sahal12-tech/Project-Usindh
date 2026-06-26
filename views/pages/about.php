<?php
/**
 * About Page View
 */

// Set page title
$title = 'About Us';
?>
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2>About Our Faculty Management System</h2>
            <p class="lead">
                This is a comprehensive faculty management system designed to streamline academic administration
                and improve communication between faculty, students, and administrative staff.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title">Our Mission</h3>
                    <p class="card-text">
                        To provide an efficient, user-friendly platform that enhances the educational experience
                        through better organization, communication, and resource management.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title">Key Features</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Department Management
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Facilities Management
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Teacher Profiles & Portfolios
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Role-Based Access Control
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Secure Authentication
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>System Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="display-4 text-primary"><?php echo rand(10, 50); ?></div>
                                <small>Departments</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="display-4 text-success"><?php echo rand(50, 200); ?></div>
                                <small>Teachers</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="display-4 text-info"><?php echo rand(5, 25); ?></div>
                                <small>Facilities</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="display-4 text-warning"><?php echo rand(100, 500); ?></div>
                                <small>Students</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>