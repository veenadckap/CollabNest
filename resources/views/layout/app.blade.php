<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Left Sidebar - Fixed width -->
        <aside class="w-64 bg-white border-r border-gray-200 fixed h-full overflow-y-auto">
            @include('layout.aside')
        </aside>

        <!-- Main Content - Takes remaining space -->
        <main class="flex-1 p-6 overflow-y-auto">
            <!-- Simple content area with white background and subtle shadow -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>