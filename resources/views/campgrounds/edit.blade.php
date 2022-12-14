<x-layout>
    <x-slot:title>Add campground</x-slot:title>
    <x-navigation></x-navigation>
    <main class="flex flex-col">
        <section class="flex flex-col self-center p-[8%]">
            @if(session('success'))
                <x-flash-message texte="{{ session('success')}}"></x-flash-message>
            @else
                @foreach ($errors->all() as $error)
                    <x-flash-message type="error" texte="{{ $error}}"></x-flash-message>
                @endforeach

            @endif
            <form class="flex flex-col" method="post" action="/campgrounds/{{$campground->id}}">
                {{ csrf_field() }}
                @method('PUT')
                <input name="id" value="{{$campground->id}}" hidden>
                <label for="title">Campground name</label>
                <input class="form-input" id="title" name="title" type="text" placeholder="campground name"
                       value="{{$campground->title ?? old('title')}}" required>

                <label for="price">Price</label>

                <input class="form-input peer" type="number" id="price" name="price" placeholder="1.00€"
                       value="{{$campground->price ?? old('price')}}" required>

                <label for="image">Image</label>
                <input class="form-input peer " id="image" name="image" placeholder="http://image.com"
                       value="{{$campground->image ?? old('image')}}" required>

                <label for="description">Description</label>
                <textarea class="form-textarea" rows="5" cols="30" id="description" name="description"
                          placeholder="lorem ipsum"
                          required>{{$campground->description ?? old('description')}}</textarea>
                <button class="px-14 min-h-[1em] py-4 border-none
	rounded-md w-full my-0 bg-black text-white">edit campground
                </button>
            </form>
        </section>

    </main>
</x-layout>
