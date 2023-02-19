<x-layout>
    <x-slot:title>Add campground</x-slot:title>
    <x-navigation></x-navigation>
    <main class="flex flex-col">
        <section class="flex flex-col self-center p-[8%]">
            @if(session('success'))
                <x-flash-message >{{ session('success')}}</x-flash-message>
            @else
                @foreach ($errors->all() as $error)
                    <x-flash-message type="error">{{ $error}}</x-flash-message>
                @endforeach

            @endif
                <form class="flex flex-col" method="post" action="/campgrounds/add"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input name="id" value="{{Auth::user()->id ?? ''}}"  hidden/>
                    <label for="name">Campground name</label>
                    <input class="form-input" id="name" name="name"  type="text" placeholder="campground name" value="{{old('name')}}" required>

                    <label for="price"  >Price</label>

                    <input class="form-input peer" type="number" id="price" name="price" placeholder="1.00€" value="{{old('price')}}" required>

                    <label for="image">Image</label>
                    <input class="form-input peer " type="file" accept="image/*" id="image" name="image" placeholder="veuillez séléctionner une image" value="{{old('image')}}" required>

                    <label for="description">Description</label>
                    <textarea class="form-textarea" rows="5" cols="30" id="description" name="description" placeholder="lorem ipsum"    required >{{old('description')}}</textarea>
                    <button class="px-14 min-h-[1em] py-4 border-none
	rounded-md w-full my-0 bg-black text-white disabled:opacity-75">Add campground</button>
                </form>
        </section>

    </main>

</x-layout>
