@extends('layouts.app')

@section('title', 'Under Construction - AGRINAV')

@section('styles')
    <style>
        /* ===== Under Construction Page ===== */
        .uc-wrapper {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #0d1b2a;
        }

        /* Animated gradient background blobs */
        .uc-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            pointer-events: none;
        }

        .uc-blob-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #1e3a5f, transparent);
            top: -100px;
            left: -100px;
            animation: blobMove1 8s ease-in-out infinite alternate;
        }

        .uc-blob-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #3c6bb5, transparent);
            bottom: -80px;
            right: -80px;
            animation: blobMove2 10s ease-in-out infinite alternate;
        }

        .uc-blob-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #4a7bc8, transparent);
            top: 40%;
            left: 55%;
            animation: blobMove1 12s ease-in-out infinite alternate;
        }

        @keyframes blobMove1 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(40px, 30px) scale(1.1);
            }
        }

        @keyframes blobMove2 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(-30px, -20px) scale(1.08);
            }
        }

        /* Grid dots pattern overlay */
        .uc-grid {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        /* Card */
        .uc-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 520px;
            margin: 0 24px;
            background: rgba(30, 58, 95, 0.55);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 44px 48px 40px;
            text-align: center;
            box-shadow:
                0 32px 80px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }

        /* Brand logo on card */
        .uc-brand {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .uc-brand img {
            height: 42px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(91, 141, 239, 0.4));
        }

        .uc-brand-text {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: #8ab4f8;
            text-transform: uppercase;
        }

        /* Icon area */
        .uc-icon-wrap {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 28px;
        }

        .uc-icon-main {
            font-size: 3.5rem;
            color: #f5c65d;
            position: relative;
            z-index: 2;
            display: block;
            line-height: 100px;
            text-shadow: 0 0 24px rgba(245, 198, 93, 0.5);
            animation: iconBounce 2.5s ease-in-out infinite;
        }

        .uc-icon-gear {
            position: absolute;
            color: rgba(138, 180, 248, 0.4);
            animation: spinGear 5s linear infinite;
            bottom: 4px;
            right: 0px;
            font-size: 1.6rem;
        }

        .uc-icon-gear-2 {
            position: absolute;
            color: rgba(138, 180, 248, 0.25);
            animation: spinGearRev 7s linear infinite;
            top: 8px;
            left: 2px;
            font-size: 1rem;
        }

        @keyframes iconBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes spinGear {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spinGearRev {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(-360deg);
            }
        }

        /* Text */
        .uc-title {
            font-family: 'Google Sans', 'Segoe UI', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #e8eaed;
            margin: 0 0 10px;
            letter-spacing: -0.01em;
        }

        .uc-subtitle {
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            color: #8ab4f8;
            text-transform: uppercase;
            margin: 0 0 18px;
        }

        .uc-desc {
            font-size: 0.95rem;
            color: #9aa0a6;
            line-height: 1.7;
            margin: 0 0 32px;
        }

        /* Divider */
        .uc-divider {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #4a7bc8, #5b8def);
            border-radius: 4px;
            margin: 0 auto 24px;
        }

        /* Progress bar (fake, decorative) */
        .uc-progress-label {
            font-size: 0.78rem;
            color: #9aa0a6;
            margin-bottom: 8px;
            text-align: left;
            display: flex;
            justify-content: space-between;
        }

        .uc-progress-track {
            background: rgba(255, 255, 255, 0.07);
            border-radius: 8px;
            height: 6px;
            margin-bottom: 28px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .uc-progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #4a7bc8, #8ab4f8);
            border-radius: 8px;
            animation: progressFill 2.8s cubic-bezier(0.4, 0, 0.2, 1) 0.5s forwards;
        }

        @keyframes progressFill {
            from {
                width: 0%;
            }

            to {
                width: 65%;
            }
        }

        /* Back button */
        .uc-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(180deg, #4a7bc8 0%, #3c6bb5 100%);
            color: #fff;
            font-size: 0.92rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(60, 107, 181, 0.45);
            transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
        }

        .uc-back-btn:hover {
            background: linear-gradient(180deg, #5b8def 0%, #4a7bc8 100%);
            box-shadow: 0 6px 20px rgba(91, 141, 239, 0.45);
            transform: translateY(-1px);
            color: #fff;
        }

        .uc-back-btn:active {
            transform: translateY(0);
        }

        /* Footer note */
        .uc-footer-note {
            margin-top: 24px;
            font-size: 0.78rem;
            color: rgba(154, 160, 166, 0.6);
        }
    </style>
@endsection

@section('content')
    <div class="uc-wrapper">
        {{-- Animated background --}}
        <div class="uc-blob uc-blob-1"></div>
        <div class="uc-blob uc-blob-2"></div>
        <div class="uc-blob uc-blob-3"></div>
        <div class="uc-grid"></div>

        {{-- Card --}}
        <div class="uc-card">
            {{-- Brand --}}
            <div class="uc-brand">
                <img src="{{ asset('ptpn1.png') }}" alt="PTPN I">
                <span class="uc-brand-text">AGRINAV &bull; PTPN I</span>
            </div>

            {{-- Icon --}}
            <div class="uc-icon-wrap">
                <i class="fa-solid fa-person-digging uc-icon-main"></i>
                <i class="fa-solid fa-gear uc-icon-gear"></i>
                <i class="fa-solid fa-gear uc-icon-gear-2"></i>
            </div>

            {{-- Text --}}
            <p class="uc-subtitle">Fitur Dalam Pengembangan</p>
            <h1 class="uc-title">Under Construction</h1>
            <div class="uc-divider"></div>
            <p class="uc-desc">
                Halaman atau fitur ini sedang dalam tahap pengembangan.<br>
                Kami sedang bekerja keras untuk segera menghadirkannya kepada Anda.
            </p>

            <!-- {{-- Decorative progress --}}
            <div class="uc-progress-label">
                <span><i class="fa-solid fa-code fa-xs" style="margin-right:4px;"></i> Progress Pengembangan</span>
                <span style="color:#8ab4f8;">65%</span>
            </div>
            <div class="uc-progress-track">
                <div class="uc-progress-fill"></div>
            </div> -->

            {{-- Action --}}
            <a href="javascript:history.back()" class="uc-back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Halaman Sebelumnya
            </a>

            <p class="uc-footer-note">
                Asset &amp; Agribusiness Navigation Dashboard &mdash; PTPN I &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
@endsection