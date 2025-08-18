@extends('layouts.base')
@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        .coins-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.2em;
        }
        .coins-toolbar-btn {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.55em 1.2em;
            font-size: 1.05em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(102,126,234,0.08);
            transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.15s;
        }
        .coins-toolbar-btn:hover, .coins-toolbar-btn:focus {
            background: linear-gradient(90deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 4px 16px rgba(102,126,234,0.15);
            transform: translateY(-1px);
            outline: none;
        }
        .coins-toolbar-btn:active {
            transform: translateY(0);
        }
        .coins-toolbar-btn svg {
            width: 1.2em;
            height: 1.2em;
        }
        
        /* Enhanced Mobile Responsiveness */
        @media (max-width: 600px) {
            .coins-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .coins-toolbar-btn {
                width: 100%;
                justify-content: center;
            }
            
            /* Mobile-specific table styles - Simplified */
            .coins-table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                touch-action: pan-x;
                position: relative;
                padding: 0.5em;
            }
            
            .coins-table {
                min-width: 400px; /* Reduced from 800px for better mobile performance */
                table-layout: fixed;
                font-size: 13px;
            }
            
            /* Mobile-friendly column widths - Only essential columns */
            .coins-table th,
            .coins-table td {
                padding: 6px 3px;
                font-size: 13px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            /* Fixed column widths for mobile - Only 4 essential columns */
            .coins-table th:nth-child(1),
            .coins-table td:nth-child(1) { width: 60px; } /* Symbol */
            .coins-table th:nth-child(2),
            .coins-table td:nth-child(2) { width: 100px; } /* Name */
            .coins-table th:nth-child(3),
            .coins-table td:nth-child(3) { width: 120px; } /* Full Name */
            .coins-table th:nth-child(4),
            .coins-table td:nth-child(4) { width: 50px; } /* Image */
            
            /* Hide ALL other columns on mobile for simplicity */
            .coins-table th:nth-child(5),
            .coins-table th:nth-child(6),
            .coins-table th:nth-child(7),
            .coins-table th:nth-child(8),
            .coins-table th:nth-child(9),
            .coins-table th:nth-child(10),
            .coins-table td:nth-child(5),
            .coins-table td:nth-child(6),
            .coins-table td:nth-child(7),
            .coins-table td:nth-child(8),
            .coins-table td:nth-child(9),
            .coins-table td:nth-child(10) {
                display: none !important;
            }
            
            /* Mobile search and pagination - Simplified */
            .dataTables_filter input {
                width: 100%;
                margin-left: 0 !important;
                margin-bottom: 8px;
                font-size: 16px;
                padding: 6px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            
            .dataTables_length select {
                width: 100%;
                margin-bottom: 8px;
                font-size: 16px;
                padding: 6px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            
            .dataTables_info,
            .dataTables_paginate {
                text-align: center;
                margin-top: 8px;
                font-size: 12px;
            }
            
            .dataTables_paginate .paginate_button {
                padding: 6px 8px;
                margin: 0 1px;
                font-size: 12px;
                min-width: 36px;
                min-height: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Mobile-friendly table wrapper */
            .table-wrapper {
                margin: 0;
                padding: 0;
            }
            
            /* Ensure proper touch scrolling */
            .coins-table-responsive::-webkit-scrollbar {
                height: 6px;
            }
            
            .coins-table-responsive::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }
            
            .coins-table-responsive::-webkit-scrollbar-thumb {
                background: #667eea;
                border-radius: 3px;
            }
            
            .coins-table-responsive::-webkit-scrollbar-thumb:hover {
                background: #5a6fd8;
            }
            
            /* Mobile-specific DataTables wrapper styles */
            .dataTables_wrapper {
                overflow: hidden;
                font-size: 13px;
            }
            
            .dataTables_scroll {
                overflow-x: auto;
                overflow-y: hidden;
            }
            
            /* Ensure proper mobile layout */
            .dataTables_processing {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1001;
                font-size: 14px;
            }
            
            /* Mobile-optimized table styling */
            .coins-table th {
                padding: 8px 4px;
                font-size: 12px;
            }
            
            .coins-table td {
                padding: 6px 3px;
                font-size: 12px;
            }
            
            /* Optimize images for mobile */
            .previewable-img {
                height: 30px !important;
                width: 30px !important;
            }
            
            /* Mobile-friendly badges */
            .badge {
                font-size: 10px;
                padding: 2px 4px;
            }
        }
        
        /* Tablet Responsiveness - Simplified */
        @media (min-width: 601px) and (max-width: 900px) {
            /* Show only essential columns on tablet */
            .coins-table th:nth-child(5),
            .coins-table th:nth-child(6),
            .coins-table th:nth-child(10),
            .coins-table td:nth-child(5),
            .coins-table td:nth-child(6),
            .coins-table td:nth-child(10) {
                display: none;
            }
            
            .coins-table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .coins-table {
                min-width: 600px;
            }
        }
        
        /* Additional mobile optimizations */
        @media (max-width: 480px) {
            .beautiful-modern-title-bar {
                padding: 1em;
                flex-direction: column;
                gap: 1em;
            }
            
            .modern-title-main {
                flex-direction: column;
                text-align: center;
            }
            
            .coins-toolbar {
                width: 100%;
            }
            
            .dataTables_wrapper {
                font-size: 12px;
            }
            
            .coins-table th,
            .coins-table td {
                padding: 4px 2px;
                font-size: 11px;
            }
            
            /* Ultra-mobile optimizations */
            .coins-table-responsive {
                padding: 0.3em;
            }
            
            .coins-table {
                min-width: 350px;
            }
            
            /* Even smaller column widths for ultra-mobile */
            .coins-table th:nth-child(1),
            .coins-table td:nth-child(1) { width: 50px; }
            .coins-table th:nth-child(2),
            .coins-table td:nth-child(2) { width: 80px; }
            .coins-table th:nth-child(3),
            .coins-table td:nth-child(3) { width: 100px; }
            .coins-table th:nth-child(4),
            .coins-table td:nth-child(4) { width: 40px; }
            
            /* Optimize images for ultra-mobile */
            .previewable-img {
                height: 25px !important;
                width: 25px !important;
            }
            
            /* Mobile-friendly search */
            .dataTables_filter input {
                font-size: 14px;
                padding: 4px;
            }
        }
        
        /* Mobile-optimized responsive popup */
        @media (max-width: 600px) {
            .dtr-modal {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                height: 100% !important;
                max-width: none !important;
                max-height: none !important;
                margin: 0 !important;
                border-radius: 0 !important;
                z-index: 9999 !important;
            }
            
            .dtr-modal-content {
                padding: 1em !important;
                max-height: 100vh !important;
                overflow-y: auto !important;
            }
            
            .dtr-modal-header {
                padding: 0.5em 0 !important;
                margin-bottom: 1em !important;
            }
            
            .dtr-modal-header h3 {
                font-size: 1.2em !important;
                margin: 0 !important;
            }
            
            .dtr-modal-close {
                position: absolute !important;
                top: 1em !important;
                right: 1em !important;
                background: #667eea !important;
                color: white !important;
                border: none !important;
                border-radius: 50% !important;
                width: 30px !important;
                height: 30px !important;
                font-size: 16px !important;
                cursor: pointer !important;
            }
            
            .dtr-modal table {
                font-size: 12px !important;
            }
            
            .dtr-modal th,
            .dtr-modal td {
                padding: 6px 4px !important;
                font-size: 12px !important;
            }
        }
        
        body.coins-dark-mode, .coins-dark-mode .m-content {
            background: #181a1b !important;
            color: #f3f3f3 !important;
        }
        .coins-dark-mode .coins-table, .coins-dark-mode .dataTables_wrapper {
            background: #23272b !important;
            color: #f3f3f3 !important;
        }
        .coins-dark-mode .coins-table th, .coins-dark-mode .coins-table td {
            background: #23272b !important;
            color: #f3f3f3 !important;
        }
        .coins-dark-mode .coins-toolbar-btn {
            background: linear-gradient(90deg, #23272b 0%, #181a1b 100%);
            color: #667eea;
        }
        .coins-dark-mode .coins-toolbar-btn:hover, .coins-dark-mode .coins-toolbar-btn:focus {
            background: linear-gradient(90deg, #181a1b 0%, #23272b 100%);
            color: #764ba2;
        }
        .beautiful-modern-title-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 32px rgba(102,126,234,0.10), 0 1.5px 6px rgba(118,75,162,0.08);
            padding: 1.5em 2em 1.2em 2em;
            margin-bottom: 1.2em;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 70px;
            position: relative;
            z-index: 1;
        }
        .beautiful-modern-title-bar .modern-title-main {
            display: flex;
            align-items: center;
            gap: 1.2em;
        }
        .beautiful-modern-title-bar .modern-title-icon {
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(102,126,234,0.10);
            padding: 0.4em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .beautiful-modern-title-bar .modern-title-text {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 8px rgba(102,126,234,0.10);
        }
        @media (max-width: 900px) {
            .beautiful-modern-title-bar {
                padding: 1.2em 1em 1em 1em;
            }
            .beautiful-modern-title-bar .modern-title-text {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 600px) {
            .beautiful-modern-title-bar {
                padding: 1em 0.5em 0.8em 0.5em;
                min-height: 50px;
            }
            .beautiful-modern-title-bar .modern-title-main {
                gap: 0.7em;
            }
            .beautiful-modern-title-bar .modern-title-text {
                font-size: 1.1rem;
            }
        }
        .modern-title-bar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.2em;
        }
        @media (max-width: 700px) {
            .modern-title-bar-row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .coins-toolbar {
                width: 100%;
                justify-content: flex-start;
            }
        }
        .modern-title-bar.beautiful-modern-title-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 32px rgba(102,126,234,0.10), 0 1.5px 6px rgba(118,75,162,0.08);
            padding: 1.5em 2em 1.2em 2em;
            margin-bottom: 1.2em;
            display: flex;
            align-items: center;
            min-height: 70px;
            position: relative;
            z-index: 1;
            transition: background 0.3s;
        }
        .modern-title-bar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.2em;
            width: 100%;
        }
        .modern-title-main {
            display: flex;
            align-items: center;
            gap: 1em;
            min-width: 0;
        }
        .modern-title-icon {
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(102,126,234,0.10);
            padding: 0.4em;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            min-height: 40px;
        }
        .modern-title-text {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 8px rgba(102,126,234,0.10);
        }
        .modern-title-actions {
            display: flex;
            align-items: center;
            gap: 1em;
        }
        .modern-title-actions-group {
            display: flex;
            align-items: center;
            gap: 0.8em;
        }
        .modern-tab {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.55em 1.2em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .modern-tab:hover, .modern-tab:focus {
            background: rgba(255,255,255,0.25);
            transform: translateY(-1px);
            outline: none;
        }
        .modern-tab:active {
            transform: translateY(0);
        }
        .coins-table-responsive {
            background: #fff;
            border-radius: 1.5em;
            box-shadow: 0 4px 24px rgba(102,126,234,0.08), 0 1.5px 6px rgba(118,75,162,0.06);
            padding: 2em;
            margin-top: 1.5em;
        }
        .coins-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 1em;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(102,126,234,0.06);
            background: #fff;
        }
        .coins-table th {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-weight: 700;
            padding: 1.2em 1em;
            text-align: left;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            position: relative;
        }
        .coins-table th:first-child {
            border-top-left-radius: 1em;
        }
        .coins-table th:last-child {
            border-top-right-radius: 1em;
        }
        .coins-table td {
            padding: 1em;
            border-bottom: 1px solid #f3f3f3;
            background: #fff;
            transition: background 0.2s;
        }
        .coins-table tr:hover td {
            background: #f8f9ff;
        }
        .coins-table tr:last-child td:first-child {
            border-bottom-left-radius: 1em;
        }
        .coins-table tr:last-child td:last-child {
            border-bottom-right-radius: 1em;
        }
        .success {
            color: #28a745;
            font-weight: 600;
        }
        .warning {
            color: #ffc107;
            font-weight: 600;
        }
        .danger {
            color: #dc3545;
            font-weight: 600;
        }
        .info {
            color: #17a2b8;
            font-weight: 600;
        }
        .text-muted {
            color: #6c757d;
        }
        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }
        .badge-success {
            color: #fff;
            background-color: #28a745;
        }
        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }
        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }
        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }
        .badge-secondary {
            color: #fff;
            background-color: #6c757d;
        }
        .previewable-img {
            border-radius: 0.5em;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .previewable-img:hover {
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            .coins-table-responsive {
                padding: 1em;
            }
            .coins-table th, .coins-table td {
                padding: 0.8em 0.5em;
            }
            #cryptocompare_coins td[data-label] {
                display: block;
                width: 100%;
                box-sizing: border-box;
                padding-left: 0.5em;
                padding-right: 0.5em;
                border-bottom: 1px solid #f3f3f3;
                background: #f8f9ff;
                position: relative;
            }
            #cryptocompare_coins td[data-label]:before {
                content: attr(data-label) ": ";
                font-weight: 700;
                color: #667eea;
                display: block;
                margin-bottom: 0.2em;
            }
        }
        /* Navigation Tabs Styles */
        .modern-tabs-container {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 24px rgba(102,126,234,0.08), 0 1.5px 6px rgba(118,75,162,0.06);
            padding: 1.5em;
            margin-bottom: 1.5em;
        }
        .modern-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8em;
            justify-content: center;
        }
        .beautiful-tab {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.8em 1.2em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            backdrop-filter: blur(10px);
        }
        .beautiful-tab:hover, .beautiful-tab:focus {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
            outline: none;
            box-shadow: 0 4px 16px rgba(255,255,255,0.2);
        }
        .beautiful-tab.active {
            background: rgba(255,255,255,0.3);
            box-shadow: 0 4px 16px rgba(255,255,255,0.3);
        }
        .beautiful-tab:active {
            transform: translateY(0);
        }
        .tab-icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .tab-label {
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .modern-tabs {
                flex-direction: column;
                align-items: stretch;
            }
            .beautiful-tab {
                justify-content: center;
            }
        }
        
        /* Loading indicator styles */
        .coins-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2em;
            font-size: 1.2em;
            color: #667eea;
            text-align: center;
            flex-direction: column;
            gap: 1em;
        }
        
        .coins-loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Error message styles */
        .coins-error {
            display: none;
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 1em;
            border-radius: 0.5em;
            margin: 1em 0;
            text-align: center;
        }
        
        /* Mobile-specific loading and error styles */
        @media (max-width: 600px) {
            .coins-loading {
                padding: 1.5em 1em;
                font-size: 1.1em;
            }
            
            .coins-loading-spinner {
                width: 25px;
                height: 25px;
                border-width: 2px;
            }
            
            .coins-error {
                margin: 1em 0.5em;
                padding: 0.8em;
                font-size: 0.95em;
            }
            
            .coins-error button {
                margin-top: 0.5em;
                width: 100%;
            }
            
            /* Hide unnecessary elements on mobile */
            .coins-toolbar {
                gap: 0.5em;
            }
            
            .coins-toolbar-btn {
                padding: 0.4em 1em;
                font-size: 0.95em;
            }
            
            /* Simplify title bar on mobile */
            .beautiful-modern-title-bar {
                padding: 1em 0.8em;
                min-height: 60px;
            }
            
            .modern-title-text {
                font-size: 1.3rem;
            }
            
            /* Simplify navigation tabs on mobile */
            .modern-tabs-container {
                padding: 1em;
            }
            
            .modern-tabs {
                gap: 0.5em;
            }
            
            .beautiful-tab {
                padding: 0.6em 1em;
                font-size: 0.9em;
            }
            
            /* Mobile-optimized table container */
            .coins-table-responsive {
                margin-top: 1em;
                padding: 0.5em;
                background: #fff;
                border-radius: 1em;
                box-shadow: 0 2px 12px rgba(102,126,234,0.06);
            }
            
            /* Ultra-simple mobile table */
            .coins-table {
                border-radius: 0.8em;
                overflow: hidden;
            }
            
            .coins-table th {
                padding: 8px 4px;
                font-size: 11px;
                font-weight: 600;
            }
            
            .coins-table td {
                padding: 6px 3px;
                font-size: 11px;
            }
            
            /* Mobile-optimized badges */
            .badge {
                font-size: 9px;
                padding: 1px 3px;
                border-radius: 3px;
            }
            
            /* Mobile-friendly pagination */
            .dataTables_paginate {
                margin-top: 8px;
            }
            
            .dataTables_paginate .paginate_button {
                margin: 0 1px;
                padding: 4px 6px;
                font-size: 11px;
                min-width: 32px;
                min-height: 32px;
            }
            
            .dataTables_paginate .paginate_button.current {
                background: #667eea !important;
                color: white !important;
                border: none !important;
            }
            
            /* Mobile-optimized search */
            .dataTables_filter {
                margin-bottom: 8px;
            }
            
            .dataTables_filter input {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 4px 6px;
                font-size: 14px;
            }
            
            /* Hide length selector on mobile for simplicity */
            .dataTables_length {
                display: none !important;
            }
            
            /* Mobile-optimized info display */
            .dataTables_info {
                font-size: 11px;
                margin-top: 6px;
                color: #666;
            }
        }
        
        /* Ensure proper z-index for mobile */
        .coins-loading,
        .coins-error {
            position: relative;
            z-index: 1000;
        }
        
        /* Mobile-friendly button styles */
        .coins-toolbar-btn {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Prevent text selection on mobile */
        .coins-table-responsive {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Allow text selection in search inputs */
        .dataTables_filter input {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
    </style>
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon -->
        <div class="beautiful-modern-title-bar">
            <div class="modern-title-bar-row">
                <div class="modern-title-main">
                    <div class="modern-title-icon">
                        <!-- Coins Icon SVG -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="coinsGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#667eea"/>
                                    <stop offset="1" stop-color="#764ba2"/>
                                </linearGradient>
                            </defs>
                            <circle cx="16" cy="16" r="14" fill="url(#coinsGradient)"/>
                            <circle cx="16" cy="16" r="8" fill="#fff" opacity="0.9"/>
                            <text x="16" y="20" text-anchor="middle" font-size="10" fill="#667eea" font-family="Arial, sans-serif" font-weight="bold">₿</text>
                        </svg>
                    </div>
                    <div class="modern-title-text">CryptoCompare Coins</div>
                </div>
                <div class="coins-toolbar">
                    <!-- Dark Mode Toggle -->
                    <button id="coinsDarkModeBtn" class="coins-toolbar-btn" title="Toggle dark/light mode">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="currentColor"/>
                        </svg>
                        <span>Dark Mode</span>
                    </button>
                    <!-- Refresh Button -->
                    <button id="refreshCoinsBtn" class="coins-toolbar-btn" title="Refresh data">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <defs>
                                <linearGradient id="refreshGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#667eea"/>
                                    <stop offset="1" stop-color="#764ba2"/>
                                </linearGradient>
                            </defs>
                            <circle cx="12" cy="12" r="10" fill="#fff"/>
                            <path d="M19 8A8 8 0 1 0 20 12h-1.5" stroke="url(#refreshGradient)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="18 2 18 9 25 9" stroke="url(#refreshGradient)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                        <span>Refresh</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="modern-tabs-container gradient-tabs-bg">
            <nav class="modern-tabs beautiful-tabs" aria-label="CryptoCompare navigation">
                <a href="/cryptocomparecoinsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparecoinsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Coins Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="#667eea"/>
                            <circle cx="12" cy="12" r="6" fill="#fff" opacity="0.9"/>
                            <text x="12" y="16" text-anchor="middle" font-size="8" fill="#667eea" font-family="Arial, sans-serif" font-weight="bold">₿</text>
                        </svg>
                    </span>
                    <span class="tab-label">Coins</span>
                </a>
                <a href="/cryptocomparemarketsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparemarketsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Markets Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="#764ba2"/>
                            <path d="M12 7v5l4 2" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">Markets</span>
                </a>
                <a href="/cryptocompareexchangesindex" class="modern-tab beautiful-tab {{ request()->is('cryptocompareexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchanges Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" fill="#667eea"/>
                            <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/cryptocomparenewsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparenewsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- News Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" fill="#764ba2"/>
                            <path d="M8 8h8M8 12h8M8 16h5" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">News</span>
                </a>
                <a href="/cryptocomparetopairsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparetopairsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Top Pairs Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" fill="#667eea"/>
                            <path d="M8 8h8M8 12h8M8 16h8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">Top Pairs</span>
                </a>
            </nav>
        </div>

        <!-- Loading Indicator -->
        <div id="coinsLoading" class="coins-loading">
            <div class="coins-loading-spinner"></div>
            <span>Loading coins data...</span>
        </div>

        <!-- Error Message -->
        <div id="coinsError" class="coins-error">
            <strong>Error loading data:</strong> <span id="errorMessage"></span>
            <br><br>
            <button id="retryBtn" class="coins-toolbar-btn">Retry</button>
        </div>

        <!-- Debug Info (hidden on production) -->
        <div id="debugInfo" style="display: none; background: #f8f9fa; padding: 1em; margin: 1em 0; border-radius: 0.5em; font-family: monospace; font-size: 12px;">
            <strong>Debug Info:</strong><br>
            <span id="debugDevice"></span><br>
            <span id="debugRoute"></span><br>
            <span id="debugStatus"></span>
        </div>

        <!-- DataTable Section -->
        <div class="coins-table-responsive" id="coinsTableContainer" style="display: none;">
            <!-- Enhanced Table -->
            <div class="table-wrapper" id="coinsTableWrapper">
                <table id="cryptocompare_coins" class="coins-table table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                    <thead>
                        <tr>
                            <th class="datatable-highlight-first enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Symbol</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Coin Icon SVG -->
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="coinSymbolGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#667eea"/>
                                                <stop offset="1" stop-color="#764ba2"/>
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="10" fill="url(#coinSymbolGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">₿</text>
                                    </svg>
                                </span>
                            </th>
                            <th>Name</th>
                            <th>Full Name</th>
                            <th>Image</th>
                            <th class="desktop-only">Algorithm</th>
                            <th class="desktop-only">Proof Type</th>
                            <th>Is Trading</th>
                            <th>Sponsored</th>
                            <th>Internal</th>
                            <th class="desktop-only">Sort Order</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Check if device is mobile
            var isMobile = window.innerWidth <= 768;
            var isTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
            
            // Debug logging
            console.log('Device detection:', { isMobile, isTablet, width: window.innerWidth });
            console.log('jQuery version:', $.fn.jquery);
            console.log('DataTables version:', $.fn.dataTable.version);
            
            // Show debug info in development
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                $('#debugInfo').show();
                $('#debugDevice').text('Device: ' + (isMobile ? 'Mobile' : isTablet ? 'Tablet' : 'Desktop') + ' (Width: ' + window.innerWidth + 'px)');
                $('#debugRoute').text('Route: /getcryptocomparecoinsdata');
            }
            
            // Test route accessibility
            $.ajax({
                url: '/getcryptocomparecoinsdata',
                type: 'HEAD',
                timeout: 5000,
                success: function() {
                    console.log('Route is accessible');
                    if ($('#debugInfo').is(':visible')) {
                        $('#debugStatus').text('Route Status: Accessible');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Route test failed:', { xhr, status, error });
                    if ($('#debugInfo').is(':visible')) {
                        $('#debugStatus').text('Route Status: Failed - ' + status);
                    }
                }
            });
            
            // Show/hide columns based on device
            function adjustColumnsForDevice() {
                if (isMobile) {
                    $('.desktop-only').hide();
                    console.log('Mobile mode: hiding desktop columns');
                } else if (isTablet) {
                    $('.desktop-only').hide();
                    console.log('Tablet mode: hiding desktop columns');
                } else {
                    $('.desktop-only').show();
                    console.log('Desktop mode: showing all columns');
                }
            }
            
            // Initialize DataTable with mobile-friendly configuration
            var coinsTable = $('#cryptocompare_coins').DataTable({
                processing: true,
                serverSide: false,
                deferRender: true, // Better performance on mobile
                autoWidth: false, // Better mobile layout
                scrollX: true, // Enable horizontal scrolling on mobile
                scrollCollapse: true,
                // Mobile-optimized settings
                pageLength: isMobile ? 5 : 25, // Reduced from 15 to 10 for mobile
                lengthMenu: isMobile ? [[5, 10, 15, -1], [5, 10, 15, "All"]] : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                ajax: {
                    url: '/getcryptocomparecoinsdata',
                    type: 'GET',
                    timeout: 30000, // 30 second timeout
                    dataSrc: function(json) {
                        console.log('Data received:', json);
                        // Hide loading indicator
                        $('#coinsLoading').hide();
                        $('#coinsTableContainer').show();
                        return json.data || [];
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTable AJAX error:', { xhr, error, thrown });
                        // Show error message
                        $('#coinsLoading').hide();
                        $('#coinsError').show();
                        $('#errorMessage').text('Failed to load data. Please check your connection and try again.');
                        
                        // Try to provide more specific error messages
                        if (xhr.status === 0) {
                            $('#errorMessage').text('Network error: Please check your internet connection.');
                        } else if (xhr.status === 404) {
                            $('#errorMessage').text('Data endpoint not found. Please contact support.');
                        } else if (xhr.status === 500) {
                            $('#errorMessage').text('Server error. Please try again later.');
                        } else if (xhr.status === 403) {
                            $('#errorMessage').text('Access denied. Please check your permissions.');
                        }
                    }
                },
                columns: [
                    {data: 'symbol', name: 'symbol', width: isMobile ? '60px' : 'auto'},
                    {data: 'name', name: 'name', width: isMobile ? '100px' : 'auto'},
                    {data: 'full_name', name: 'full_name', width: isMobile ? '120px' : 'auto'},
                    {data: 'image_url', name: 'image_url', width: isMobile ? '50px' : 'auto'},
                    {data: 'algorithm', name: 'algorithm', className: 'desktop-only', width: 'auto'},
                    {data: 'proof_type', name: 'proof_type', className: 'desktop-only', width: 'auto'},
                    {data: 'is_trading', name: 'is_trading', width: isMobile ? '80px' : 'auto'},
                    {data: 'sponsored', name: 'sponsored', width: isMobile ? '80px' : 'auto'},
                    {data: 'internal', name: 'internal', width: isMobile ? '80px' : 'auto'},
                    {data: 'sort_order', name: 'sort_order', className: 'desktop-only', width: 'auto'}
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return '<h3>Details for ' + data.symbol + '</h3>';
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table table-bordered table-striped'
                        })
                    }
                },
                order: [[0, 'asc']],
                language: {
                    search: "Search coins:",
                    lengthMenu: "Show _MENU_ coins per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ coins",
                    infoEmpty: "Showing 0 to 0 of 0 coins",
                    infoFiltered: "(filtered from _MAX_ total coins)",
                    zeroRecords: "No coins found",
                    processing: "Loading coins data...",
                    searchPlaceholder: "Type to search..."
                },
                dom: isMobile ? 
                    '<"top"lf>rt<"bottom"ip>' : 
                    '<"top"lf>rt<"bottom"ip>',
                initComplete: function() {
                    console.log('DataTable initialization complete');
                    // Adjust columns after table is initialized
                    adjustColumnsForDevice();
                    
                    // Add mobile-friendly search
                    if (isMobile) {
                        $('.dataTables_filter input').attr('placeholder', 'Search coins...');
                        $('.dataTables_filter input').attr('autocomplete', 'off');
                        $('.dataTables_filter input').attr('type', 'search');
                        
                        // Simplify mobile interface
                        $('.dataTables_length').hide(); // Hide length selector on mobile for simplicity
                    }
                    
                    // Ensure proper column sizing
                    this.api().columns.adjust();
                    
                    // Force redraw for mobile
                    if (isMobile) {
                        setTimeout(function() {
                            coinsTable.columns.adjust().draw();
                        }, 100);
                    }
                },
                drawCallback: function() {
                    console.log('DataTable draw complete');
                    // Re-adjust columns after each draw
                    adjustColumnsForDevice();
                    
                    // Ensure proper sizing on mobile
                    if (isMobile) {
                        this.api().columns.adjust();
                    }
                }
            });

            // Dark Mode Toggle
            $('#coinsDarkModeBtn').click(function() {
                $('body').toggleClass('coins-dark-mode');
                var isDark = $('body').hasClass('coins-dark-mode');
                $(this).find('span').text(isDark ? 'Light Mode' : 'Dark Mode');
            });

            // Refresh Button
            $('#refreshCoinsBtn').click(function() {
                console.log('Refresh button clicked');
                $('#coinsLoading').show();
                $('#coinsTableContainer').hide();
                $('#coinsError').hide();
                coinsTable.ajax.reload();
            });

            // Retry Button
            $('#retryBtn').click(function() {
                console.log('Retry button clicked');
                $('#coinsLoading').show();
                $('#coinsError').hide();
                coinsTable.ajax.reload();
            });

            // Handle window resize for responsive behavior
            var resizeTimer;
            $(window).resize(function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    var newIsMobile = window.innerWidth <= 768;
                    var newIsTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
                    
                    console.log('Window resized:', { newIsMobile, newIsTablet, width: window.innerWidth });
                    
                    if (newIsMobile !== isMobile || newIsTablet !== isTablet) {
                        isMobile = newIsMobile;
                        isTablet = newIsTablet;
                        adjustColumnsForDevice();
                        
                        // Redraw table for better mobile layout
                        coinsTable.columns.adjust().draw();
                    }
                }, 250); // Debounce resize events
            });

            // Add touch-friendly scrolling for mobile
            if (isMobile) {
                $('.coins-table-responsive').on('touchstart touchmove', function(e) {
                    e.stopPropagation();
                });
                
                // Prevent zoom on double tap for mobile
                $('.coins-table-responsive').on('touchend', function(e) {
                    e.preventDefault();
                    var touch = e.originalEvent.changedTouches[0];
                    var element = document.elementFromPoint(touch.clientX, touch.clientY);
                    if (element) {
                        element.click();
                    }
                });
                
                // Mobile-specific optimizations
                $('.coins-table-responsive').css({
                    'touch-action': 'pan-x',
                    'user-select': 'none',
                    '-webkit-user-select': 'none'
                });
                
                // Optimize scroll performance on mobile
                $('.coins-table-responsive').on('scroll', function() {
                    // Throttle scroll events for better performance
                    if (this.scrollTimeout) {
                        clearTimeout(this.scrollTimeout);
                    }
                    this.scrollTimeout = setTimeout(function() {
                        // Handle scroll if needed
                    }, 16); // ~60fps
                });
            }
            
            // Add error handling for DataTable
            $.fn.dataTable.ext.errMode = 'throw';
            
            // Ensure table is visible after a short delay (mobile fix)
            setTimeout(function() {
                if ($('#coinsLoading').is(':visible')) {
                    console.log('Loading indicator still visible, checking for issues...');
                    // Force reload if loading takes too long
                    if (coinsTable && coinsTable.ajax) {
                        console.log('Forcing table reload...');
                        coinsTable.ajax.reload();
                    }
                }
            }, 10000); // 10 second timeout
            
            // Add network status detection
            window.addEventListener('online', function() {
                console.log('Network is online, attempting to reload data...');
                if ($('#coinsError').is(':visible')) {
                    $('#coinsError').hide();
                    $('#coinsLoading').show();
                    coinsTable.ajax.reload();
                }
            });
            
            window.addEventListener('offline', function() {
                console.log('Network is offline');
                if (!$('#coinsError').is(':visible')) {
                    $('#coinsError').show();
                    $('#errorMessage').text('Network is offline. Please check your internet connection.');
                }
            });
            
            // Check if we're offline initially
            if (!navigator.onLine) {
                $('#coinsError').show();
                $('#errorMessage').text('Network is offline. Please check your internet connection.');
                $('#coinsLoading').hide();
            }
            
            // Add additional error handling for DataTable
            $(document).on('error.dt', function(e, settings, techNote, message) {
                console.error('DataTable error:', { e, settings, techNote, message });
                $('#coinsError').show();
                $('#errorMessage').text('DataTable error: ' + message);
                $('#coinsLoading').hide();
            });
            
            // Handle DataTable processing state
            $(document).on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $('#coinsLoading').show();
                    $('#coinsTableContainer').hide();
                    $('#coinsError').hide();
                } else {
                    $('#coinsLoading').hide();
                    $('#coinsTableContainer').show();
                }
            });
            
            // Add performance monitoring for mobile
            if (isMobile) {
                var startTime = performance.now();
                $(document).on('draw.dt', function() {
                    var endTime = performance.now();
                    console.log('Table render time:', (endTime - startTime).toFixed(2) + 'ms');
                    startTime = endTime;
                });
                
                // Mobile-specific performance optimizations
                $(document).on('responsive-display.dt', function(e, settings, row, show) {
                    if (show && isMobile) {
                        // Optimize popup for mobile
                        var modal = $('.dtr-modal');
                        if (modal.length) {
                            modal.css({
                                'position': 'fixed',
                                'top': '0',
                                'left': '0',
                                'right': '0',
                                'bottom': '0',
                                'width': '100%',
                                'height': '100%',
                                'max-width': 'none',
                                'max-height': 'none',
                                'margin': '0',
                                'border-radius': '0',
                                'z-index': '9999'
                            });
                            
                            // Add mobile-friendly close button
                            if (!modal.find('.dtr-modal-close').length) {
                                modal.find('.dtr-modal-header').append(
                                    '<button class="dtr-modal-close" onclick="$(this).closest(\'.dtr-modal\').hide()">×</button>'
                                );
                            }
                        }
                    }
                });
            }
            
            // Ensure proper cleanup on page unload
            $(window).on('beforeunload', function() {
                if (coinsTable) {
                    coinsTable.destroy();
                }
            });
            
            // Add mobile-specific event optimizations
            if (isMobile) {
                // Reduce event listeners for better performance
                $(document).off('click.dt').on('click.dt', '.coins-table tbody tr', function(e) {
                    // Handle row clicks for mobile
                    var row = coinsTable.row(this);
                    if (row.length) {
                        // Show responsive details
                        row.child.show();
                    }
                });
                
                // Optimize touch events
                $('.coins-table-responsive').on('touchstart', function(e) {
                    // Prevent multiple touch events
                    if (e.touches.length > 1) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection 