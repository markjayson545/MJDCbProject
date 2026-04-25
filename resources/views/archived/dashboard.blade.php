@extends('layouts.app')

@section('title', 'Dashboard - System >_')

@section('breadcrumb')
    <span class="main-breadcrumb-current">Dashboard</span>
@endsection

@section('page-title', 'System Dashboard')
@section('page-subtitle', 'Real-time telemetry and overview.')

@section('page-actions')
    <button class="cyber-btn-secondary">Run Diagnostics</button>
@endsection

@section('content')
    <div class="stats-grid">

        <div class="info-card green">
            <p class="info-card-title">Network Status</p>
            <p class="info-card-value">ONLINE</p>
            <p class="info-card-description">All encrypted channels active.</p>
        </div>

        <div class="info-card blue">
            <p class="info-card-title">Active Users</p>
            <p class="info-card-value">1,024</p>
            <p class="info-card-description">+12% from last cycle.</p>
        </div>

        <div class="info-card green">
            <p class="info-card-title">System Load</p>
            <p class="info-card-value">24%</p>
            <p class="info-card-description">Operating within normal parameters.</p>
        </div>

    </div>

    <div class="data-table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Process ID</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>0x00A1</strong></td>
                    <td>Authentication Key Exchange</td>
                    <td><span class="badge badge-success">COMPLETED</span></td>
                    <td>{{ now()->subMinutes(2)->format('H:i:s') }}</td>
                </tr>
                <tr>
                    <td><strong>0x00A2</strong></td>
                    <td>Database Synchronization</td>
                    <td><span class="badge badge-info">IN PROGRESS</span></td>
                    <td>{{ now()->subMinutes(5)->format('H:i:s') }}</td>
                </tr>
                <tr>
                    <td><strong>0x00A3</strong></td>
                    <td>Intrusion Detection Scan</td>
                    <td><span class="badge badge-success">ALL CLEAR</span></td>
                    <td>{{ now()->subMinutes(12)->format('H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
