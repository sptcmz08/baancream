<style>
    #toast-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        pointer-events: none;
    }

    .toast-item {
        pointer-events: auto;
        min-width: 320px;
        max-width: 420px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #e7ebf3;
        position: relative;
        overflow: hidden;
    }

    .toast-item.show {
        transform: translateX(0);
    }

    .toast-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .toast-success .toast-icon { background: #ecfdf5; color: #10b981; }
    .toast-error .toast-icon { background: #fff1f2; color: #ef4444; }
    .toast-info .toast-icon { background: #eff6ff; color: #3b82f6; }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1a2233;
        margin-bottom: 2px;
    }

    .toast-msg {
        font-size: 0.86rem;
        color: #62708a;
        line-height: 1.4;
    }

    .toast-close {
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        font-size: 1.1rem;
        line-height: 1;
        transition: color 0.2s;
    }

    .toast-close:hover { color: #64748b; }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: rgba(0,0,0,0.05);
    }

    .toast-progress-bar {
        height: 100%;
        width: 0%;
        background: var(--primary-color, #ff4f87);
        transition: width linear;
    }

    .toast-success .toast-progress-bar { background: #10b981; }
    .toast-error .toast-progress-bar { background: #ef4444; }
    .toast-info .toast-progress-bar { background: #3b82f6; }

    @media (max-width: 480px) {
        #toast-container {
            right: 16px;
            left: 16px;
            bottom: 16px;
        }
        .toast-item {
            min-width: 0;
            width: 100%;
        }
    }
</style>

<div id="toast-container"></div>

<script>
    window.showToast = function(message, type = 'success', title = null) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        
        const defaultTitles = {
            success: 'สำเร็จ!',
            error: 'เกิดข้อผิดพลาด',
            info: 'แจ้งเตือน'
        };

        const icons = {
            success: '✓',
            error: '✕',
            info: 'ℹ'
        };

        toast.innerHTML = `
            <div class="toast-icon">${icons[type] || 'ℹ'}</div>
            <div class="toast-content">
                <div class="toast-title">${title || defaultTitles[type] || 'แจ้งเตือน'}</div>
                <div class="toast-msg">${message}</div>
            </div>
            <div class="toast-close" onclick="this.parentElement.remove()">×</div>
            <div class="toast-progress"><div class="toast-progress-bar"></div></div>
        `;

        container.appendChild(toast);

        // Animate show
        setTimeout(() => toast.classList.add('show'), 100);

        // Progress bar
        const duration = 5000;
        const progressBar = toast.querySelector('.toast-progress-bar');
        progressBar.style.transitionDuration = `${duration}ms`;
        setTimeout(() => progressBar.style.width = '100%', 150);

        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, duration);
    }

    // Capture Session Messages
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            window.showToast("{{ session('success') }}", 'success');
        @endif
        @if(session('error'))
            window.showToast("{{ session('error') }}", 'error');
        @endif
        @if(session('info'))
            window.showToast("{{ session('info') }}", 'info');
        @endif
    });
</script>
