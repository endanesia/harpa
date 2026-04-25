<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HARPA - ICCN SSO Error</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        .error-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .error-icon {
            text-align: center;
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .error-message {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            color: #856404;
        }
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #6c757d;
        }
        .debug-info strong {
            display: block;
            margin-bottom: 5px;
            color: #495057;
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h2>ICCN SSO Authentication Error</h2>
        
        <div class="error-message">
            <strong>Error:</strong> <?= htmlspecialchars($error_message) ?>
        </div>

        <div class="debug-info">
            <strong>Debug Information:</strong>
            Token parameter: <?= $this->input->get('t') ? 'Present (' . strlen($this->input->get('t')) . ' chars)' : 'Not found' ?><br>
            Current URL: <?= current_url() ?><br>
            User Agent: <?= $this->input->user_agent() ?><br>
            Time: <?= date('Y-m-d H:i:s') ?>
        </div>

        <div class="actions">
            <a href="<?= site_url('iccn/iframe') ?>" class="btn">Try Again</a>
            <a href="<?= $fallback_url ?>" class="btn btn-secondary">Back to ICCN</a>
        </div>
    </div>

    <script>
    // Log untuk debugging
    console.log('ICCN SSO Error:', <?= json_encode($error_message) ?>);
    console.log('Token param:', <?= json_encode($this->input->get('t') ? 'present' : 'missing') ?>);
    console.log('Current URL:', window.location.href);
    </script>
</body>
</html>
