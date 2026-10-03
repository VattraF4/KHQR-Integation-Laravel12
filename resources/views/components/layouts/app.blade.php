<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Shop</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --bg-1: #f8fafc;
            --bg-2: #e0f2fe;
            --bg-3: #eef2ff;
            --text-main: #0f172a;
            --text-soft: #64748b;
            --primary: #2563eb;
            --primary-2: #7c3aed;
            --white-soft: rgba(255, 255, 255, 0.75);
            --border-soft: rgba(255, 255, 255, 0.35);
            --shadow-soft: 0 15px 40px rgba(15, 23, 42, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Inter", "Segoe UI", Arial, sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at top left, #dbeafe 0%, transparent 30%),
                radial-gradient(circle at bottom right, #e9d5ff 0%, transparent 30%),
                linear-gradient(135deg, var(--bg-1), var(--bg-2), var(--bg-3));
        }

        .app-shell {
            min-height: 100vh;
            padding: 40px 16px;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .modern-navbar {
            background: var(--white-soft);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            border-radius: 20px;
            padding: 14px 22px;
            margin-bottom: 30px;
        }

        .brand-title {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-subtitle {
            margin: 0;
            font-size: 0.9rem;
            color: var(--text-soft);
        }

        .content-card {
            background: var(--white-soft);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            border-radius: 24px;
            padding: 28px;
        }

        @media (max-width: 768px) {
            .app-shell {
                padding: 20px 12px;
            }

            .modern-navbar {
                padding: 12px 16px;
                border-radius: 16px;
            }

            .content-card {
                padding: 20px;
                border-radius: 18px;
            }

            .brand-title {
                font-size: 1.15rem;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <div class="page-container">
            <div class="modern-navbar d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="brand-title">Phone Shop</h1>
                    <p class="brand-subtitle">Secure digital payment experience</p>
                </div>
            </div>

            <div class="content-card">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>