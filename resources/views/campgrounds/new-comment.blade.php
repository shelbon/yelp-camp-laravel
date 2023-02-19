<x-layout>
    <div class="md:px-[8%] h-[100vh]">
        <x-navigation></x-navigation>
        <div class="w-1/2 space-y-16">
            <h1 class="font-bold text-4xl">Add new comment</h1>
            @if(session('success'))
                <x-flash-message >{{ session('success')}}</x-flash-message>
            @else
                @foreach ($errors->all() as $error)
                    <x-flash-message type="error">{{ $error}}</x-flash-message>
                @endforeach

            @endif
            <form class="space-y-16"  name="commentForm" action="/campgrounds/{{$campground->id}}/comment" method="post">
                @csrf
                <label for="new-comment">Description</label>
                <input name="author_id" value="{{$userId}}" hidden>
                <input name="campground_id" value="{{$campground->id}}" hidden>
                <textarea class="w-full bg-[#F7F7F7] resize-none p-4 rounded"
                          placeholder="This was probably the best camp I've visited this past year definitely recommend any time soon"
                          name="comment" id="new-comment" value="{{old('comment')}}" cols="30" rows="10"></textarea>
                <input type="submit" name="submitBtn" class="px-14 min-h-[1em] py-4 border-none
	rounded-md w-full my-0 bg-black text-white disabled:opacity-75" value="Post comment">
            </form>
        </div>
    </div>
    @pushonce("scripts")
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.forms['commentForm'];
                form?.addEventListener('submit', function (event) {
                    event.preventDefault();
                    form.elements.submitBtn.disabled = true;
                    setTimeout(function () {
                        form.submit();
                    },250);
                });
            })
        </script>
    @endpushonce
</x-layout>
