<div class="c-sidebar bg-cyan-300 c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show {{ request()->routeIs('app.pos.*') ? 'c-sidebar-minimized' : '' }}"
    id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        <a href="{{ route('home') }}">
            <img class="c-sidebar-brand-full" src="{{ asset('images/logo2.png') }}" alt="Site Logo" width="110">
            <img class="c-sidebar-brand-minimized" src="{{ asset('images/logo.png') }}" alt="Site Logo" width="40">
        </a>
    </div>
    <ul class="c-sidebar-nav">
        @include('layouts.menu')
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 692px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 369px;"></div>
        </div>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
        data-class="c-sidebar-minimized"></button>
    <style>
        .c-sidebar {
            background: linear-gradient(135deg, #2c3a32 0%, #1a1d2b 100%) !important;
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            font-family: 'KhmerOS_KhmerOS_battambang', sans-serif !important;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .c-sidebar-brand {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px 10px 0 0;
        }

        @font-face {
            font-family: 'KhmerOS_KhmerOS_battambang';
            src: url('{{ asset('fonts/KhmerOS_battambang.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .c-sidebar-nav {
            padding: 0.5rem 0;
        }

        .c-sidebar-nav .c-sidebar-nav-link,
        .c-sidebar-nav .c-sidebar-nav-dropdown-toggle {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 8px;
        }

        .c-sidebar-nav .c-sidebar-nav-link:hover,
        .c-sidebar-nav .c-sidebar-nav-dropdown-toggle:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-left: 4px solid #6c5ce7;
        }

        .c-sidebar-nav .c-active {
            background-color: rgba(108, 92, 231, 0.2) !important;
            color: #6c5ce7 !important;
            border-left: 4px solid #6c5ce7;
        }

        .c-sidebar-nav-dropdown-items .c-sidebar-nav-link {
            padding-left: 2rem;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 0;
        }

        .c-sidebar-nav-dropdown-items .c-sidebar-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }

        .c-sidebar-minimizer {
            background-color: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            padding: 0.5rem;
            border: none;
            cursor: pointer;
            border-radius: 0 0 10px 10px;
        }

        .c-sidebar-minimizer:hover {
            background-color: rgba(0, 0, 0, 0.4);
        }

        .c-sidebar-minimized .c-sidebar-brand-full {
            opacity: 0;
        }

        .c-sidebar-minimized .c-sidebar-brand-minimized {
            opacity: 1;
        }

        .ps__thumb-y {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .ps__rail-y:hover .ps__thumb-y {
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const minimizer = document.querySelector('.c-sidebar-minimizer');
            const navLinks = document.querySelectorAll('.c-sidebar-nav-link, .c-sidebar-nav-dropdown-toggle');
            const dropdownToggles = document.querySelectorAll('.c-sidebar-nav-dropdown-toggle');

            if (typeof Ps !== 'undefined') {
                Ps.initialize(sidebar.querySelector('.c-sidebar-nav'), {
                    wheelSpeed: 2,
                    wheelPropagation: false,
                    minScrollbarLength: 20
                });
            }

            minimizer.addEventListener('click', function () {
                sidebar.classList.toggle('c-sidebar-minimized');

                if (sidebar.classList.contains('c-sidebar-minimized')) {
                    localStorage.setItem('sidebarMinimized', 'true');
                } else {
                    localStorage.setItem('sidebarMinimized', 'false');
                }
            });

            if (localStorage.getItem('sidebarMinimized') === 'true') {
                sidebar.classList.add('c-sidebar-minimized');
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    navLinks.forEach(l => l.classList.remove('c-active'));
                    this.classList.add('c-active');
                    if (this.classList.contains('c-sidebar-nav-dropdown-toggle')) {
                        event.preventDefault();
                        const dropdown = this.nextElementSibling;
                        if (dropdown && dropdown.classList.contains('c-sidebar-nav-dropdown-items')) {
                            dropdown.classList.toggle('show');
                            const caret = this.querySelector('.c-sidebar-nav-icon');
                            if (caret) {
                                caret.classList.toggle('rotate-90');
                            }
                        }
                    }
                });
            });

            const currentPath = window.location.pathname;
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('c-active');
                    const dropdown = link.closest('.c-sidebar-nav-dropdown-items');
                    if (dropdown) {
                        dropdown.classList.add('show');
                        const toggle = dropdown.previousElementSibling;
                        if (toggle && toggle.classList.contains('c-sidebar-nav-dropdown-toggle')) {
                            toggle.classList.add('c-active');
                            const caret = toggle.querySelector('.c-sidebar-nav-icon');
                            if (caret) {
                                caret.classList.add('rotate-90');
                            }
                        }
                    }
                }
            });

            function handleResponsive() {
                if (window.innerWidth < 992) {
                    sidebar.classList.add('c-sidebar-minimized');
                } else {
                    if (localStorage.getItem('sidebarMinimized') !== 'true') {
                        sidebar.classList.remove('c-sidebar-minimized');
                    }
                }
            }

            handleResponsive();
            window.addEventListener('resize', handleResponsive);
            document.addEventListener('click', function (event) {
                if (!sidebar.contains(event.target)) {
                    document.querySelectorAll('.c-sidebar-nav-dropdown-items').forEach(dropdown => {
                        dropdown.classList.remove('show');
                        const toggle = dropdown.previousElementSibling;
                        if (toggle && toggle.classList.contains('c-sidebar-nav-dropdown-toggle')) {
                            const caret = toggle.querySelector('.c-sidebar-nav-icon');
                            if (caret) {
                                caret.classList.remove('rotate-90');
                            }
                        }
                    });
                }
            });
        });
    </script>
</div>
