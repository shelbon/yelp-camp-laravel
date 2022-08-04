<x-layout>
    <x-navigation></x-navigation>
    <section class="container grid grid-cols-2">
        <section class="map">
            <img src="/assets/Map.png" alt="localisation campground">
        </section>
        <section>
            <header>
                <img src="{{$campground->image}}" alt="campground image">
                <p class="font-bold">{{$campground->title}}</p>
                <p>{{$campground->description}}</p>
            </header>
            <section>
                commentaire list
            </section>
        </section>
    </section>
</x-layout>
