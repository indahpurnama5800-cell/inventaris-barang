<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk — Sistem Inventaris Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --brand-green: #15803D;
            --brand-green-dark: #14532D;
            --brand-yellow: #EAB308;
            --cream-bg: #FEF9E7;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #F3F4F6;
        }
        .shell {
            display: flex;
            min-height: 100vh;
            width: 100%;
            background: #fff;
        }
        .panel-left {
            flex: 1;
            padding: 36px 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            align-self: flex-start;
        }
        .brand .icon {
            width: 32px; height: 32px;
            background: var(--brand-yellow);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .brand .word {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #1F2937;
        }
        .brand .word span { color: var(--brand-green); }

        .form-wrap {
            width: 100%;
            max-width: 280px;
            margin: auto 0;
            background: #fff;
            border-radius: 14px;
            border: 1px solid #F0FDF4;
            box-shadow: 0 8px 28px rgba(21,128,61,0.09);
            padding: 26px 24px;
        }
        .form-wrap .welcome { color: #9CA3AF; font-size: 11px; margin-bottom: 2px; }
        .form-wrap h1 { font-size: 24px; margin: 0 0 18px 0; color: #111827; font-weight: 700; }

        .btn-google {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            background: #F0FDF4;
            border: 1px solid #DCFCE7;
            border-radius: 8px;
            padding: 8px;
            font-size: 12px;
            color: #374151;
            cursor: pointer;
            margin-bottom: 14px;
        }
        .divider {
            display: flex; align-items: center; gap: 8px;
            color: #9CA3AF; font-size: 10px;
            margin-bottom: 16px;
        }
        .divider::before, .divider::after {
            content: ""; flex: 1; height: 1px; background: #E5E7EB;
        }

        .field-label { font-size: 11px; color: #6B7280; margin-bottom: 4px; display: block; }
        .field-wrap { margin-bottom: 14px; position: relative; }
        .field-wrap .field-icon {
            position: absolute; left: 10px; top: 32px;
            color: var(--brand-green);
            font-size: 12px;
        }
        .field-wrap input {
            width: 100%;
            border: 1px solid #D1FAE5;
            border-radius: 8px;
            padding: 9px 10px 9px 30px;
            font-size: 12px;
            outline: none;
            transition: border-color .15s;
        }
        .field-wrap input:focus { border-color: var(--brand-green); }
        .field-wrap .toggle-eye {
            position: absolute; right: 9px; top: 31px;
            background: none; border: none; cursor: pointer;
            color: var(--brand-green); font-size: 12px;
        }

        .row-between {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 18px; font-size: 11px;
        }
        .row-between label { display: flex; align-items: center; gap: 5px; color: #374151; }
        .row-between a { color: var(--brand-green); text-decoration: none; font-weight: 600; }

        .btn-login {
            width: 100%;
            background: var(--brand-green);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }
        .btn-login:hover { background: var(--brand-green-dark); }

        .signup-note { font-size: 11px; color: #374151; margin-top: 14px; text-align: left; }
        .signup-note a { color: var(--brand-green); font-weight: 700; text-decoration: none; }

        .alert-box { border-radius: 8px; padding: 8px 10px; font-size: 11px; margin-bottom: 12px; }
        .alert-success { background: #DCFCE7; color: #166534; }
        .alert-danger { background: #FEE2E2; color: #991B1B; }

        .demo-note {
            margin-top: 14px; padding-top: 12px; border-top: 1px dashed #E5E7EB;
            font-size: 10px; color: #6b7280; line-height: 1.6;
        }
        .demo-note code { background: #F0FDF4; color: var(--brand-green-dark); padding: 1px 5px; border-radius: 4px; }

        .panel-right {
            flex: 1;
            background: var(--cream-bg);
            display: flex;
            flex-direction: column;
        }
        .panel-right .topbar {
            display: flex; justify-content: flex-end;
            padding: 24px 30px;
            font-size: 12px; color: #6B7280;
        }
        .panel-right .illustration {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 20px 40px 40px;
        }

        @media (max-width: 900px) {
            .shell { flex-direction: column; }
            .panel-right { min-height: 320px; }
        }
    </style>
</head>
<body>
<div class="shell">

    <div class="panel-left">
        <div class="brand">
            <div class="icon">🌿</div>
            <div class="word">INVENTARIS<span>BARANG</span></div>
        </div>

        <div class="form-wrap">
            <div class="welcome">Selamat Datang</div>
            <h1>Masuk</h1>

            @if (session('success'))
                <div class="alert-box alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert-box alert-danger">
                    @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <button type="button" class="btn-google">
                <svg width="15" height="15" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.4 29.3 35 24 35c-6.1 0-11-4.9-11-11s4.9-11 11-11c2.8 0 5.3 1 7.3 2.7l6-6C33.5 6.5 29 4.5 24 4.5 13.2 4.5 4.5 13.2 4.5 24S13.2 43.5 24 43.5 43.5 34.8 43.5 24c0-1.2-.1-2.4-.4-3.5z"/><path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 16 19 13 24 13c2.8 0 5.3 1 7.3 2.7l6-6C33.5 6.5 29 4.5 24 4.5c-7.7 0-14.3 4.4-17.7 10.2z"/><path fill="#4CAF50" d="M24 43.5c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 34.7 26.7 35.5 24 35.5c-5.3 0-9.7-3.4-11.3-8.1l-6.5 5C9.6 39 16.2 43.5 24 43.5z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.2 5.6l6.2 5.2C40.9 36 43.5 30.5 43.5 24c0-1.2-.1-2.4-.4-3.5z"/></svg>
                Masuk dengan Google
            </button>

            <div class="divider">Atau</div>

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf
                <div class="field-wrap">
                    <label class="field-label">Email</label>
                    <span class="field-icon">👤</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                </div>

                <div class="field-wrap">
                    <label class="field-label">Kata Sandi</label>
                    <span class="field-icon">🔒</span>
                    <input type="password" name="password" id="passwordInput" placeholder="••••••••" required>
                    <button type="button" class="toggle-eye" onclick="togglePassword()">👁</button>
                </div>

                <div class="row-between">
                    <label><input type="checkbox" name="remember" checked> Ingat saya</label>
                    <a href="#">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div class="signup-note">Belum punya akun? <a href="#">Hubungi Admin</a></div>

        </div>
    </div>

    <div class="panel-right">
        <div class="topbar">🌐 Bahasa Indonesia ▾</div>
        <div class="illustration">
            <svg viewBox="0 0 420 340" width="100%" style="max-width:480px;">
                <!-- rak kiri -->
                <g>
                    <rect x="30" y="60" width="16" height="220" fill="#15803D"/>
                    <rect x="150" y="60" width="16" height="220" fill="#15803D"/>
                    <rect x="46" y="80" width="104" height="14" fill="#166534"/>
                    <rect x="46" y="150" width="104" height="14" fill="#166534"/>
                    <rect x="46" y="220" width="104" height="14" fill="#166534"/>
                    <!-- boxes row 1 -->
                    <rect x="52" y="55" width="24" height="24" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="80" y="50" width="26" height="29" rx="2" fill="#E4B571" stroke="#8A5A2B"/>
                    <rect x="110" y="55" width="24" height="24" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <!-- boxes row 2 -->
                    <rect x="52" y="125" width="24" height="24" rx="2" fill="#E4B571" stroke="#8A5A2B"/>
                    <rect x="80" y="120" width="26" height="29" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="110" y="125" width="24" height="24" rx="2" fill="#EAB308" stroke="#A16207"/>
                    <!-- boxes row 3 -->
                    <rect x="52" y="195" width="24" height="24" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="80" y="190" width="26" height="29" rx="2" fill="#EAB308" stroke="#A16207"/>
                    <rect x="110" y="195" width="24" height="24" rx="2" fill="#E4B571" stroke="#8A5A2B"/>
                </g>

                <!-- rak kanan (lebih tinggi) -->
                <g>
                    <rect x="230" y="30" width="16" height="250" fill="#166534"/>
                    <rect x="360" y="30" width="16" height="250" fill="#166534"/>
                    <rect x="246" y="55" width="114" height="14" fill="#14532D"/>
                    <rect x="246" y="130" width="114" height="14" fill="#14532D"/>
                    <rect x="246" y="205" width="114" height="14" fill="#14532D"/>
                    <rect x="252" y="25" width="24" height="30" rx="2" fill="#EAB308" stroke="#A16207"/>
                    <rect x="282" y="20" width="26" height="35" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="312" y="25" width="24" height="30" rx="2" fill="#E4B571" stroke="#8A5A2B"/>
                    <rect x="252" y="100" width="24" height="30" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="282" y="95" width="26" height="35" rx="2" fill="#EAB308" stroke="#A16207"/>
                    <rect x="312" y="100" width="24" height="30" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="252" y="175" width="24" height="30" rx="2" fill="#E4B571" stroke="#8A5A2B"/>
                    <rect x="282" y="170" width="26" height="35" rx="2" fill="#D9A25C" stroke="#8A5A2B"/>
                    <rect x="312" y="175" width="24" height="30" rx="2" fill="#EAB308" stroke="#A16207"/>
                </g>

                <!-- lantai -->
                <rect x="10" y="290" width="400" height="6" fill="#15803D"/>

                <!-- forklift sederhana -->
                <g>
                    <rect x="20" y="248" width="46" height="26" rx="3" fill="#EAB308" stroke="#A16207" stroke-width="2"/>
                    <rect x="8" y="200" width="6" height="80" fill="#374151"/>
                    <rect x="30" y="200" width="6" height="80" fill="#374151"/>
                    <rect x="8" y="220" width="28" height="6" fill="#374151"/>
                    <circle cx="30" cy="278" r="9" fill="#1F2937"/>
                    <circle cx="60" cy="278" r="9" fill="#1F2937"/>
                    <rect x="66" y="235" width="10" height="14" fill="#D9A25C" stroke="#8A5A2B"/>
                </g>

                <!-- orang sederhana -->
                <circle cx="185" cy="255" r="9" fill="#166534"/>
                <rect x="178" y="264" width="14" height="24" rx="4" fill="#EAB308"/>
                <line x1="178" y1="270" x2="168" y2="282" stroke="#166534" stroke-width="4" stroke-linecap="round"/>
                <line x1="192" y1="270" x2="202" y2="278" stroke="#166534" stroke-width="4" stroke-linecap="round"/>
                <line x1="182" y1="288" x2="180" y2="300" stroke="#374151" stroke-width="4" stroke-linecap="round"/>
                <line x1="188" y1="288" x2="192" y2="300" stroke="#374151" stroke-width="4" stroke-linecap="round"/>
            </svg>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
