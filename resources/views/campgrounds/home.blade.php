<x-layout>
    <x-slot:title>
        Campgrounds
    </x-slot:title>
    <section class="px-[8%]">
        <header>
            <x-navigation  ></x-navigation>
            <section class=" p-8   flex flex-col space-y-2 bg-[#f9f6f1] text-start">
                <div class=" p-8 w-2/5 space-y-4">
                    <h1 class="font-bold subpixel-antialiased text-4xl">Welcome to YelpCamp</h1>
                    <p>View our hand-picker campgrounds from all overt the world, or add your own.</p>
                    <form class="flex  ">
                        <div
                            class="flex items-center
	            rounded-md border-2
				p-4   border-black border-opacity-40 bg-white"
                        >
                            <x-icon url="/assets/search.svg"></x-icon>
                            <input
                                class=" mis-4 border-none outline-none placeholder:text-black opacity-75  bg-transparent"
                                type="text"
                                placeholder="Search for camps"
                            />
                        </div>
                        <input
                            type="submit"
                            value="Search"
                            class="px-14 min-h-[1em] py-4 border-none
	rounded-md w-full my-0 bg-black text-white "
                        />
                    </form>
                    <a class="block   text-[#97948f] underline underline-offset-1" href="/campgrounds/add"
                    >Or add your own campground</a>
                </div>
            </section>

        </header>
        <h1 class="font-bold text-5xl p-4">Campgrounds</h1>
        @if(count($campgrounds) > 0 )

            <ul class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($campgrounds as $campground)
                    <li class="px-4">
                        <article
                            class="border-solid border-2 rounded-lg p-4
                grid grid-cols-1 grid-rows-[min-content_1fr_min-content]
				gap-y-4">
                            @if(Auth::user() && Auth::user()->_id == $campground->author)
                                <form action="/campgrounds/{{$campground->id}}" method="POST" class="flex justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <button aria-label="delete campground {{$campground->name}}"
                                            class=" focus:outline-none w-12 h-12 border border-[0.150rem] rounded-full  border-red-200 flex items-center flex-shrink-0 justify-center">
                                        <img alt="delete icon" class="h-12 w-12"
                                             src="https://api.iconify.design/charm/cross.svg?color=%23b91c1c"/></button>
                                </form>
                            @endif
                            <img class="rounded-lg grid-row-start-1 grid-row-end-1" src="{{$campground->image}}"
                                 alt="campground thumbnail"/>
                            <section class="grid-row-start-2 grid-row-end-2">
                                <h2 class=" mx-4 my-4 font-bold subpixel-antialiased text-2xl">{{$campground->title}}</h2>
                                <p class=" mx-4">{{$campground->description}}</p>
                            </section>
                            <section class="flex">
                                <a
                                    class="grid-row-start-3 grid-row-end-3 cursor-pointer bg-transparent border-[0.1rem] border-solid
	border-[#dcdcdc] rounded-md
	text-black font-bold p-6 mx-4 mt-8 md:mt-6
	text-center
	 lg:text-3xl lg:p-6"
                                    role="button"
                                    href="/campgrounds/{{$campground->id}}">View</a>
                                @if( Auth::user() && Auth::user()->_id == $campground->author)
                                    <a
                                        class="grid-row-start-3 grid-row-end-3 cursor-pointer bg-transparent border-[0.1rem] border-solid
	border-[#dcdcdc] rounded-md
	text-black font-bold p-6 mx-4 mt-8 md:mt-6
	text-center
	 lg:text-3xl lg:p-6"
                                        role="button"
                                        href="/campgrounds/{{$campground->id}}/edit">Edit</a
                                    >
                                @endif
                            </section>

                        </article>
                    </li>
                @endforeach
            </ul>
        @else
            <section>
                No campgrounds
            </section>
        @endif

    </section>
</x-layout>
