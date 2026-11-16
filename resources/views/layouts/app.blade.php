<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'KinerjaKu')</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- TAILWIND -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-800">

    <!-- MOBILE OVERLAY -->
    <div id="sidebarOverlay"
        class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm md:hidden">
    </div>


    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 flex w-64
        -translate-x-full flex-col
        border-r border-slate-800 bg-slate-900
        transition-transform duration-300
        md:translate-x-0">

        <!-- LOGO -->
        <div class="flex h-20 shrink-0 items-center justify-between border-b border-slate-800 px-6">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-950/30">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                </div>

                <div>
                    <h1 class="text-lg font-extrabold tracking-tight text-white">
                        KinerjaKu
                    </h1>

                    <p class="text-xs text-slate-400">
                        Performance Management
                    </p>
                </div>

            </a>

            <!-- CLOSE MOBILE -->
            <button type="button" id="closeSidebar"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-white md:hidden">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>


        <!-- NAVIGATION -->
        <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">

            <!-- MENU UTAMA -->
            <div>

                <p class="mb-3 px-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Menu Utama
                </p>

                <div class="space-y-1">

                    <!-- DASHBOARD -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-600 font-semibold text-white shadow-lg shadow-blue-950/30'
                            : 'font-medium text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                        <i class="fa-solid fa-house w-5 text-center"></i>
                        Dashboard

                    </a>


                    <!-- DATA KARYAWAN -->
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('employees.*')
                            ? 'bg-blue-600 font-semibold text-white shadow-lg shadow-blue-950/30'
                            : 'font-medium text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                        <i class="fa-solid fa-users w-5 text-center"></i>
                        Data Karyawan

                    </a>


                    <!-- EVALUASI -->
                    <a href="{{ route('evaluations.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('evaluations.*')
                            ? 'bg-blue-600 font-semibold text-white shadow-lg shadow-blue-950/30'
                            : 'font-medium text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                        <i class="fa-solid fa-clipboard-check w-5 text-center"></i>
                        Evaluasi Kinerja

                    </a>


                    <!-- LAPORAN -->
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('reports.*')
                            ? 'bg-blue-600 font-semibold text-white shadow-lg shadow-blue-950/30'
                            : 'font-medium text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                        <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                        Laporan

                    </a>

                </div>

            </div>


            </div>

        </nav>


        <!-- SIDEBAR FOOTER -->
        <div class="shrink-0 border-t border-slate-800 p-4">

            <div class="flex items-center gap-3 rounded-xl bg-slate-800 p-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold text-white">
                    A
                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-bold text-white">
                        Administrator
                    </p>

                    <p class="text-xs text-slate-400">
                        Owner
                    </p>

                </div>

                <button type="button"
                    class="text-slate-400 transition hover:text-white"
                    title="Menu akun">

                    <i class="fa-solid fa-ellipsis-vertical"></i>

                </button>

            </div>

        </div>

    </aside>



    <!-- MAIN CONTENT -->
    <div class="min-h-screen md:pl-64">


        <!-- TOPBAR -->
        <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200 bg-white/95 px-5 backdrop-blur sm:px-8">

            <div class="flex items-center gap-3">

                <!-- MOBILE MENU -->
                <button type="button" id="openSidebar"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50 md:hidden">

                    <i class="fa-solid fa-bars"></i>

                </button>

                <div>

                    <h2 class="text-lg font-bold text-slate-800">
                        @yield('page-title', 'Dashboard')
                    </h2>

                    <p class="hidden text-xs text-slate-400 sm:block">
                        Sistem Informasi Penilaian Kinerja Karyawan
                    </p>

                </div>

            </div>


            <!-- TOPBAR RIGHT -->
            <div class="flex items-center gap-3 sm:gap-4">

                <!-- NOTIFICATION -->
                <button type="button"
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition hover:bg-slate-50">

                    <i class="fa-regular fa-bell"></i>

                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>

                </button>

                <div class="hidden h-9 border-l border-slate-200 sm:block"></div>


                <!-- USER -->
                <div class="flex items-center gap-2">

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                        A
                    </div>

                    <div class="hidden sm:block">

                        <p class="text-sm font-semibold text-slate-800">
                            Administrator
                        </p>

                        <p class="text-xs text-slate-400">
                            Owner
                        </p>

                    </div>

                </div>

            </div>

        </header>



        <!-- PAGE CONTENT -->
        <main class="min-h-[calc(100vh-152px)] p-5 sm:p-8">

            @yield('content')

        </main>



        <!-- FOOTER -->
        <footer class="border-t border-slate-200 bg-white px-5 py-5 text-center text-xs text-slate-400 sm:px-8">

            © {{ date('Y') }} KinerjaKu. All rights reserved.

        </footer>

    </div>


    <!-- MOBILE SIDEBAR SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            const openButton = document.getElementById('openSidebar');
            const closeButton = document.getElementById('closeSidebar');

            if (!sidebar || !overlay || !openButton || !closeButton) {
                return;
            }

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openButton.addEventListener('click', openSidebar);
            closeButton.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            // Tutup sidebar saat berpindah ke ukuran tablet/desktop
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });

        });
    </script>

    @stack('scripts')

</body>
</html>
