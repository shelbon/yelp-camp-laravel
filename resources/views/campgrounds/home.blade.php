<x-layout>
    <x-slot:title>
        Campgrounds
    </x-slot:title>
    <section>
        <header>
            <x-navigation  ></x-navigation>
            <section class=" p-8   flex flex-col space-y-2 bg-[#f9f6f1] text-start">
                <div class=" p-8 md:w-2/5 space-y-4">
                    <h1 class="font-bold subpixel-antialiased text-5xl md:text-4xl">Welcome to YelpCamp</h1>
                    <p class="text-[#3E3C3A]">View our hand-picker campgrounds from all overt the world, or add your own.</p>
                    @foreach ($errors->all() as $error)
                        <x-flash-message type="error" texte="{{ $error}}"></x-flash-message>
                    @endforeach
                    <form class="flex flex-col" method="GET">

                        <div
                            class="flex  items-center
	            rounded-md border-2
				p-4   border-black border-opacity-40 bg-white md:basis-3/4 "
                        >
                            <x-icon url="/assets/search.svg"></x-icon>
                            <input
                                class="border-none w-full outline-none placeholder:text-black opacity-75  bg-transparent"
                                type="text"
                                name="search"
                                value="{{old('search')}}"
                                placeholder="Search for camps"
                                required
                            />

                        </div>
                        <input
                            type="submit"
                            value="Search"
                            class=" px-14 py-4  md:min-h-[1em]   border-none
	rounded-md w-full my-0 bg-black text-white md:basis-1/12"
                        />
                    </form>
                    <a class="block  text-[#3E3C3A]" href="/campgrounds/add"
                    ><p class="underline underline-offset-1">Or add your own campground</p></a>
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
                            @if(Auth::user() && Auth::user()?->id == $campground?->author?->id)
                                <form action="/campgrounds/{{$campground->id}}" method="POST" class="flex justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <button aria-label="delete campground {{$campground->name}}"
                                            class=" focus:outline-none w-12 h-12 border border-[0.150rem] rounded-full  border-red-200 flex items-center flex-shrink-0 justify-center">
                                        <img alt="delete icon" class="h-12 w-12"
                                             src="https://api.iconify.design/charm/cross.svg?color=%23b91c1c"/></button>
                                </form>
                            @endif
                            <img class="aspect-square w-full rounded-lg grid-row-start-1 grid-row-end-1" src="{{$campground->image}}"
                                 alt="campground thumbnail"/>
                            <section class="grid-row-start-2 grid-row-end-2">
                                <h2 class=" mx-4 my-4 font-bold subpixel-antialiased text-2xl">{{$campground->title}}</h2>
                                <p class=" mx-4">{{$campground->description}}</p>
                            </section>
                            <section class="flex justify-center">
                                <a
                                    class="grid-row-start-3 grid-row-end-3 cursor-pointer
                                           bg-transparent border-[0.1rem] border-solid
	                                       border-[#dcdcdc] rounded-md text-black
	                                       font-bold p-6 mx-4 mt-8 md:mt-6
	                                       text-center lg:text-3xl lg:p-6"
                                    role="button"

                                    href="/campgrounds/{{$campground->id}}">View campground</a>

                                @if( Auth::user() && Auth::user()?->id == $campground?->author?->id)
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
            <section class="flex flex-col h-1/2 justify-center">
                <p class="self-center">No campgrounds</p>
            </section>
        @endif

    </section>
</x-layout>
