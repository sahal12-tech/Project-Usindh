<?php
/**
 * 404 Error Page
 */

// Set page title
$title = 'Page Not Found';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Faculty Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="text-center">
            <h1 class="display-1">404</h1>
            <h2 class="mb-4">Page Not Found</h2>
            <p class="lead">
                The page you're looking for doesn't exist or has been moved.
            </p>
            <a href="/" class="btn btn-primary">Return to Homepage</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>