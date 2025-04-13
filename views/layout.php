<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php if (isset($css)) { echo '<link rel="stylesheet" href="'. $css .'">'; } ?>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title><?= $title ?? 'Music Magazine' ?></title>
</head>
<?php $theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : ''; ?>
<body <?php echo "class=" . $theme ?>>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <div id="notification-popup" class="notification-popup hidden">
        <span id="notification-message"></span>
        <span class="popup-close-btn" onclick="hideNotification()">
            <i class="bx bx-x"></i>
        </span>
        <div id="notification-progress" class="notification-progress"></div>
    </div>

    <div class="container">
        <?php include __DIR__ . '/partials/header.php'; ?>

        <main>
            <div class="main-container">

                <?= $content ?? '' ?>
                
            </div>
        </main>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>
    
    <!-- Import Script -->
    <script src="/assets/js/script.js"></script>
    <?php if (isset($js)) { echo '<script src="'. $js .'"></script>'; } ?>
    <!-- Import Show Notication Popup Script -->
    <?php if (!empty($_SESSION['notify'])): ?>
        <script>
            showNotification(
                <?= json_encode($_SESSION['notify']['message']) ?>,
                <?= $_SESSION['notify']['type'] === 'success' 
                    ? json_encode('#4caf50') 
                    : json_encode('#f44336') ?>
            );
        </script>
        <?php unset($_SESSION['notify']); ?>
    <?php endif; ?>

</body>
</html>