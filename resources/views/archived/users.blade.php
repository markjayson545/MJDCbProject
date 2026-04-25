@extends('layouts.app')

@section('title', 'Users Management - System >_')

@section('breadcrumb')
    <a href="/">Home</a>
    <span class="main-breadcrumb-sep">/</span>
    <span class="main-breadcrumb-current">Users</span>
@endsection

@section('page-title', 'Users Console')
@section('page-subtitle', 'Manage system access and authentication models.')

@section('page-actions')
    <button class="cyber-btn-secondary">Export Data</button>
    <button class="cyber-btn-primary">Add New User</button>
@endsection

@section('content')
    <div class="data-table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>UID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->id }}</strong></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-success">ACTIVE</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
