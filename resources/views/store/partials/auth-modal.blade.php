@php
    $initialAuthMode = old('auth_mode', request('auth', 'login'));
    $initialAuthMode = in_array($initialAuthMode, ['login', 'register'], true) ? $initialAuthMode : 'login';
    $authHasErrors = $errors->has('email') || $errors->has('password') || $errors->has('name') || $errors->has('password_confirmation');
@endphp

<style>
    .auth-modal {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(16, 23, 41, 0.48);
        z-index: 90;
    }
    .auth-modal.is-open {
        display: flex;
    }
    .auth-card {
        width: min(980px, 100%);
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 34px;
        overflow: hidden;
        box-shadow: 0 28px 90px rgba(15, 23, 42, 0.22);
        display: grid;
        grid-template-columns: minmax(280px, 0.95fr) minmax(0, 1.05fr);
    }
    .auth-panel {
        padding: 34px 30px;
        background: linear-gradient(145deg, #fff3f7 0%, #eef8ff 100%);
        color: var(--text-dark);
        display: grid;
        align-content: space-between;
        gap: 28px;
    }
    .auth-panel-title {
        font-size: clamp(2rem, 5vw, 3.4rem);
        line-height: 1.02;
        margin-bottom: 14px;
    }
    .auth-panel-copy {
        color: var(--text-soft);
        line-height: 1.8;
    }
    .auth-panel-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .auth-panel-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(255, 79, 135, 0.18);
        border-radius: 999px;
        padding: 10px 14px;
        color: var(--text-soft);
        font-weight: 500;
    }
    .auth-forms {
        padding: 28px 30px 30px;
        display: grid;
        align-content: start;
        gap: 18px;
    }
    .auth-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }
    .auth-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .auth-tab {
        border: 1px solid var(--border-color);
        border-radius: 999px;
        padding: 10px 18px;
        background: white;
        color: var(--text-soft);
        font-weight: 600;
        cursor: pointer;
    }
    .auth-tab.is-active {
        background: #fff4f8;
        border-color: rgba(255, 79, 135, 0.28);
        color: var(--primary-color);
    }
    .auth-close {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 999px;
        background: #f4f7fb;
        color: var(--text-dark);
        font-size: 1.1rem;
        cursor: pointer;
    }
    .auth-status,
    .auth-errors {
        border-radius: 18px;
        padding: 14px 16px;
        font-size: 0.94rem;
    }
    .auth-status {
        background: #e9fff5;
        color: #117a4d;
        border: 1px solid #b8f0d6;
    }
    .auth-errors {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }
    .auth-form {
        display: none;
        gap: 14px;
    }
    .auth-form.is-active {
        display: grid;
    }
    .auth-field {
        display: grid;
        gap: 8px;
    }
    .auth-label {
        font-size: 0.94rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    .auth-input {
        width: 100%;
        min-height: 52px;
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 0 16px;
        outline: none;
        background: #fbfcff;
    }
    .auth-input:focus {
        border-color: rgba(255, 79, 135, 0.28);
        box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.08);
    }
    .auth-help {
        color: #be123c;
        font-size: 0.85rem;
    }
    .auth-remember {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-soft);
        font-size: 0.92rem;
    }
    .auth-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 6px;
    }
    .auth-link {
        color: var(--text-soft);
        text-decoration: underline;
        text-decoration-color: rgba(98, 112, 138, 0.35);
        text-underline-offset: 3px;
    }
    .auth-submit {
        border: none;
        border-radius: 999px;
        min-height: 52px;
        padding: 0 22px;
        background: linear-gradient(135deg, var(--gold-color), #ffb340);
        color: #46260a;
        font-weight: 700;
        cursor: pointer;
    }
    .auth-switch {
        border-top: 1px solid var(--border-color);
        padding-top: 18px;
        color: var(--text-soft);
        font-size: 0.94rem;
    }
    .auth-switch button {
        border: none;
        background: transparent;
        color: var(--primary-color);
        font-weight: 700;
        cursor: pointer;
        padding: 0;
    }

    @media (max-width: 860px) {
        .auth-card {
            grid-template-columns: 1fr;
        }
        .auth-panel {
            padding: 24px 24px 18px;
        }
        .auth-forms {
            padding: 22px 24px 24px;
        }
    }
</style>

<div
    class="auth-modal {{ request('auth') || $authHasErrors ? 'is-open' : '' }}"
    id="authModal"
    data-auth-modal
    data-initial-mode="{{ $initialAuthMode }}"
    aria-hidden="{{ request('auth') || $authHasErrors ? 'false' : 'true' }}">
    <div class="auth-card">
        <div class="auth-panel">
            <div>
                <div class="product-badge brand" style="display:inline-flex; margin-bottom:18px;">บ้านครีม สิงห์บุรี</div>
                <h2 class="auth-panel-title">ยินดีต้อนรับ<br>กลับมาช้อปต่อ</h2>
                <p class="auth-panel-copy">เข้าสู่ระบบหรือสมัครสมาชิกจาก popup เดียวกันได้เลย โดยยังคงอยู่บนหน้าเว็บเดิมของคุณ</p>
            </div>
            <div class="auth-panel-pills">
                <span class="auth-panel-pill">ช้อปต่อได้ทันที</span>
                <span class="auth-panel-pill">ตะกร้าไม่หาย</span>
                <span class="auth-panel-pill">สมัครใหม่ได้ในหน้าเดียว</span>
            </div>
        </div>

        <div class="auth-forms">
            <div class="auth-topbar">
                <div class="auth-tabs">
                    <button type="button" class="auth-tab" data-auth-tab="login">เข้าสู่ระบบ</button>
                    <button type="button" class="auth-tab" data-auth-tab="register">สมัครสมาชิก</button>
                </div>
                <button type="button" class="auth-close" data-auth-close aria-label="ปิด popup">✕</button>
            </div>

            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form" data-auth-form="login">
                @csrf
                <input type="hidden" name="auth_mode" value="login">

                <div class="auth-field">
                    <label class="auth-label" for="auth_login_email">อีเมล</label>
                    <input class="auth-input" id="auth_login_email" type="email" name="email" value="{{ old('auth_mode') === 'login' ? old('email') : '' }}" required autocomplete="username">
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="auth_login_password">รหัสผ่าน</label>
                    <input class="auth-input" id="auth_login_password" type="password" name="password" required autocomplete="current-password">
                </div>

                <label class="auth-remember" for="auth_remember_me">
                    <input id="auth_remember_me" type="checkbox" name="remember">
                    <span>จดจำการเข้าสู่ระบบ</span>
                </label>

                <div class="auth-actions">
                    @if (Route::has('password.request'))
                        <a class="auth-link" href="{{ route('password.request') }}">ลืมรหัสผ่าน?</a>
                    @endif
                    <button type="submit" class="auth-submit">เข้าสู่ระบบ</button>
                </div>

                <div class="auth-switch">
                    ยังไม่มีบัญชี?
                    <button type="button" data-auth-switch="register">สมัครสมาชิก</button>
                </div>
            </form>

            <form method="POST" action="{{ route('register') }}" class="auth-form" data-auth-form="register">
                @csrf
                <input type="hidden" name="auth_mode" value="register">

                <div class="auth-field">
                    <label class="auth-label" for="auth_register_name">ชื่อ</label>
                    <input class="auth-input" id="auth_register_name" type="text" name="name" value="{{ old('auth_mode') === 'register' ? old('name') : '' }}" required autocomplete="name">
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="auth_register_email">อีเมล</label>
                    <input class="auth-input" id="auth_register_email" type="email" name="email" value="{{ old('auth_mode') === 'register' ? old('email') : '' }}" required autocomplete="username">
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="auth_register_password">รหัสผ่าน</label>
                    <input class="auth-input" id="auth_register_password" type="password" name="password" required autocomplete="new-password">
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="auth_register_password_confirmation">ยืนยันรหัสผ่าน</label>
                    <input class="auth-input" id="auth_register_password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="auth-actions">
                    <span class="auth-link" style="text-decoration:none;">สมัครเสร็จแล้วเข้าสู่ระบบให้อัตโนมัติ</span>
                    <button type="submit" class="auth-submit">สมัครสมาชิก</button>
                </div>

                <div class="auth-switch">
                    มีบัญชีอยู่แล้ว?
                    <button type="button" data-auth-switch="login">เข้าสู่ระบบ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (() => {
        const authModal = document.getElementById('authModal');
        if (!authModal) return;

        const tabs = Array.from(document.querySelectorAll('[data-auth-tab]'));
        const forms = Array.from(document.querySelectorAll('[data-auth-form]'));
        const openers = Array.from(document.querySelectorAll('[data-open-auth]'));
        const closers = Array.from(document.querySelectorAll('[data-auth-close]'));
        const switchers = Array.from(document.querySelectorAll('[data-auth-switch]'));
        let currentMode = authModal.dataset.initialMode || 'login';

        const setMode = (mode) => {
            currentMode = mode === 'register' ? 'register' : 'login';
            tabs.forEach((tab) => tab.classList.toggle('is-active', tab.dataset.authTab === currentMode));
            forms.forEach((form) => form.classList.toggle('is-active', form.dataset.authForm === currentMode));
        };

        const openModal = (mode) => {
            setMode(mode || currentMode);
            authModal.classList.add('is-open');
            authModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const closeModal = () => {
            authModal.classList.remove('is-open');
            authModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        tabs.forEach((tab) => tab.addEventListener('click', () => setMode(tab.dataset.authTab)));
        switchers.forEach((button) => button.addEventListener('click', () => setMode(button.dataset.authSwitch)));
        openers.forEach((button) => {
            button.addEventListener('click', () => openModal(button.dataset.authMode));
        });
        closers.forEach((button) => button.addEventListener('click', closeModal));
        authModal.addEventListener('click', (event) => {
            if (event.target === authModal) {
                closeModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && authModal.classList.contains('is-open')) {
                closeModal();
            }
        });

        setMode(currentMode);

        if (authModal.classList.contains('is-open')) {
            document.body.style.overflow = 'hidden';
        }
    })();
</script>
