<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Your Page Title</title>
</head>
<body class="bg-gray-200">

    <div class="flex">
        <!-- Sidebar -->
        <section id="sidebar" class="bg-white text-dark h-screen w-64 fixed">
    <a href="#" class="brand flex items-center p-4"><i class='bx bx-hive icon text-2xl' id="toggle-sidebar"></i><span class="brand-text ml-2 text-xl">TaskWind</span></a>
    <ul class="side-menu">
        <li><a href="#" class="active flex items-center p-3"><i class='bx bxs-dashboard icon text-lg'></i>Dashboard</a></li>
        <li class="divider" data-text="main">Main</li>
        <li class="group">
            <a href="#" class="flex items-center p-3"><i class='bx bxs-inbox icon text-lg'></i>Task <i class='bx bxs-chevron-right icon-right ml-auto'></i></a>
            <ul class="side-dropdown hidden ml-8">
                <li><a href="#" class="block p-2">Overview</a></li>
                <li><a href="#" class="block p-2">Badges</a></li>
                <li><a href="#" class="block p-2">Breadcrumbs</a></li>
                <li><a href="#" class="block p-2">Button</a></li>
            </ul>
        </li>
        <li><a href="#" class="flex items-center p-3"><i class='bx bxs-chart icon text-lg'></i>Charts</a></li>
        <li><a href="#" class="flex items-center p-3"><i class='bx bxs-widget icon text-lg'></i>Widgets</a></li>
        <li class="divider" data-text="table and forms">Table and Forms </li>
        <li><a href="#" class="flex items-center p-3"><i class='bx bx-table icon text-lg'></i>Tables</a></li>
        <li class="group">
            <a href="#" class="flex items-center p-3"><i class='bx bxs-notepad icon text-lg'></i>Forms<i class='bx bxs-chevron-right icon-right ml-auto'></i></a>
            <ul class="side-dropdown hidden ml-8">
                <li><a href="#" class="block p-2">Basic</a></li>
                <li><a href="#" class="block p-2">Select</a></li>
                <li><a href="#" class="block p-2">Checkbox</a></li>
                <li><a href="#" class="block p-2">Radio</a></li>
            </ul>
        </li>
    </ul>
</section>
            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4">
                <h1>Hi</h1>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Toggle sidebar on button click
            $('#toggle-sidebar').on('click', function () {
                $('#sidebar').toggleClass('-translate-x-full');
            });
        });
    </script>

</body>
</html>
