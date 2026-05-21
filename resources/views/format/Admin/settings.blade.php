@extends('Student.Student.MainLayout')
@section('title')
    <h1>System Settings</h1>
@endsection
@section('subtitle')
    Configure system parameters
@endsection
@section('content')
<div class="container" style="padding: 30px 0;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0; color: var(--tx-primary);">System Settings</h2>
        <a href="{{ route('admin.dashboard') }}" style="padding: 10px 20px; background: var(--border-gold); color: var(--tx-primary); text-decoration: none; border-radius: 6px; font-weight: 600;">Back to Dashboard</a>
    </div>

    <!-- General Settings -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: var(--tx-primary);">General Settings</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            
            <!-- Application Name -->
            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">Application Name</label>
                <input type="text" value="KBC Learning System" disabled style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px; background: var(--bg-card-alt); color: var(--tx-muted);">
            </div>

            <!-- System Version -->
            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">System Version</label>
                <input type="text" value="1.0.0" disabled style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px; background: var(--bg-card-alt); color: var(--tx-muted);">
            </div>

            <!-- Database -->
            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">Database</label>
                <input type="text" value="Laravel" disabled style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px; background: var(--bg-card-alt); color: var(--tx-muted);">
            </div>
        </div>
    </div>

    <!-- Security Settings -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: var(--tx-primary);">Security Settings</h3>
        
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: var(--bg-card-alt); border-radius: 6px;">
                <div>
                    <p style="margin: 0; font-weight: 600; color: var(--tx-primary);">Session Timeout</p>
                    <p style="margin: 5px 0 0; color: var(--tx-muted); font-size: 0.9rem;">Auto-logout after inactivity</p>
                </div>
                <select style="padding: 8px; border: 1px solid var(--border-gold); border-radius: 4px;">
                    <option selected>30 minutes</option>
                    <option>15 minutes</option>
                    <option>60 minutes</option>
                </select>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: var(--bg-card-alt); border-radius: 6px;">
                <div>
                    <p style="margin: 0; font-weight: 600; color: var(--tx-primary);">Password Policy</p>
                    <p style="margin: 5px 0 0; color: var(--tx-muted); font-size: 0.9rem;">Minimum 8 characters required</p>
                </div>
                <span style="padding: 8px 16px; background: #10b981; color: white; border-radius: 4px; font-weight: 600;">Enabled</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: var(--bg-card-alt); border-radius: 6px;">
                <div>
                    <p style="margin: 0; font-weight: 600; color: var(--tx-primary);">Two-Factor Authentication</p>
                    <p style="margin: 5px 0 0; color: var(--tx-muted); font-size: 0.9rem;">Enhanced account security</p>
                </div>
                <select style="padding: 8px; border: 1px solid var(--border-gold); border-radius: 4px;">
                    <option>Disabled</option>
                    <option selected>Optional</option>
                    <option>Required</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Email Settings -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: var(--tx-primary);">Email Settings</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            
            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">Email From Address</label>
                <input type="email" value="noreply@kbcsystem.local" style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">Email From Name</label>
                <input type="text" value="KBC Learning System" style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px;">
            </div>
        </div>
    </div>

    <!-- System Maintenance -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: var(--tx-primary);">System Maintenance</h3>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button style="padding: 12px 24px; background: #f59e0b; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Clear Cache</button>
            <button style="padding: 12px 24px; background: #ef4444; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">View Logs</button>
            <button style="padding: 12px 24px; background: #8b5cf6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Database Backup</button>
        </div>
    </div>

    <!-- Save Button -->
    <div style="display: flex; gap: 10px;">
        <button style="padding: 12px 24px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Save Settings</button>
        <a href="{{ route('admin.dashboard') }}" style="padding: 12px 24px; background: var(--border-gold); color: var(--tx-primary); text-decoration: none; border-radius: 6px; font-weight: 600; text-align: center;">Cancel</a>
    </div>

</div>
@endsection
