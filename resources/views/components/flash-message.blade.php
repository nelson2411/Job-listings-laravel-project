@if(session()->has('success'))
    <div x-data="{show:true}" 
         x-init="setTimeout(() => show = false, 3000)" 
         x-show="show" 
         class="fixed top-0 p-5 left-1/2 transform-translate-x-1/2 bg-laravel">
        <p>{{ session('success') }}</p>
        
    </div>
@endif