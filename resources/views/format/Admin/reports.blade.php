@extends('Student.Student.MainLayout')
@section('title')
    <h1>System Reports</h1>
@endsection
@section('subtitle')
    Analytics and statistics
@endsection
@section('content')
<div class="container" style="padding: 30px 0;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0; color: var(--tx-primary);">System Reports</h2>
        <a href="{{ route('admin.dashboard') }}" style="padding: 10px 20px; background: var(--border-gold); color: var(--tx-primary); text-decoration: none; border-radius: 6px; font-weight: 600;">Back to Dashboard</a>
    </div>

    <!-- Overview Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px;">
            <p style="margin: 0 0 10px; opacity: 0.8;">Total Students</p>
            <p style="margin: 0; font-size: 2.5rem; font-weight: 700;">{{ $studentCount }}</p>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 12px;">
            <p style="margin: 0 0 10px; opacity: 0.8;">Total Teachers</p>
            <p style="margin: 0; font-size: 2.5rem; font-weight: 700;">{{ $teacherCount }}</p>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px;">
            <p style="margin: 0 0 10px; opacity: 0.8;">Total Degrees</p>
            <p style="margin: 0; font-size: 2.5rem; font-weight: 700;">{{ $degreeCount }}</p>
        </div>
    </div>

    <!-- Students by Degree -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: var(--tx-primary);">Students by Degree</h3>
        
        @if ($studentsByDegree->isEmpty())
            <p style="color: var(--tx-muted);">No students enrolled.</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: var(--bg-card-alt); border-bottom: 2px solid var(--border-gold);">
                        <tr>
                            <th style="padding: 12px; text-align: left;">Degree Code</th>
                            <th style="padding: 12px; text-align: right;">Number of Students</th>
                            <th style="padding: 12px; text-align: right;">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalStudents = $studentsByDegree->reduce(function ($carry, $item) {
                                return $carry + $item->count();
                            }, 0);
                        @endphp
                        @foreach ($studentsByDegree as $degree => $students)
                        <tr style="border-bottom: 1px solid var(--border-gold);">
                            <td style="padding: 12px;">{{ $degree }}</td>
                            <td style="padding: 12px; text-align: right; font-weight: 600;">{{ $students->count() }}</td>
                            <td style="padding: 12px; text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 8px;">
                                    {{ round(($students->count() / $totalStudents * 100), 1) }}%
                                    <div style="width: 100px; height: 8px; background: var(--bg-card-alt); border-radius: 4px; overflow: hidden;">
                                        <div style="width: {{ $students->count() / $totalStudents * 100 }}%; height: 100%; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Additional Info -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold);">
        <h3 style="margin-top: 0; color: var(--tx-primary);">Quick Summary</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div>
                <p style="margin: 0 0 8px; color: var(--tx-muted); font-size: 0.9rem;">Average Students per Degree</p>
                <p style="margin: 0; font-size: 1.5rem; font-weight: 700;">
                    @if ($degreeCount > 0)
                        {{ round($studentCount / $degreeCount, 1) }}
                    @else
                        0
                    @endif
                </p>
            </div>
            <div>
                <p style="margin: 0 0 8px; color: var(--tx-muted); font-size: 0.9rem;">Student to Teacher Ratio</p>
                <p style="margin: 0; font-size: 1.5rem; font-weight: 700;">
                    @if ($teacherCount > 0)
                        {{ round($studentCount / $teacherCount, 1) }} : 1
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
