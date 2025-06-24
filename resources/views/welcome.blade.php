<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TaskFlow - Inicio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="min-h-screen bg-gray-100">
    <div class="px-2 md:px-20 pt-6 max-w-7xl mx-auto">
        <!-- nav -->
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex items-center justify-center">
                <div class="flex items-center justify-center text-3xl font-bold text-true-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mr-2" viewBox="0 0 1024 1024"
                         version="1.1">
                        <path d="M1000.2 341.9L548.5 614.2 70.4 502.8l478.1-259.9z" fill="#9ED5E4"/>
                        <path
                            d="M548.5 628.4c-1.1 0-2.2-0.1-3.2-0.4l-478-111.4c-5.8-1.3-10.1-6.1-10.9-12-0.8-5.9 2.1-11.6 7.3-14.5l478-259.9c3-1.6 6.5-2.1 9.9-1.4l451.7 99c5.7 1.3 10.1 5.9 11 11.6 1 5.8-1.7 11.5-6.7 14.5L555.8 626.4c-2.2 1.3-4.8 2-7.3 2z m-438.3-131L546 598.9l416.1-250.8L550.6 258 110.2 497.4z"
                            fill="#154B8B"/>
                        <path
                            d="M548.5 806L92.1 694.6c-43.4-5.4-71.7-71.2-69.5-120.7 1.3-29.8 17.8-71.2 69.5-71.2l456.3 111.4V806h0.1z"
                            fill="#9ED5E4"/>
                        <path
                            d="M548.5 820.3c-1.1 0-2.3-0.1-3.4-0.4L89.5 708.6c-24.4-3.4-46.3-21.6-61.9-51.2-13.3-25.3-20.5-56.7-19.3-84.1 0.5-12 3.7-35 18.8-54.8 10.5-13.7 30.2-30 65-30 1.1 0 2.3 0.1 3.4 0.4l456.3 111.4c6.4 1.6 10.9 7.3 10.9 13.9V806c0 4.4-2 8.5-5.5 11.2-2.5 2-5.6 3.1-8.7 3.1z m-458-303.2c-13.9 0.4-51.4 6.3-53.6 57.5-1 22.6 5 48.6 16 69.6 15.2 29 32.2 35.2 41 36.3 0.5 0.1 1.1 0.2 1.6 0.3l438.7 107.1V625.4L90.5 517.1z"
                            fill="#154B8B"/>
                        <path d="M1000.2 533.7L548.5 806V614.2l451.7-272.3z" fill="#9ED5E4"/>
                        <path
                            d="M548.5 820.3c-2.4 0-4.8-0.6-7-1.8-4.5-2.5-7.3-7.3-7.3-12.4V614.2c0-5 2.6-9.6 6.9-12.2l451.7-272.3c4.4-2.7 9.9-2.7 14.4-0.2s7.3 7.3 7.3 12.4v191.8c0 5-2.6 9.6-6.9 12.2L555.8 818.2c-2.2 1.4-4.8 2.1-7.3 2.1z m14.2-198.1v158.5l423.2-255.1V367.2l-423.2 255z"
                            fill="#154B8B"/>
                        <path d="M825.4 343.8L759.6 379l-243.7-49.8 70.7-35.3z" fill="#F7F8F9"/>
                        <path
                            d="M759.6 387c-0.5 0-1.1-0.1-1.6-0.2L514.3 337c-3.3-0.7-5.9-3.4-6.3-6.8s1.3-6.7 4.4-8.2l70.7-35.3c1.6-0.8 3.4-1 5.2-0.7L827 336c3.3 0.7 5.8 3.4 6.3 6.7 0.5 3.3-1.2 6.6-4.1 8.2l-65.8 35.2c-1.2 0.6-2.5 0.9-3.8 0.9z m-219.4-61l218.2 44.6 43.8-23.5-214.5-44.8-47.5 23.7z"
                            fill="#154B8B"/>
                    </svg>
                    TaskFlow
                </div>
                <div class="flex flex-wrap items-center justify-center antialiased lg:ml-20 pt-1">
                    <a href="/"
                       class="flex items-center justify-center mr-10 text-base text-gray-700 text-opacity-90 font-medium tracking-tight hover:text-cool-gray-600 transition duration-150 ease-in-out">
                        Inicio
                    </a>
                    <a href="/acerca"
                       class="flex items-center justify-center mr-10 text-base text-gray-700 text-opacity-90 font-medium tracking-tight hover:text-cool-gray-600 transition duration-150 ease-in-out">
                        Acerca de
                    </a>
                </div>
            </div>

            @if(Route::has('login'))
                <div class="flex items-center justify-center">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="px-6 py-3 rounded-3xl font-medium bg-gradient-to-b from-gray-900 to-black text-white outline-none focus:outline-none hover:shadow-md hover:from-true-gray-900 transition duration-200 ease-in-out">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="mr-5 text-lg font-medium text-true-gray-800 hover:text-cool-gray-700 transition duration-150 ease-in-out">Login</a>

                        @if(Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="px-6 py-3 rounded-3xl font-medium bg-gradient-to-b from-gray-900 to-black text-white outline-none focus:outline-none hover:shadow-md hover:from-true-gray-900 transition duration-200 ease-in-out">
                                Regístrese
                            </a>
                        @endif
                    @endauth

                </div>
            @endif
        </div>
        <!-- /nav -->

        <!-- hero section -->
        <div class="flex flex-col-reverse md:flex-row items-center mt-20 lg:mt-32 gap-8">
            <div class="text-left md:w-1/2 flex flex-col gap-5">
                <div class="text-4xl md:text-6xl font-semibold text-gray-900 leading-none">
                    Organiza de forma interactiva tus Tareas
                </div>
                <div class="text-xl font-light text-true-gray-500 antialiased">
                    Aprovecha mejor tu tiempo!
                </div>
                

            </div>
            <img src="https://res.cloudinary.com/dy09hqrno/image/upload/v1691588230/hero_wtour7.png" alt="hero image" class="md:w-1/2 rounded-xl mb-10 shadow-md">
        </div>

        <!-- /hero section -->

       
                <!-- /Featured Item -->

                <!-- Featured Item -->


    </div>
</div>
</body>
</html>