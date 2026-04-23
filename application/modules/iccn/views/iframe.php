<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HARPA - ICCN SSO</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Source Sans Pro', sans-serif; background: #f4f6f9; }
        .sso-loading {
            display: flex; align-items: center; justify-content: center;
            height: 100vh; flex-direction: column;
        }
        .sso-loading .spinner {
            border: 4px solid #e0e0e0; border-top: 4px solid #dc3545;
            border-radius: 50%; width: 40px; height: 40px;
            animation: spin 0.8s linear infinite;
        }
        .sso-loading p { margin-top: 16px; color: #666; font-size: 14px; }
        .sso-error { color: #dc3545; display: none; text-align: center; padding: 20px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

<?php if ($already_logged_in): ?>
    <!-- Already logged in, redirect to dashboard -->
    <script>
        window.location.href = "<?= $dashboard_url ?>";
    </script>
<?php else: ?>

    <div id="sso-loading" class="sso-loading">
        <div class="spinner"></div>
        <p>Menghubungkan ke ICCN SSO...</p>
    </div>

    <div id="sso-error" class="sso-error">
        <h3>SSO Login Gagal</h3>
        <p id="sso-error-msg"></p>
    </div>

    <script>
    (function() {
        var TRUSTED_ORIGINS = <?= $trusted_origins ?>;
        var VERIFY_URL = "<?= $verify_url ?>";
        var DASHBOARD_URL = "<?= $dashboard_url ?>";
        var FALLBACK_URL = "<?= $fallback_url ?>";
        var tokenProcessed = false;

        // 1. Request token from ICCN parent
        function requestToken() {
            for (var i = 0; i < TRUSTED_ORIGINS.length; i++) {
                try {
                    window.parent.postMessage({ type: "ICCN_SSO_REQUEST" }, TRUSTED_ORIGINS[i]);
                } catch (e) {
                    // origin mismatch, skip
                }
            }
        }

        // 2. Listen for ICCN_SSO_TOKEN
        window.addEventListener("message", function(event) {
            // Validate origin
            if (TRUSTED_ORIGINS.indexOf(event.origin) === -1) return;

            // Handle ICCN_SSO_INIT — token is coming
            if (event.data && event.data.type === "ICCN_SSO_INIT") {
                return;
            }

            // Handle ICCN_SSO_TOKEN
            if (!event.data || event.data.type !== "ICCN_SSO_TOKEN") return;
            if (tokenProcessed) return;
            tokenProcessed = true;

            var payload = event.data.payload;

            // 3. Send ACK to ICCN (stop retry)
            window.parent.postMessage({ type: "ICCN_SSO_ACK" }, event.origin);

            if (!payload || !payload.isAuthenticated || !payload.accessToken) {
                showError("Token tidak diterima atau user belum login di ICCN.");
                return;
            }

            // 4. Verify token at backend
            verifyToken(payload.accessToken, event.origin);
        });

        // 3. Verify token via backend
        function verifyToken(accessToken, origin) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", VERIFY_URL, true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState !== 4) return;

                try {
                    var resp = JSON.parse(xhr.responseText);
                    if (xhr.status === 200 && resp.success) {
                        // 5. Login successful — redirect to dashboard
                        window.location.href = resp.redirect || DASHBOARD_URL;
                    } else {
                        showError(resp.message || "Verifikasi SSO gagal.");
                    }
                } catch (e) {
                    showError("Terjadi kesalahan saat verifikasi token.");
                }
            };
            xhr.send(JSON.stringify({ token: accessToken }));
        }

        function showError(msg) {
            document.getElementById("sso-loading").style.display = "none";
            document.getElementById("sso-error").style.display = "block";
            document.getElementById("sso-error-msg").textContent = msg + " Mengalihkan...";
            setTimeout(function() {
                window.top.location.href = FALLBACK_URL;
            }, 2000);
        }

        // Start: request token from ICCN
        requestToken();

        // Timeout: if no token received within 6 seconds, redirect to fallback
        setTimeout(function() {
            if (!tokenProcessed) {
                showError("Tidak dapat terhubung ke ICCN SSO.");
            }
        }, 6000);
    })();
    </script>

<?php endif; ?>

</body>
</html>
