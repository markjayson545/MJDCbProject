@extends('layouts.app')

@section('title', 'About — MJDC')

@section('page-title', 'About Us')
@section('page-subtitle', 'Learn more about the MJDC Student Management System')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

/* ── Design tokens ── */
:root {
    --primary:   #1a1a2e;
    --accent:    #e94560;
    --accent-dk: #c83550;
    --blue:      #0f3460;
    --success:   #059669;
    --border:    #e2e8f0;
    --text:      #1e293b;
    --muted:     #64748b;
    --card:      #ffffff;
    --bg:        #f8fafd;
    --r:         12px;
    --r-sm:      8px;
    --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
}

/* ── Shared components ── */
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--r);
    box-shadow: var(--shadow);
    padding: 1.5rem;
}
.section-heading {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
    padding-bottom: 0.6rem;
    border-bottom: 2px solid var(--accent);
    margin: 2rem 0 1.25rem;
    letter-spacing: -0.01em;
}

/* ── Hero banner ── */
.about-hero {
    background: linear-gradient(135deg, var(--accent) 0%, #a52840 100%);
    color: #fff;
    padding: 2.5rem 2rem;
    border-radius: var(--r);
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.about-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='28'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.about-hero h2 {
    font-size: 1.9rem;
    font-weight: 800;
    margin: 0 0 0.6rem;
    letter-spacing: -0.02em;
    position: relative;
}
.about-hero p {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
    position: relative;
}

/* ── Vision/Mission/Values grid ── */
.vmv-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.vmv-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 1.5rem;
    box-shadow: var(--shadow);
}
.vmv-card-accent  { border-top: 3px solid var(--accent); }
.vmv-card-blue    { border-top: 3px solid var(--blue); }
.vmv-card-success { border-top: 3px solid #10b981; }
.vmv-icon {
    width: 50px; height: 50px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
}
.vmv-card h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0 0 0.6rem;
}
.vmv-card p {
    font-size: 0.875rem;
    color: var(--muted);
    line-height: 1.65;
    margin: 0;
}

/* ── Feature items ── */
.feature-list { display: grid; gap: 0.875rem; margin-bottom: 2rem; }
.feature-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    background: var(--bg);
    border: 1px solid var(--border);
    border-left: 4px solid var(--accent);
    border-radius: var(--r-sm);
    padding: 1.1rem 1.25rem;
}
.feature-item.blue  { border-left-color: var(--blue); }
.feature-item.green { border-left-color: #10b981; }
.feature-item.amber { border-left-color: #f59e0b; }
.feature-item-body h4 {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0 0 0.35rem;
}
.feature-item-body p {
    font-size: 0.85rem;
    color: var(--muted);
    margin: 0;
    line-height: 1.6;
}

/* ── Tech stack ── */
.tech-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 0.875rem;
    margin-bottom: 2rem;
}
.tech-item {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--r-sm);
    padding: 1rem;
    text-align: center;
    transition: box-shadow 0.15s ease, transform 0.15s ease;
}
.tech-item:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}
.tech-item .tech-emoji { font-size: 1.5rem; margin-bottom: 0.4rem; }
.tech-item p { font-size: 0.8rem; font-weight: 700; color: var(--primary); margin: 0; }

/* ── Contact section ── */
.contact-box {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 2rem;
    text-align: center;
}
.contact-box h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0 0 0.5rem;
}
.contact-box > p {
    font-size: 0.875rem;
    color: var(--muted);
    margin: 0 0 1.5rem;
}
.contact-items {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text);
}
.contact-item svg { color: var(--accent); flex-shrink: 0; }
</style>

{{-- Hero --}}
<div class="about-hero">
    <h2>MJDC Student Management System</h2>
    <p>Empowering Education Through Technology</p>
</div>

{{-- Vision / Mission / Values --}}
<div class="vmv-grid">
    <div class="vmv-card vmv-card-accent">
        <div class="vmv-icon" style="background: rgba(233,69,96,0.1);">
            <svg width="26" height="26" fill="none" stroke="#e94560" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </div>
        <h3>Our Vision</h3>
        <p>To be the leading student management platform that transforms educational administration through innovative technology and user-centric design.</p>
    </div>

    <div class="vmv-card vmv-card-blue">
        <div class="vmv-icon" style="background: rgba(15,52,96,0.1);">
            <svg width="26" height="26" fill="none" stroke="#0f3460" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
        </div>
        <h3>Our Mission</h3>
        <p>To provide a comprehensive, efficient, and accessible platform that simplifies student data management while enhancing the educational experience for all stakeholders.</p>
    </div>

    <div class="vmv-card vmv-card-success">
        <div class="vmv-icon" style="background: rgba(16,185,129,0.1);">
            <svg width="26" height="26" fill="none" stroke="#10b981" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3>Our Values</h3>
        <p>Innovation, integrity, and inclusivity drive everything we do. We believe in creating solutions that are transparent, reliable, and accessible to everyone.</p>
    </div>
</div>

{{-- Key Features --}}
<h3 class="section-heading">Key Features</h3>
<div class="feature-list">
    <div class="feature-item">
        <div class="feature-item-body">
            <h4>📊 Comprehensive Dashboard</h4>
            <p>Get a complete overview of student performance, attendance, and academic progress with real-time analytics and insights.</p>
        </div>
    </div>
    <div class="feature-item blue">
        <div class="feature-item-body">
            <h4>🎓 Student Profile Management</h4>
            <p>Maintain detailed student records including personal information, academic history, enrollment status, and contact details.</p>
        </div>
    </div>
    <div class="feature-item green">
        <div class="feature-item-body">
            <h4>📈 Grade Tracking &amp; Reporting</h4>
            <p>Track student grades, generate report cards, and analyze academic performance with advanced filtering and reporting tools.</p>
        </div>
    </div>
    <div class="feature-item amber">
        <div class="feature-item-body">
            <h4>🔒 Secure &amp; Reliable</h4>
            <p>Built with Laravel's robust security features ensuring data privacy, role-based access control, and encrypted data storage.</p>
        </div>
    </div>
</div>

{{-- Tech Stack --}}
<h3 class="section-heading">Technology Stack</h3>
<div class="tech-grid">
    <div class="tech-item">
        <div class="tech-emoji">⚡</div>
        <p>Laravel 12</p>
    </div>
    <div class="tech-item">
        <div class="tech-emoji">🐘</div>
        <p>PHP 8.4</p>
    </div>
    <div class="tech-item">
        <div class="tech-emoji">🎨</div>
        <p>Tailwind CSS</p>
    </div>
    <div class="tech-item">
        <div class="tech-emoji">🗄️</div>
        <p>MySQL</p>
    </div>
    <div class="tech-item">
        <div class="tech-emoji">⚙️</div>
        <p>Vite</p>
    </div>
</div>

{{-- Contact --}}
<div class="contact-box">
    <h3>Contact Us</h3>
    <p>Have questions or need support? We're here to help!</p>
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
            <span>+63 981 088 7893</span>
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
