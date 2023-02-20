<x-layout>
    <x-slot:title>
        Yelp camp
    </x-slot:title>
    <section
        class="grid grid-rows-[8vh_min-content_max-content]
	       lg:grid-rows-[8vh_min-content_max-content]
		   lg:grid-cols-[60vw_40vw]"
    >
        <header
            class="flex justify-start items-center
	               row-start-1 row-end-1
				   lg:col-start-1 lg:col-end-1
				   lg:pl-24"
        >
            <img class="ml-4" src="{{asset('/assets/Logo.svg')}}" alt="logo" />
        </header>
        <picture class="row-start-2 row-end-2 lg:row-span-3 lg:col-start-2 lg:col-end-2">
            <source media="(min-width:1024px)" srcset="/assets/Hero_Image.jpg" />
            <img
                class="w-full  lg:h-screen"
                src="/assets/Hero Image (Tablet and Mobile).jpg"
                alt="camping "
            />
        </picture>
        <section
            class="row-start-3 row-end-3
	           space-y-6 pt-12 pl-6
			   lg:col-start-1 lg:col-end-1
			   lg:row-start-2 lg:row-end-3
			   lg:pl-24 lg:pt-24
			   lg:space-y-8"
        >
            <h1 class="font-bold tracking-wider text-5xl md:text-7xl lg:text-9xl">
                Explore the best camps on Earth.
            </h1>
            <p class="text-md opacity-70 md:text-3xl tracking-wide leading-relaxed">
                YelpCamp is a curated list of the best camping spots on Earth.Unfiltered and unbiased reviews
            </p>
            <ul class="space-y-4 lg:space-y-12">
                <li class="relative before:content-[url(/public/assets/Checkmark.svg)] before:absolute before:left-0">
                    <p class="pl-12 opacity-70 md:text-3xl">Add your own camp suggestions.</p>
                </li>
                <li class="relative before:content-[url(/public/assets/Checkmark.svg)] before:absolute before:left-0">
                    <p class="pl-12 opacity-70 md:text-3xl">Leave reviews and experiences.</p>
                </li>
                <li class="relative before:content-[url(/public/assets/Checkmark.svg)] before:absolute before:left-0">
                    <p class="pl-12 opacity-70 md:text-3xl">See locations for all camps.</p>
                </li>
            </ul>
            <a
                role="button"
                href="/campgrounds"
                class=" inline-block bg-black border-2 border-solid
		                 border-transparent rounded-md
						 text-white  p-4
						  lg:text-3xl lg:p-6 ">View Campgrounds
            </a>
            <div>
                <p>Partnered with:</p>
                <ul class="flex p-4 space-x-4 ">
                    @foreach($banners as $banner)
                        <li class="item">
                            <img src="{{$banner->src}}" alt="logo of {{$banner->name}}" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </section>
</x-layout>
