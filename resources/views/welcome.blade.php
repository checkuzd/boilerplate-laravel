<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/frontend/scss/app.scss')
    </head>
    <body class="antialiased font-ms font-extralight text-white">
        
        <header class="bg-[#9BDC3D]">
            <nav class="mx-auto flex flex-col md:flex-row max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="{{ SettingsHelper::logo() }}" alt="">
                    </a>
                </div>
                <div class="flex flex-col md:flex-row lg:gap-x-12">
                    <a href="#" class="text-sm font-semibold uppercase leading-6 text-[#0a472e]">Products</a>
                    <a href="#" class="text-sm font-semibold uppercase leading-6 text-[#0a472e]">Features</a>
                    <a href="#" class="text-sm font-semibold uppercase leading-6 text-[#0a472e]">Marketplace</a>
                    <a href="#" class="text-sm font-semibold uppercase leading-6 text-[#0a472e]">Company</a>
                </div>
                <div class="flex lg:flex-1 lg:justify-end">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold leading-6 text-[#0a472e]">Dashboard <span aria-hidden="true">&rarr;</span></a>
                    @else
                        <a href="{{ route('admin.login') }}" class="text-sm font-semibold leading-6 text-[#0a472e]">Log in <span aria-hidden="true">&rarr;</span></a>
                    @endif
                </div>
            </nav>
        </header>

        <section class="hero relative overflow-hidden">
            <div class="absolute bg-[#0a472e] w-full h-full z-10 bg-opacity-50"></div>
            <div class="absolute z-20 flex items-center justify-center h-full w-full">
                <div class="h-full flex flex-col justify-center gap-5">
                    <h1 class="font-gh text-white text-4xl">Agri Expo 2024</h1>
                    <a class="rounded-full inline-block text-center py-2 px-5 uppercase bg-[#0a472e] text-[#9BDC3D]" href="/shop">Shop Now</a>
                </div>
            </div>
            <img src="https://picsum.photos/1920/600" 
                alt="hero-image" 
                class="w-full transition-transform duration-300 ease-in-out transform hover:scale-110"
            />
        </section>

        <footer class="bg-[#0a472e]">
            <div class="p-20">
                <div class="flex flex-col md:grid grid-cols-5 gap-10">
                    <div>
                        <h3 class="font-gh mb-5 text-white text-lg tracking-wider">Store Location</h3>
                        <p class="text-[#9bdc3d]">9066 Green Lake Drive Chevy Chase, MD 20815</p>
                        <a href="mailto:contact@example.com">
                            <div class="mt-5 pb-4 border-b-2 inline-block">
                                contact@example.com
                            </div>
                        </a>
                        
                    </div>
                    <div>
                        <h3 class="font-gh mb-5 text-white">Information</h3>
                        <p class="text-[#9bdc3d]">9066 Green Lake Drive Chevy Chase, MD 20815</p>
                        <p><a href="mailto:contact@example.com">contact@example.com</a></p>
                    </div>
                    <div>
                        <h3 class="font-gh mb-5 text-white">My Account</h3>
                        <p class="text-[#9bdc3d]">9066 Green Lake Drive Chevy Chase, MD 20815</p>
                        <p><a href="mailto:contact@example.com">contact@example.com</a></p>
                    </div>
                    <div>
                        <h3 class="font-gh mb-5 text-white">Categories</h3>
                        <p class="text-[#9bdc3d]">9066 Green Lake Drive Chevy Chase, MD 20815</p>
                        <p><a href="mailto:contact@example.com">contact@example.com</a></p>
                    </div>
                    <div>
                        <h3 class="font-gh mb-5 text-white">Subscribe us</h3>
                        <p class="text-[#9bdc3d]">9066 Green Lake Drive Chevy Chase, MD 20815</p>
                        <p><a href="mailto:contact@example.com">contact@example.com</a></p>
                    </div>
                </div>
            </div>
            <div class="bg-[#9BDC3D]">
                <div class="px-10 py-1 font-gh text-center text-[#0a472e]">© {{ date('Y') }} Boilerplate</div>
            </div>
        </footer>
        
    </body>
</html>
