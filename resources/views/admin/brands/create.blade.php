@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>เพิ่มแบรนด์ใหม่</h2>
    <a href="{{ route('admin.brands.index') }}" class="btn" style="background:var(--border-color); text-decoration:none;">กลับ</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.brands.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display:block; margin-bottom:10px; font-weight:500;">ชื่อแบรนด์ <span style="color:red;">*</span></label>
            <input type="text" name="name" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;" placeholder="เช่น Banobagi">
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">บันทึกข้อมูล</button>
    </form>
</div>
@endsection
