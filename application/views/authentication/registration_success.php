<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application Received</title>
    <link rel="shortcut icon" href="<?php echo base_url('uploads/app_image/logo.png'); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/auth.css?v=' . APP_VERSION); ?>">

    <script>var base_url = '<?php echo base_url() ?>';</script>
</head>
<body>

    <div class="brand-panel">
        <div class="ring"></div>
        <div class="ring2"></div>
        <div class="brand-logo-wrap">
            <img src="<?php echo base_url('uploads/app_image/logo.png'); ?>" alt="Logo">
        </div>
        <h2 class="brand-title">Tahsin Academy</h2>
        <p class="brand-subtitle">Excellence In Deen &amp; Duniya</p>
    </div>

    <main class="form-panel" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 40px;">
        <div class="form-header" style="text-align: center; max-width: 400px;">
            <i class="far fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
            <h1>Application Received!</h1>
            <p style="font-size: 16px; line-height: 1.6; margin-top: 15px;">
                Thank you for applying for an account. Your credentials have been securely saved and are currently <strong>Pending Admin Approval</strong>. 
            </p>
            <p style="font-size: 14px; color: #666; margin-top: 15px;">
                You will be notified once the school administrator reviews and activates your account. You can then log in using your chosen Username and Password.
            </p>
            
            <a href="<?php echo base_url('authentication'); ?>" class="btn-auth" style="display: inline-block; text-decoration: none; margin-top: 30px;">
                Return to Login
            </a>
        </div>
    </main>

</body>
</html>
