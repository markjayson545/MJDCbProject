@extends('layouts.app')

@section('title', 'About Us')

@section('page-title', 'About Us')
@section('page-subtitle', 'Learn more about MJDC Project')

@section('content')
    <div class="about-hero">
        <h2>MJDC Student Management System</h2>
        <p>A frosted operations interface for modern education workflows.</p>
    </div>

    <div class="vmv-grid">
        <div class="vmv-card vmv-card-accent">
            <div class="vmv-icon" aria-hidden="true">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3>Our Vision</h3>
            <p>Transform educational administration with transparent data, fast operations, and clear user flows.</p>
        </div>

        <div class="vmv-card vmv-card-blue">
            <div class="vmv-icon" aria-hidden="true">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3>Our Mission</h3>
            <p>Provide a complete platform for student records, performance tracking, and degree workflows.</p>
        </div>

        <div class="vmv-card vmv-card-success">
            <div class="vmv-icon" aria-hidden="true">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3>Our Values</h3>
            <p>Consistency, reliability, accessibility, and practical UI patterns that scale as data grows.</p>
        </div>
    </div>

    <h3 class="section-heading">Key Features</h3>
    <div class="feature-list">
        <div class="feature-item">
            <div class="feature-item-body">
                <h4>Comprehensive Dashboard</h4>
                <p>One place for metrics, trends, and quick operational checks.</p>
            </div>
        </div>
        <div class="feature-item blue">
            <div class="feature-item-body">
                <h4>Student Profile Management</h4>
                <p>Detailed records with structured forms and clear edit/review paths.</p>
            </div>
        </div>
        <div class="feature-item green">
            <div class="feature-item-body">
                <h4>Grade Tracking and Reporting</h4>
                <p>Standardized tables and status badges for faster interpretation.</p>
            </div>
        </div>
        <div class="feature-item amber">
            <div class="feature-item-body">
                <h4>Secure and Reliable</h4>
                <p>Built on Laravel conventions with authentication and profile controls.</p>
            </div>
        </div>
    </div>

    <h3 class="section-heading">Technology Stack</h3>
    <div class="tech-grid">
        <div class="tech-item">
            <div class="tech-emoji">{ }</div>
            <p>Laravel 12</p>
        </div>
        <div class="tech-item">
            <div class="tech-emoji">&lt;/&gt;</div>
            <p>PHP 8.4</p>
        </div>
        <div class="tech-item">
            <div class="tech-emoji">[]</div>
            <p>Tailwind 3</p>
        </div>
        <div class="tech-item">
            <div class="tech-emoji">::</div>
            <p>Alpine 3</p>
        </div>
        <div class="tech-item">
            <div class="tech-emoji">()</div>
            <p>Pest 4</p>
        </div>
        <div class="tech-item">
            <div class="tech-emoji">$</div>
            <p>Sail</p>
        </div>
    </div>

    <div class="contact-box">
        <h3>Contact Us</h3>
        <p>Have questions or need support? Reach out to the team.</p>
        <div class="contact-items">
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>23sc4165_ms@psu.edu.ph</span>
            </div>
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>+63 912 345 6789</span>
            </div>
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Basista, Pangasinan</span>
            </div>
        </div>
    </div>
@endsection
