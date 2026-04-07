@extends('layouts.app')

@section('title', 'Student Summary')

@section('page-title', 'Student Summary')
@section('page-subtitle', 'Route parameter preview')

@section('content')
    <div class="detail-card">
        <div class="info-row">
            <span class="info-key">Name</span>
            <span class="info-val">{{ $name }}</span>
        </div>
        <div class="info-row">
            <span class="info-key">Course</span>
            <span class="info-val">{{ $course }}</span>
        </div>
        @isset($date)
            <div class="info-row">
                <span class="info-key">Date</span>
                <span class="info-val">{{ $date }}</span>
            </div>
        @endisset
    </div>
@endsection
