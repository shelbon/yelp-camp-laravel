@props([
    "class"=>'',
    "type"=>'success',
    "containerColors"=>[
        'success'=>'bg-green-100',
        'error'=>'bg-red-100',
        'info'=>'bg-blue-100'],
    "imgColors"=>[
        'success'=>'border-green-600',
        'error'=>'border-red-200',
        "info"=>"border-blue-200"
],
    "textColors"=>['success'=>'text-green-700',
        'error'=>'text-red-700',
        'info'=>'text-blue-700'],

])
<article class="p-3 mt-4 {{ $containerColors[$type]}} rounded flex items-center">
    <div tabindex="0" aria-label="error icon" role="img"
         class="focus:outline-none w-8 h-8 border rounded-full {{$imgColors[$type]}} flex items-center flex-shrink-0 justify-center">
        @if($type=="error")

            <img src="https://api.iconify.design/charm/cross.svg?color=%23b91c1c" alt="icon"/>
        @elseif($type=="success")
            <img src="https://api.iconify.design/charm/tick.svg?color=%2316a34a" alt="icon">
        @else
            <img src="https://api.iconify.design/charm/info.svg?color=%231E3A8A" alt="icon">
        @endif
    </div>
    <div class="p-3 flex items-center justify-between">
        <p tabindex="0"
           class="focus:outline-none text-sm leading-none  {{ $textColors[$type]}}">
            {{$slot}}</p>

    </div>
</article>
