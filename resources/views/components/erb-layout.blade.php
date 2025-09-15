<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Default title')</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.5/css/responsive.dataTables.css">

    <!-- DataTables and jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/responsive.dataTables.js"></script>
</head>

<body>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('erb.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        const table = new DataTable('#myTable', {
            paging: false,
            scrollY: '300px',
            responsive: true,
            order: [[0, 'asc']]
        });

        document.addEventListener('click', function (e) {
            // Only stop propagation if the checkbox or button is inside a specific table
            const isInsideTable = e.target.closest('#myTable'); // or use a more specific class
            const isCheckboxOrButton = e.target.closest('input[type="checkbox"], button');

            if (isInsideTable && isCheckboxOrButton) {
                e.stopPropagation(); // Prevent row expand or other unwanted behavior
            }
        }, true);

        dropDownMenu();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const isHidden = sidebar.classList.contains('-translate-x-full');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function dropDownMenu() {
            const toggles = document.querySelectorAll('.dropdownToggle');

            toggles.forEach(toggle => {
                const menu = toggle.nextElementSibling;
                const arrow = toggle.querySelector('.dropdownArrow');

                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();

                    const isHidden = menu.classList.contains('hidden');

                    if (isHidden) {
                        menu.classList.remove('hidden');
                        setTimeout(() => {
                            menu.classList.remove('opacity-0');
                        }); // small delay to trigger transition
                    } else {
                        menu.classList.add('opacity-0');
                        setTimeout(() => {
                            menu.classList.add('hidden');
                        }); // match the transition duration
                    }

                    arrow.classList.toggle('rotate-180');
                });
            });

            document.addEventListener('click', () => {
                toggles.forEach(toggle => {
                    const menu = toggle.nextElementSibling;
                    const arrow = toggle.querySelector('.dropdownArrow');

                    menu.classList.add('opacity-0');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 300);
                    arrow.classList.remove('rotate-180');
                });
            });
        }
        // Set Page Title Based on URL Path
        const titles = {
            "/erb/dashboard": "DASHBOARD",
            "/erb/assign-reviewer": "ASSIGN REVIEWER",
            "/erb/approved-accounts": "APPROVED ACCOUNTS",
            "/erb/pending-accounts": "PENDING ACCOUNTS",
            "/erb/pending-reviews": "PENDING REVIEWS",
            "/erb/research-records": "RESEARCH RECORDS",
            "/erb/reviewers-checklist": "REVIEWERS CHECKLIST",
            "/erb/settings": "SETTINGS",
            "/erb/sample-table": "SAMPLE TABLE"
        };

        const path = window.location.pathname;
        const pageTitle = titles[path] || "Page";

        // Update the text content of the header and the <title> tag
        document.getElementById("page-title").textContent = pageTitle;
    </script>
</body>

</html>