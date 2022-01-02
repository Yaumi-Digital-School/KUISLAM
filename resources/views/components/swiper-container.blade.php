{{-- {{ dd($classBot) }} --}}
<div class="{{ isset($classTop) ? $classTop : 'relative swiper-container'}}">
    <div class="{{ isset($classBot) ? $classBot : 'swiper w-full h-56 md:h-64 p-2'}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">

            <!-- Slides -->
            {{ $slot }}

        </div>

        {{-- navigation if needed  --}}
        {{ isset($nav_btn) ? $nav_btn : ''}}

        {{-- pagination if needed  --}}
        {{ isset($pagination) ? $pagination : '' }}
    </div>
</div>