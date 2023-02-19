<x-layout>
    @pushonce('styles')
        <link rel="stylesheet" href="/css/campground-detail.css">
    @endpushonce
    <x-navigation></x-navigation>
    <section class="container justify-center  flex flex-col px-4 lg:flex-row lg:justify-between lg:px-0  basis-[50%]"
             style="--gap:5rem;">
        <section class="order-2  w-full h-fit lg:order-1  border border-solid rounded  lg:w-auto ">
            <img class="   w-full mx-auto p-4    lg:mx-0" src="/assets/Map.png" alt="localisation campground">
        </section>
        <section class="  min-w-fit   order-1  space-y-10 w-fit max-w-[10%]
            md:p-0 lg:order-2 lg:order-2 lg:max-w-none   lg:min-w-0 ">
            <header class="flex flex-col w-full p-8 lg:p-16 border border-solid rounded" style="--gap: 1rem">
                <img class=" aspect-square  w-full h-[35rem] self-center   rounded"
                     src="{{$campground->getImage()?->getUrl() ?? Storage::url(env('AWS_S3_KEY')."image-not-found.png")}}"
                     alt="campground image">
                <p class="flex font-bold my-4 text-4xl justify-between">{{$campground->title}}<span
                        class="text-3xl font-normal">{{$campground->price}}€/night</span>
                </p>
                <p>{{$campground->description}}</p>
                <p class="mt-4">Submitted by {{$campground->author?->username ?? " an anonymous user"}}</p>
            </header>
            <section class="p-16   border border-solid rounded ">

                @foreach($campground->reviews as $review)
                    <article class="comment relative pb-4 pr-4 pt-4 space-x-0.5 ">
                        <header class="flex justify-between">
                            <p class="font-bold">{{$review->author->username}}</p>
                            <p class="">{{$review->created_at->diffForHumans()}}</p>
                        </header>
                        <p class="pb-6">
                            {{$review->body}}
                        </p>
                    </article>
                @endforeach

                <footer class="flex justify-end">
                    @csrf
                    <div class="self-center px-8 py-6  md:min-h-[1em]   border-none
	rounded-md   my-0 ml-4 bg-black text-white w-fit review-icon">
                        <a class=" ml-8" href="/campgrounds/{{$campground->id}}/comment">Leave a review</a>
                    </div>

                </footer>
            </section>
        </section>
    </section>
</x-layout>
