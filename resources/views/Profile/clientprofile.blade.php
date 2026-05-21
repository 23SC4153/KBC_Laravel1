@extends('Student.Student.MainLayout')

@section('title')
<h1>Client Profile</h1>
@endsection

@section('header')
    @parent
@endsection()

@section('content')
<div style="display:grid;gap:1.5rem;">

    {{-- Avatar + Name --}}
    <section style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--dark-700),var(--neon));display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;font-weight:800;flex-shrink:0;">K</div>
        <div>
            <h2 style="margin:0 0 4px;font-size:1.4rem;">Khane Cruz</h2>
            <span class="badge" style="background:var(--neon-dim);color:var(--neon);border:1px solid rgba(0,229,255,.3);">Client</span>
        </div>
    </section>

    <hr>

    {{-- Profile Details --}}
    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Profile Details</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;">
            @foreach([
                'Full Name'  => 'Khane Cruz',
                'Sex'        => 'Male',
                'Address'    => 'Calasiao City',
                'Email'      => 'khane@kbccorp.com',
                'Phone'      => '+63 900 000 0001',
                'Member Since' => '2024',
            ] as $label => $value)
            <div style="background:var(--light-surf2);border:1px solid var(--light-border);border-radius:10px;padding:1rem;">
                <div style="font-size:.7rem;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:4px;">{{ $label }}</div>
                <div style="font-weight:600;color:var(--text-light);">{{ $value }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <hr>

    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Actions</h2>
        <div style="display:flex;flex-wrap:wrap;gap:.75rem;">
            <a href="/dashboard" style="padding:10px 22px;background:var(--dark-700);color:var(--neon);border:1px solid rgba(0,229,255,.3);border-radius:8px;font-weight:600;font-size:.875rem;">&#9741; Dashboard</a>
            <a href="/clientindex" style="padding:10px 22px;background:var(--light-surf2);color:var(--text-light);border:1px solid var(--light-border);border-radius:8px;font-weight:600;font-size:.875rem;">&#8962; Home</a>
        </div>
    </section>

</div>
@endsection
@section('footer')
    @parent
@endsection()
