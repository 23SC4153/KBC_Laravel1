@extends('Student.Student.MainLayout')

@section('page_title', $pageHeading ?? 'Student Management Dashboard')

@section('title')
<h1>{{ $pageHeading ?? 'Student Management Dashboard' }}</h1>
@endsection

@section('header')
    @parent
@endsection

@section('content')
<div style="display:grid;gap:1.5rem;">
    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">
            {{ ($pageType ?? 'home') === 'about' ? 'About This Activity' : 'Welcome to your Dashboard' }}
        </h2>
        <p style="color:var(--text-light2);">{{ $pageDescription ?? 'Use the navigation menu to open the Students page and view student records.' }}</p>
    </section>

    <hr>

    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Quick Links</h2>
        <div style="display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center;">
            <a href="{{ route('user.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:var(--neon-dim);color:var(--neon);border:1px solid rgba(0,229,255,.3);border-radius:8px;font-weight:600;font-size:.875rem;">&#8962; Dashboard</a>
            <a href="{{ route('Student.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:#dbeafe;color:#1e40af;border-radius:8px;font-weight:600;font-size:.875rem;">&#128218; Students</a>
            <a href="{{ route('Teacher.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:#ede9fe;color:#4c1d95;border-radius:8px;font-weight:600;font-size:.875rem;">&#9432; Teachers</a>
        </div>
    </section>
</div>
@endsection

@section('footer')
    @parent
@endsection
