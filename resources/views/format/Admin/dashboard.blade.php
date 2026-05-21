@extends('Student.Student.MainLayout')
@section('title')
    <h1>Admin Dashboard</h1>
@endsection
@section('subtitle')
    System overview and management
@endsection
@section('content')
<div class="container" style="padding: 30px 0;">

    <!-- Header -->
    <div style="margin-bottom: 30px;">
        <h2 style="margin-top: 0; color: var(--tx-primary);">Welcome to Admin Panel</h2>
        <p style="color: var(--tx-muted);">System Statistics and Overview</p>
    </div>

    <!-- Stat Cards (neutral style) -->
    <div class="stat-grid" style="margin-bottom:30px;">
        <div class="stat-card">
            <div class="stat-value">{{ $totalStudents }}</div>
            <div class="stat-label">Total Students</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $totalTeachers }}</div>
            <div class="stat-label">Total Teachers</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $totalDegrees }}</div>
            <div class="stat-label">Total Degrees</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $activeUsers }}</div>
            <div class="stat-label">Active Users</div>
        </div>
    </div>

    <!-- Admin Actions (neutral cards) -->
    <div class="card" style="padding:20px; border-radius:12px; border:1px solid var(--border-gold);">
        <h3 style="margin-top:0; color:var(--tx-primary);">Quick Actions</h3>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-top:12px;">
            <a href="{{ route('admin.user.create') }}" class="stat-card" style="text-align:center; padding:18px;">👤 Create User</a>
            <a href="{{ route('admin.user.index') }}" class="stat-card" style="text-align:center; padding:18px;">👥 Manage Users</a>
            <a href="{{ route('Student.index') }}" class="stat-card" style="text-align:center; padding:18px;">📚 Students</a>
            <a href="{{ route('Teacher.index') }}" class="stat-card" style="text-align:center; padding:18px;">👨‍🏫 Teachers</a>
            <a href="{{ route('admin.reports') }}" class="stat-card" style="text-align:center; padding:18px;">📊 View Reports</a>
        </div>
    </div>

</div>
@endsection
