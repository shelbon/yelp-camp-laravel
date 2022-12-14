@props([
    'title'=>'Yelp camp',
])
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/favicon.svg"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    />
    @vite('resources/css/app.css')
    @stack('styles')

    <title>{{$title}}</title>
</head>
<body>

<div class="flex flex-col  md:px-[16%] justify-between">
    {{ $slot }}
    <footer class="flex w-full  h-[8vh]   ">
        <img class="h-1/2" src="/assets/Logo.svg" alt="logo"/>
    </footer>
</div>


</body>
</html>
