<x-layout>
    <x-slot:title>
        {{$title}}
    </x-slot:title>
    <div
        class="grid grid-rows-[8vh_1fr_1fr]
              bg-white
			lg:grid-cols-[60vw_40vw]  lg:min-h-screen"
    >
        <header
            class="flex justify-start items-center
	               row-start-1 row-end-1  px-4
				   lg:col-start-1 lg:col-end-1
				   lg:px-60"
        >
            <a href="/"><img class="ml-4" src="/assets/Logo.svg" alt="logo" /></a>

            <span class="ml-auto flex items-center space-x-1">
			<Icon icon="la:long-arrow-alt-left" inline={true} />
			<a href="/campgrounds"> Back to campgrounds</a>
		</span>
        </header>
        <main class="row-start-2 row-end-2 mt-36 px-4 md:pr-16   lg:px-60 ">
            <p class=" text-6xl font-bold p-4">Start exploring camps from all around the world.</p>
            {{$slot}}
        </main>
        <section
            class="row-span-3 bg-[#f9f6f1] grid grid-rows-1 grid-cols-1  place-items-start items-center "
        >
            <figure
                class="grid grid-rows-[max-content_min-content] grid-cols-[5vw_10vw_1fr_1fr]
		           gap-8 p-4 lg:p-52 "
            >
                <blockquote
                    class="row-start-1 rows-end-1 col-span-4
				        text-center space-y-4 md:p-8 md:text-left
						 lg:p-0"
                >
                    <p class="text-2xl sm:text-4xl  font-semibold tracking-wide">
                        “YelpCamp has honestly saved me hours of research time,and the camps on here are
                        definitely well picked and added.”
                    </p>
                </blockquote>
                <img
                    class="row-start-2 row-end-2
				       col-start-2 col-end-2
					   lg:col-start-1
					   w-24 h-24  md:h-auto
					   self-start
					    "
                    src="assets/User Testimonial.svg"
                    alt=""
                    width="384"
                    height="512"
                />
                <figcaption class="row-start-2 row-end-2 col-span-3 font-medium">
                    <div class="text-dark">May Andrews</div>
                    <div class="text-gray-500">Professional Hiker</div>
                </figcaption>
            </figure>
        </section>
    </div>
</x-layout>
