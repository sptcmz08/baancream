@extends('layouts.admin')

@section('styles')
<style>
    .user-toolbar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 16px;
    }
    .user-name {
        font-weight: 700;
        color: var(--text-dark);
    }
    .role-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 82px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .role-badge.admin {
        background: #fef3c7;
        color: #92400e;
    }
    .role-badge.user {
        background: #e0f2fe;
        color: #0369a1;
    }
    .user-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }
    .user-modal {
        position: fixed;
        inset: 0;
        z-index: 80;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(17, 24, 39, 0.48);
    }
    .user-modal.is-open {
        display: flex;
    }
    .user-modal-panel {
        width: min(560px, 100%);
        max-height: calc(100vh - 40px);
        overflow: auto;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, 0.22);
        padding: 22px;
    }
    .user-modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }
    .user-modal-title {
        font-size: 1.2rem;
        font-weight: 700;
    }
    .user-modal-close {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 999px;
        background: #f3f4f6;
        cursor: pointer;
        font-size: 1rem;
    }
    .user-form-grid {
        display: grid;
        gap: 14px;
    }
    .user-form-grid label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
    .user-form-grid input,
    .user-form-grid select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-family: 'Prompt';
    }
    .user-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
        flex-wrap: wrap;
    }
    @media (max-width: 640px) {
        .user-toolbar {
            justify-content: stretch;
        }
        .user-toolbar .btn {
            width: 100%;
        }
        .user-modal {
            align-items: flex-end;
            padding: 0;
        }
        .user-modal-panel {
            max-height: 88vh;
            border-radius: 18px 18px 0 0;
        }
    }
</style>
@endsection

@section('content')
<div class="header-actions">
    <h2>จัดการผู้ใช้งาน (Users)</h2>
</div>

<div class="card">
    <div class="user-toolbar">
        <button type="button" class="btn btn-primary" id="openCreateUserModal">+ เพิ่มผู้ใช้งานใหม่</button>
    </div>

    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="table" style="min-width:760px;">
            <thead>
                <tr>
                    <th style="width:80px;">ลำดับ</th>
                    <th>ผู้ใช้งาน</th>
                    <th style="width:140px;">บทบาท</th>
                    <th style="width:100px; text-align:center;">ออเดอร์</th>
                    <th style="width:190px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight:500;">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td>
                            <div class="user-name">{{ $user->name }}</div>
                        </td>
                        <td>
                            <span class="role-badge {{ $user->role === 'admin' ? 'admin' : 'user' }}">
                                {{ $user->role === 'admin' ? 'แอดมิน' : 'User' }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <span style="background:#f3f4f6; padding:4px 10px; border-radius:6px; font-size:0.82rem; font-weight:500;">
                                {{ $user->orders_count }}
                            </span>
                        </td>
                        <td>
                            <div class="user-actions">
                                <button
                                    type="button"
                                    class="btn"
                                    data-edit-user
                                    data-action="{{ route('admin.users.update', $user) }}"
                                    data-name="{{ $user->name }}"
                                    data-username="{{ $user->username }}"
                                    data-role="{{ $user->role === 'admin' ? 'admin' : 'user' }}"
                                    data-self="{{ $user->id === auth()->id() ? '1' : '0' }}"
                                    style="background:#e0f2fe; color:#0369a1; padding:7px 10px; font-size:0.82rem;">
                                    แก้ไข
                                </button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('ลบผู้ใช้ {{ $user->name }}?');" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding:7px 10px; font-size:0.82rem;">ลบ</button>
                                    </form>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.82rem;">ตัวเอง</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีผู้ใช้</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links('vendor.pagination.admin') }}
</div>

<div class="user-modal" id="createUserModal" aria-hidden="true">
    <div class="user-modal-panel">
        <div class="user-modal-head">
            <div class="user-modal-title">เพิ่มผู้ใช้งานใหม่</div>
            <button type="button" class="user-modal-close" data-close-user-modal aria-label="ปิด">x</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="user-form-grid">
                <div>
                    <label>ชื่อ</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required>
                </div>
                <div>
                    <label>รหัสผ่าน</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>ยืนยันรหัสผ่าน</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div>
                    <label>บทบาท</label>
                    <select name="role" required>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>แอดมิน</option>
                    </select>
                </div>
            </div>
            <div class="user-form-actions">
                <button type="button" class="btn" data-close-user-modal>ยกเลิก</button>
                <button type="submit" class="btn btn-primary">เพิ่มผู้ใช้</button>
            </div>
        </form>
    </div>
</div>

<div class="user-modal" id="editUserModal" aria-hidden="true">
    <div class="user-modal-panel">
        <div class="user-modal-head">
            <div class="user-modal-title">แก้ไขผู้ใช้งาน</div>
            <button type="button" class="user-modal-close" data-close-user-modal aria-label="ปิด">x</button>
        </div>
        <form id="editUserForm" method="POST" action="#">
            @csrf
            @method('PUT')
            <div class="user-form-grid">
                <div>
                    <label>ชื่อ</label>
                    <input type="text" name="name" id="editUserName" required>
                </div>
                <div>
                    <label>Username</label>
                    <input type="text" name="username" id="editUserUsername" required>
                </div>
                <div>
                    <label>รหัสผ่านใหม่</label>
                    <input type="password" name="password" placeholder="เว้นว่างไว้ถ้าไม่ต้องการเปลี่ยน">
                </div>
                <div>
                    <label>ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" name="password_confirmation" placeholder="เว้นว่างไว้ถ้าไม่ต้องการเปลี่ยน">
                </div>
                <div>
                    <label>บทบาท</label>
                    <select name="role" id="editUserRole" required>
                        <option value="user">User</option>
                        <option value="admin">แอดมิน</option>
                    </select>
                    <input type="hidden" name="role" id="editUserRoleFallback" value="admin" disabled>
                    <div id="editUserSelfNote" style="display:none; color:var(--text-muted); font-size:0.82rem; margin-top:6px;">บัญชีที่ใช้งานอยู่ ไม่สามารถลดสิทธิ์ตัวเองได้</div>
                </div>
            </div>
            <div class="user-form-actions">
                <button type="button" class="btn" data-close-user-modal>ยกเลิก</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const createUserModal = document.getElementById('createUserModal');
    const editUserModal = document.getElementById('editUserModal');
    const editUserForm = document.getElementById('editUserForm');
    const editUserName = document.getElementById('editUserName');
    const editUserUsername = document.getElementById('editUserUsername');
    const editUserRole = document.getElementById('editUserRole');
    const editUserRoleFallback = document.getElementById('editUserRoleFallback');
    const editUserSelfNote = document.getElementById('editUserSelfNote');

    function openUserModal(modal) {
        modal?.classList.add('is-open');
        modal?.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeUserModals() {
        document.querySelectorAll('.user-modal').forEach((modal) => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        });
        document.body.style.overflow = '';
    }

    document.getElementById('openCreateUserModal')?.addEventListener('click', () => openUserModal(createUserModal));
    document.querySelectorAll('[data-close-user-modal]').forEach((button) => button.addEventListener('click', closeUserModals));
    document.querySelectorAll('.user-modal').forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeUserModals();
            }
        });
    });

    document.querySelectorAll('[data-edit-user]').forEach((button) => {
        button.addEventListener('click', () => {
            const isSelf = button.dataset.self === '1';
            editUserForm.action = button.dataset.action;
            editUserName.value = button.dataset.name || '';
            editUserUsername.value = button.dataset.username || '';
            editUserRole.value = button.dataset.role || 'user';
            editUserRole.disabled = isSelf;
            editUserRoleFallback.disabled = !isSelf;
            editUserSelfNote.style.display = isSelf ? 'block' : 'none';
            editUserForm.querySelectorAll('input[type="password"]').forEach((input) => input.value = '');
            openUserModal(editUserModal);
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeUserModals();
        }
    });
</script>
@endsection
