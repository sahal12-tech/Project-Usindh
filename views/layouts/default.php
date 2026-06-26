<?php
/**
 * Default Layout Template
 * Combines header, content, and footer
 */

// Start output buffering to capture the content
ob_start();
include $contentView;
$content = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Faculty Website</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
</head>
<body>

    <!-- Header -->
    <?php include __DIR__ . '/header.php'; ?>

    <!-- Main Content -->
    <div class="container">
        <?php echo $content; ?>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . '/footer.php'; ?>

</body>
</html>