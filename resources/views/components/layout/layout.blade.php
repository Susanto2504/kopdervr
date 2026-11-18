<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>IndoVR - Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    </head>

    <body class="bg-gray-100 text-gray-800 antialiased">
        <div class="flex min-h-screen">
            {{-- SIDEBAR --}}
            <aside class="w-80 shrink-0 bg-[#17181C] text-white">
                <x-layout.aside />
            </aside>

            {{-- MAIN --}}
            <div class="min-w-0 flex-1">
                {{-- HEADER --}}
                <x-layout.header :title="$title" />

                {{-- CONTENT --}}
                <main class="w-full p-6">{{ $slot }}</main>

                {{-- FOOTER --}}
                <footer class="p-3 mt-8 border-t border-gray-200 py-5">
                    <div class="flex flex-col gap-2 text-xs text-gray-400 sm:flex-row sm:items-center sm:justify-between">
                        <p>© {{ date('Y') }} IndoVR. All rights reserved.</p>
                        <p>Retail Operations Dashboard</p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>