@extends('auth.login.layouts.app')

@section('title', 'Login Admin | PROKLIM Kalimantan Barat')

@push('styles')
<style>
    :root {
        --login-green: #008e67;
        --login-green-dark: #003e2f;
        --login-mint: #00d6a0;
        --login-text: #171717;
        --login-muted: #7b7b7b;
        --login-border: #999999;
    }

    * { box-sizing: border-box; }
    html, body { min-height: 100%; }

    .login-body {
        margin: 0;
        padding-bottom: 0 !important;
        min-height: 100vh;
        overflow-y: auto;
        background: #fbfbfb;
        color: var(--login-text);
        font-family: Inter, "Segoe UI", Arial, sans-serif;
    }

    .login-page {
        min-height: 100vh;
        display: grid;
        place-items: center;
        padding: clamp(24px, 5.8vh, 60px) clamp(24px, 5.2vw, 108px);
    }

    .login-shell {
        width: min(1835px, 100%);
        min-height: 600px;
        height: min(902px, calc(100vh - clamp(48px, 11.6vh, 120px)));
        display: grid;
        grid-template-columns: minmax(520px, 1.06fr) minmax(470px, .94fr);
        gap: clamp(72px, 9vw, 182px);
        align-items: stretch;
    }

    .login-brand {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: clamp(24px, 2vw, 36px);
        padding: clamp(38px, 4.2vw, 54px) clamp(38px, 4.4vw, 56px) clamp(40px, 4.2vw, 54px);
        color: #fff;
        background:
            radial-gradient(circle at 81% 47%, rgba(210, 239, 227, .44) 0 8%, rgba(210, 239, 227, .13) 17%, transparent 32%),
            linear-gradient(145deg, #148a68 0%, #087c5d 37%, #006c3c 100%);
    }

    .login-brand::before {
        content: "";
        position: absolute;
        z-index: -1;
        width: 104%;
        height: 76%;
        left: 26%;
        top: 18%;
        border-radius: 48% 0 0 54%;
        background: linear-gradient(145deg, #002e23 10%, #003c2c 70%, rgba(0, 78, 51, .7));
        transform: rotate(7deg);
        filter: blur(2px);
    }

    .login-brand::after {
        content: "";
        position: absolute;
        z-index: -1;
        width: 60%;
        height: 62%;
        right: -23%;
        bottom: -17%;
        border-radius: 46% 54% 52% 48%;
        background: radial-gradient(circle at 30% 16%, rgba(113, 187, 161, .52), rgba(0, 80, 55, .26) 47%, transparent 68%);
        transform: rotate(-18deg);
        filter: blur(8px);
    }

    .brand-mark, .brand-copy { position: relative; z-index: 1; }

    .brand-mark {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .brand-mark img {
        width: clamp(48px, 4.7vw, 66px);
        height: clamp(61px, 6vw, 82px);
        object-fit: contain;
    }

    .brand-mark strong, .brand-mark span { display: block; }

    .brand-mark strong {
        margin-bottom: 4px;
        font-size: clamp(18px, 1.45vw, 24px);
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .brand-mark span {
        font-size: clamp(14px, 1.18vw, 19px);
        font-weight: 400;
    }

    .brand-copy h1 {
        margin: 0 0 clamp(18px, 2vh, 25px);
        max-width: 620px;
        color: #fff;
        font-size: clamp(44px, 4.1vw, 68px);
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.035em;
    }

    .brand-copy p {
        max-width: 735px;
        margin: 0;
        color: rgba(255, 255, 255, .96);
        font-size: clamp(17px, 1.55vw, 26px);
        font-weight: 400;
        line-height: 1.27;
    }

    .login-main {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: clamp(54px, 7vh, 72px) 0 clamp(30px, 4vh, 44px);
    }

    .back-link {
        align-self: flex-start;
        color: #272727;
        font-size: clamp(15px, 1.1vw, 19px);
        line-height: 1.2;
        text-decoration: underline;
        text-underline-offset: 3px;
        transition: color .2s ease;
    }

    .back-link:hover { color: var(--login-green); }

    .login-form-wrap {
        width: min(100%, 666px);
        margin: clamp(76px, 12vh, 128px) auto 0;
    }

    .login-title {
        margin: 0 0 clamp(42px, 6vh, 58px);
        text-align: center;
        font-size: clamp(34px, 2.6vw, 45px);
        font-weight: 750;
        line-height: 1.1;
        letter-spacing: -.025em;
    }

    .login-alert {
        margin-bottom: 22px;
        border: 1px solid #fecaca;
        border-radius: 10px;
        background: #fef2f2;
        padding: 13px 16px;
        color: #b91c1c;
        font-size: 14px;
    }

    .field-group { margin-bottom: clamp(26px, 3.4vh, 38px); }

    .field-label {
        display: block;
        margin: 0 0 12px;
        color: #202020;
        font-size: clamp(16px, 1.22vw, 21px);
        font-weight: 600;
    }

    .field-control {
        width: 100%;
        height: clamp(62px, 7.7vh, 80px);
        border: 1px solid var(--login-border);
        border-radius: 9px;
        background: #fff;
        padding: 0 22px;
        color: #202020;
        font: inherit;
        font-size: clamp(16px, 1.26vw, 21px);
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .field-control::placeholder { color: #8a8a8a; opacity: 1; }

    .field-control:focus {
        border-color: var(--login-green);
        box-shadow: 0 0 0 3px rgba(0, 159, 110, .12);
    }

    .field-control.is-invalid { border-color: #dc2626; }

    .field-error {
        display: block;
        margin-top: 7px;
        color: #dc2626;
        font-size: 13px;
    }

    .password-field { position: relative; }
    .password-field .field-control { padding-right: 62px; }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        border: 0;
        border-radius: 50%;
        background: transparent;
        color: #7c7c7c;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .password-toggle:hover, .password-toggle:focus {
        color: var(--login-green);
        outline: none;
        background: #f0fdf8;
    }

    .remember-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: -20px 0 clamp(34px, 4.2vh, 43px);
        color: var(--login-muted);
        font-size: clamp(14px, 1vw, 17px);
        cursor: pointer;
        user-select: none;
    }

    .remember-row input {
        width: 26px;
        height: 26px;
        flex: 0 0 auto;
        margin: 0;
        accent-color: var(--login-green);
        cursor: pointer;
    }

    .login-button {
        width: 100%;
        min-height: 58px;
        border: 0;
        border-radius: 9px;
        background: var(--login-mint);
        color: #fff;
        font-size: clamp(17px, 1.2vw, 21px);
        font-weight: 700;
        box-shadow: 0 1px 8px rgba(0, 205, 154, .45);
        cursor: pointer;
        transition: background .2s ease, transform .15s ease, box-shadow .2s ease;
    }

    .login-button:hover {
        background: #00bd8c;
        box-shadow: 0 5px 16px rgba(0, 159, 110, .28);
        transform: translateY(-1px);
    }

    .login-button:focus { outline: 3px solid rgba(0, 159, 110, .22); outline-offset: 3px; }

    @media (max-height: 790px) and (min-width: 901px) {
        .login-main { padding-top: 34px; }
        .login-form-wrap { margin-top: 72px; }
        .login-title { margin-bottom: 30px; }
        .field-group { margin-bottom: 22px; }
        .remember-row { margin-top: -10px; margin-bottom: 24px; }
        .brand-copy h1 { font-size: clamp(40px, 3.55vw, 56px); margin-bottom: 14px; }
        .brand-copy p { font-size: clamp(16px, 1.3vw, 21px); }
    }

    @media (max-width: 1100px) {
        .login-page { padding-inline: 34px; }
        .login-shell { gap: 54px; grid-template-columns: minmax(430px, 1fr) minmax(410px, .88fr); }
    }

    @media (max-width: 900px) {
        .login-page { display: block; padding: 0; background: #fff; }
        .login-shell { display: block; width: 100%; height: auto; min-height: 100vh; }
        .login-brand { min-height: 300px; border-radius: 0 0 28px 28px; padding: 28px 26px 32px; }
        .brand-copy { margin-top: 70px; }
        .brand-copy h1 { max-width: 420px; font-size: clamp(38px, 10vw, 52px); }
        .brand-copy p { max-width: 620px; font-size: 17px; }
        .login-main { padding: 28px 24px 48px; }
        .login-form-wrap { width: min(100%, 620px); margin-top: 44px; }
        .login-title { margin-bottom: 36px; }
    }

    @media (max-width: 480px) {
        .login-brand { min-height: 280px; }
        .brand-copy { margin-top: 48px; }
        .brand-copy p { font-size: 15px; }
        .login-main { padding-inline: 20px; }
        .field-control { padding-inline: 17px; }
        .remember-row input { width: 22px; height: 22px; }
    }
</style>
@endpush

@section('content')
<main class="login-page">
    <div class="login-shell">
        <section class="login-brand" aria-label="Tentang dashboard admin PROKLIM">
            <div class="brand-mark">
                <img src="{{ asset('images/logo_pemprov_kalbar.webp') }}" alt="Lambang Pemerintah Provinsi Kalimantan Barat">
                <div>
                    <strong>DLHK PROKLIM</strong>
                    <span>KALIMANTAN BARAT</span>
                </div>
            </div>

            <div class="brand-copy">
                <h1>Selamat Datang<br>Admin!</h1>
                <p>Kelola informasi emisi, sampah, kualitas lingkungan, LB3, dan informasi lainnya terkait PROKLIM melalui dashboard admin.</p>
            </div>
        </section>

        <section class="login-main" aria-labelledby="login-heading">
            <a href="{{ route('home') }}" class="back-link">Kembali</a>

            <div class="login-form-wrap">
                <h2 id="login-heading" class="login-title">Login</h2>

                @if (session('failed'))
                    <div class="login-alert" role="alert">{{ session('failed') }}</div>
                @endif

                <form action="{{ route('login-process') }}" method="POST">
                    @csrf

                    <div class="field-group">
                        <label class="field-label" for="emailaddress">Email</label>
                        <input
                            class="field-control @error('email') is-invalid @enderror"
                            type="email"
                            id="emailaddress"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email..."
                            autocomplete="email"
                            inputmode="email"
                            required
                            autofocus
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                        >
                        @error('email')
                            <span id="email-error" class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="password">Password</label>
                        <div class="password-field">
                            <input
                                class="field-control @error('password') is-invalid @enderror"
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password..."
                                autocomplete="current-password"
                                required
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                            >
                            <button class="password-toggle" type="button" aria-label="Tampilkan password" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        @error('password')
                            <span id="password-error" class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <label class="remember-row" for="remember">
                        <input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))>
                        <span>Ingat informasi masuk?</span>
                    </label>

                    <button class="login-button" type="submit">Login</button>
                </form>
            </div>
        </section>
    </div>
</main>
@endsection

@section('js')
<script>
    document.querySelector('.password-toggle')?.addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const passwordVisible = passwordInput.type === 'text';
        const icon = this.querySelector('i');

        passwordInput.type = passwordVisible ? 'password' : 'text';
        this.setAttribute('aria-pressed', String(!passwordVisible));
        this.setAttribute('aria-label', passwordVisible ? 'Tampilkan password' : 'Sembunyikan password');
        icon.classList.toggle('fa-eye', passwordVisible);
        icon.classList.toggle('fa-eye-slash', !passwordVisible);
        passwordInput.focus();
    });
</script>
@endsection
