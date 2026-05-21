@extends('Student.Student.MainLayout')

@section('title')
<h1>About Us</h1>
@endsection

@section('header')
    @parent
@endsection()

@section('content')
<div style="display:grid;gap:1.5rem;">

    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Who We Are</h2>
        <p style="color:var(--text-light2);line-height:1.8;">
            <strong>KBC Corporation</strong> is a modern client management platform dedicated to providing seamless, efficient, and elegant solutions for managing client data and operations.
        </p>
    </section>

    <hr>

    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Our Mission</h2>
        <p style="color:var(--text-light2);line-height:1.8;">
            To empower organizations with intuitive tools that simplify client relationship management and drive measurable results through technology.
        </p>
    </section>

    <hr>

    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Our Values</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;">
            @foreach(['Innovation' => '&#128161;', 'Integrity' => '&#9878;', 'Excellence' => '&#9733;', 'Collaboration' => '&#129309;'] as $value => $icon)
            <div style="background:var(--light-surf2);border:1px solid var(--light-border);border-radius:10px;padding:1.25rem;text-align:center;">
                <div style="font-size:1.75rem;margin-bottom:.5rem;">{!! $icon !!}</div>
                <div style="font-weight:700;color:var(--text-light);font-size:.95rem;">{{ $value }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <hr>

    <section>
        <h2 style="margin-bottom:.75rem;border-left:3px solid var(--neon);padding-left:.75rem;">Contact Us</h2>
        <p style="color:var(--text-light2);">&#128231; contact@kbccorp.com &nbsp;&nbsp; &#128222; +63 900 000 0000</p>
    </section>

</div>
@endsection

@section('footer')
    @parent
@endsection()
