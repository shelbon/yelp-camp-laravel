<x-layout>
    @pushonce('styles')
        <link rel="stylesheet" href="/css/500.css">
    @endpushonce
    <div class="container">
        <h1 class="header">403 ERROR</h1>
        <section class="instructions">
            <h2>{{ $exception->getMessage() }}</h2>
            <a href="/campgrounds" class="hover:underline">go back</a>
        </section>
    </div>
    <!-- TODO style -->
</x-layout>
