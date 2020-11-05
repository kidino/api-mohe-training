<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Application</title>
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style>
    .status {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 20px 30px;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>Your Application Status</h3>
                <p class="text-right"><a href="/logout">LOGOUT</a></p>
                
                <div class="status">
                <?php echo $application_status; ?>                    
                </div>

            </div>
        </div>
    </div>
</body>
</html>