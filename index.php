<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iframe Example</title>
    <style>
        /* Step 2: CSS to Style the Iframe */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .iframe-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none; /* Optional: Remove the border */
        }
    </style>
    <script>
        // Step 2: JavaScript to Auto-Refresh the Page
        function autoRefresh() {
            setTimeout(function() {
                location.reload();
            }, 600000); // 600000 milliseconds = 10 minutes
        }

        // Call the autoRefresh function when the page loads
        window.onload = autoRefresh;
    </script>
</head>
<body>
    <!-- Step 3: Iframe Container -->
    <div class="iframe-container">
        <iframe src="https://lookerstudio.google.com/embed/reporting/f0f0edeb-4e91-4306-910e-64389351f433/page/p_cwa6g3oxmd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>

    </div>
</body>
</html>