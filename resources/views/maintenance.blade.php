<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Maintenance Mode - MJDC System</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .maintenance-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 2rem 1rem;
            }

            .maintenance-container {
                width: 100%;
                max-width: 600px;
            }

            .maintenance-card {
                position: relative;
                overflow: hidden;
                padding: 3rem 2rem;
                text-align: center;
                border: var(--glass-border);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-soft);
            }


            .maintenance-title {
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: var(--clr-text);
            }

            .maintenance-description {
                color: var(--clr-text-muted);
                font-size: 1rem;
                line-height: 1.6;
                margin-bottom: 2rem;
            }

            .maintenance-info {
                background: var(--clr-glass-soft);
                border: var(--glass-border);
                border-radius: var(--radius-md);
                padding: 1.5rem;
                margin-bottom: 2rem;
                text-align: left;
            }

            .info-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .info-item:last-child {
                margin-bottom: 0;
            }

            .info-label {
                color: var(--clr-info);
                font-weight: 500;
                margin-right: 1rem;
                min-width: 100px;
            }

            .info-value {
                color: var(--clr-text-soft);
            }

            .maintenance-actions {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .cyber-btn-primary {
                display: inline-block;
                padding: 0.875rem 1.75rem;
                background: linear-gradient(135deg, var(--clr-accent), var(--clr-info));
                color: var(--clr-bg);
                border: none;
                border-radius: var(--radius-sm);
                font-weight: 600;
                font-size: 0.95rem;
                cursor: pointer;
                transition: all 200ms ease;
                text-decoration: none;
                text-align: center;
            }

            .cyber-btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 0 20px var(--clr-accent-glow);
            }

            .cyber-btn-secondary {
                display: inline-block;
                padding: 0.875rem 1.75rem;
                background: transparent;
                color: var(--clr-info);
                border: 1px solid var(--clr-glass-border);
                border-radius: var(--radius-sm);
                font-weight: 500;
                font-size: 0.95rem;
                cursor: pointer;
                transition: all 200ms ease;
                text-decoration: none;
                text-align: center;
            }

            .cyber-btn-secondary:hover {
                border-color: var(--clr-info);
                color: var(--clr-accent);
                text-shadow: 0 0 10px var(--clr-accent-glow);
            }

            .maintenance-footer {
                margin-top: 2rem;
                color: var(--clr-text-muted);
                font-size: 0.875rem;
            }

            .pulse-dot {
                display: inline-block;
                width: 8px;
                height: 8px;
                background: var(--clr-accent);
                border-radius: 50%;
                margin-right: 0.5rem;
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.5;
                }
            }

            @media (max-width: 768px) {
                .maintenance-title {
                    font-size: 1.5rem;
                }

                .maintenance-card {
                    padding: 2rem 1.5rem;
                }

            }
        </style>
    </head>
    <body class="programming-mode">
        <div class="maintenance-wrapper">
            <div class="maintenance-container">
                <div class="liquid-glass maintenance-card">
                    <div class="maintenance-icon mb-4 flex justify-center">
                        <i class="fas fa-wrench" style="font-size: 3rem; color: currentColor;"></i>
                    </div>

                    <h1 class="maintenance-title">System Maintenance</h1>

                    <p class="maintenance-description">
                        We're currently performing scheduled maintenance to improve your experience.
                    </p>

                    <div class="maintenance-info">
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="info-value">
                                <span class="pulse-dot"></span>Maintenance in Progress
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Expected:</span>
                            <span class="info-value">Back online shortly</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">What's next:</span>
                            <span class="info-value">
                                We're upgrading infrastructure and database to serve you better.
                            </span>
                        </div>
                    </div>

                    <div class="maintenance-actions">
                        <button class="cyber-btn-primary" onclick="location.reload();">
                            Refresh Page
                        </button>
                    </div>

                    <div class="maintenance-footer">
                        <p>Questions? Contact us at support@mjdcsystem.com</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

