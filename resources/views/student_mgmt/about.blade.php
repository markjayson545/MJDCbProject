@extends('layouts.app')

@section('title', 'About Us')

@section('page-title', 'About Us')
@section('page-subtitle', 'Learn more about MJDC Project')

@section('content')
    <div style="background: linear-gradient(135deg, #e94560 0%, #d13852 100%); color: #ffffff; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; text-align: center;">
        <h2 style="font-size: 1.75rem; font-weight: 700; margin: 0 0 0.75rem;">MJDC Student Management System</h2>
        <p style="font-size: 1rem; margin: 0; opacity: 0.95;">Empowering Education Through Technology</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; border-top: 4px solid #e94560;">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(233, 69, 96, 0.1); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="28" height="28" fill="none" stroke="#e94560" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.75rem;">Our Vision</h3>
            <p style="font-size: 0.9rem; color: #6b7280; line-height: 1.6; margin: 0;">
                To be the leading student management platform that transforms educational administration through innovative technology and user-centric design.
            </p>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; border-top: 4px solid #0f3460;">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(15, 52, 96, 0.1); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="28" height="28" fill="none" stroke="#0f3460" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.75rem;">Our Mission</h3>
            <p style="font-size: 0.9rem; color: #6b7280; line-height: 1.6; margin: 0;">
                To provide a comprehensive, efficient, and accessible platform that simplifies student data management while enhancing the educational experience for all stakeholders.
            </p>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; border-top: 4px solid #22c55e;">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(34, 197, 94, 0.1); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="28" height="28" fill="none" stroke="#22c55e" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.75rem;">Our Values</h3>
            <p style="font-size: 0.9rem; color: #6b7280; line-height: 1.6; margin: 0;">
                Innovation, integrity, and inclusivity drive everything we do. We believe in creating solutions that are transparent, reliable, and accessible to everyone.
            </p>
        </div>
    </div>

    <h3 style="font-size: 1.1rem; font-weight: 600; color: #1a1a2e; margin: 2rem 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Key Features</h3>

    <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-left: 4px solid #e94560; border-radius: 6px; padding: 1.25rem;">
            <h4 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 0.5rem;">📊 Comprehensive Dashboard</h4>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">
                Get a complete overview of student performance, attendance, and academic progress with real-time analytics and insights.
            </p>
        </div>

        <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-left: 4px solid #0f3460; border-radius: 6px; padding: 1.25rem;">
            <h4 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 0.5rem;">🎓 Student Profile Management</h4>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">
                Maintain detailed student records including personal information, academic history, enrollment status, and contact details.
            </p>
        </div>

        <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-left: 4px solid #22c55e; border-radius: 6px; padding: 1.25rem;">
            <h4 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 0.5rem;">📈 Grade Tracking & Reporting</h4>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">
                Track student grades, generate report cards, and analyze academic performance with advanced filtering and reporting tools.
            </p>
        </div>

        <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-left: 4px solid #f59e0b; border-radius: 6px; padding: 1.25rem;">
            <h4 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 0.5rem;">🔒 Secure & Reliable</h4>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">
                Built with Laravel's robust security features ensuring data privacy, role-based access control, and encrypted data storage.
            </p>
        </div>
    </div>

    <h3 style="font-size: 1.1rem; font-weight: 600; color: #1a1a2e; margin: 2rem 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Technology Stack</h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 1rem; text-align: center;">
            <p style="font-size: 1.5rem; margin: 0 0 0.5rem;">⚡</p>
            <p style="font-size: 0.875rem; font-weight: 600; color: #1a1a2e; margin: 0;">Laravel 12</p>
        </div>
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 1rem; text-align: center;">
            <p style="font-size: 1.5rem; margin: 0 0 0.5rem;">🐘</p>
            <p style="font-size: 0.875rem; font-weight: 600; color: #1a1a2e; margin: 0;">PHP 8.4</p>
        </div>

    </div>

    <div style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border: 1px solid #e5e7eb; border-radius: 8px; padding: 2rem; text-align: center;">
        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1rem;">Contact Us</h3>
        <p style="font-size: 0.9rem; color: #6b7280; margin: 0 0 1.5rem; line-height: 1.6;">
            Have questions or need support? We're here to help!
        </p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>23sc4165_ms@psu.edu.ph</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>+63 981 088 7893</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Basista, Pangasinan</span>
            </div>
        </div>
    </div>
@endsection
