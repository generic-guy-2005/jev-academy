<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets\favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Jev-Glossarium</title>
</head>

<body>
    <style>
        * {
            font-family: 'Inter', 'Courier New', Courier, monospace;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <nav class="relative bg-gray-800/50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10" style='background-color: white'>
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex shrink-0 items-center">
                        <img src="assets/water_3410476.png" alt="Jev-Glossarium" class="h-8 w-auto" />
                        <p style="margin-left: 10px">Jev-Glossarium</p>
                    </div>
                    <div class="hidden sm:ml-6 sm:block" style='width: 100%'>
                        <div class="flex justify-center content-center space-x-4">
                            <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                            <a href="#" aria-current="page" class="rounded-md bg-blue-700 px-3 py-2 text-sm font-medium text-white">Dashboard</a>
                            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-cyan-500">Team</a>
                            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-cyan-500">Projects</a>
                            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-cyan-500">Calendar</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                    <!-- Profile dropdown -->
                    <el-dropdown class="relative ml-3 bg-blue-500 transition delay-150 duration-300 ease-in-out hover:bg-indigo-500 rounded-full" style='padding: 5px'>
                        <button class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <img src="assets/account_circle_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt="" class="size-8 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                            <p style="margin: 5px 10px 0px 10px; color: white;">Profile</p>
                        </button>

                        <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-neutral-800 py-1 outline -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                            <a href="#" class="block px-4 py-2 text-sm text-neutral-50 focus:bg-white/5 focus:outline-hidden" style="color: #3492F7">Myself</a>
                            <a href="#" class="block px-4 py-2 text-sm text-neutral-50 focus:bg-white/5 focus:outline-hidden" style="color: #3492F7">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-neutral-50 focus:bg-white/5 focus:outline-hidden" style="color: #3492F7">Sign Out</a>
                        </el-menu>
                    </el-dropdown>
                </div>
            </div>
        </div>

        <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                <a href="#" aria-current="page" class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
            </div>
        </el-disclosure>
    </nav>

    <?php

    $page = basename($_GET['page'] ?? 'landing');

    if ($page === 'landing') {
        include 'landing_default.php';
    }

    ?>

    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-4">About</h3>
                <p class="text-sm mb-4">
                    Website ini ditujukan untuk kepentingan akademik dari kekaisaran Ngawi yang mendesak
                </p>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                        <span>Mojokerto, Ngawi Barat, Ngawi</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>
                        <span>jev@email.com</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt text-blue-500 mr-2"></i>
                        <span>0899-9999-9999</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Attribution</h4>
                <ul class="space-y-2">
                    <li><a href="https://www.freepik.com/author/drobotdean" class="hover:text-blue-500 transition duration-200">drobotdean</a></li>
                    <li><a href="https://www.freepik.com/author/wirestock" class="hover:text-blue-500 transition duration-200">wirestock</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Parani Authornya</h4>
                <a href="https://github.com/generic-guy-2005/jev-academy" class="hover:text-blue-500 transition duration-200">GitHub</a><br>
                <a href="#" class="hover:text-blue-500 transition duration-200">Email</a>
                
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-500 text-xl"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-500 text-xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-500 text-xl"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-500 text-xl"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-500">
            <p>&copy; 2025 Jurusan Teknologi Informasi. All Rights Reserved.</p>
            <div class="flex justify-center mt-4 space-x-4">
                <p>Politeknik Negeri Padang</p>
            </div>
        </div>
    </footer>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    </style>
</body>

</html>