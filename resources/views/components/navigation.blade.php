
<nav
    class=" z-1000  flex
			overflow-y-scroll
			sm:overflow-hidden
			bg-white
			lg:relative
			lg:w-auto
			lg:h-auto
			pt-8
			lg:pt-16
			lg:py-0"
>
    <img class="row-start-1 row-end-1 ml-4 self-center" src="/assets/Logo.svg" alt="logo"/>
    <ul
        class="w-full hidden
	text-center  mt-4
	row-start-2 row-end-2
	lg:col-span-1 lg:row-start-1
	lg:row-end-1 lg:items-center
	lg:flex  lg:mt-0
	lg:px-0 lg:w-full
	lg:flex-row text-md sm:text-3xl tracking-wide"
    >


        <li class="mr-auto md:p-4 py-8 relative"><a href="/">Home</a></li>
        @guest
            <li class="md:p-4 py-8 relative"><a href="/signin">Login</a></li>
            <li class="md:p-4 py-8 relative"><a href="/signup">Sign up</a></li>
        @endguest
        @auth
            <li class="font-bold">{{ Auth::user()->email }}</li>
            <li class="md:p-4 py-8 relative"> <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button> Log Out</button>

                </form></li>
        @endauth
    </ul>
    <x-icon id="hamburger"
            class="cursor-pointer ml-auto mr-6 self-center   col-start-2 col-end-2 row-start-1 row-end-1 lg:hidden bg-[#f2f1ed] rounded-md text-5xl p-2"
            url="/assets/Hamburger Menu.svg"></x-icon>


</nav>
