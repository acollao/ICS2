<div class="fixed inset-0 z-50 bg-white bg-opacity-80 flex items-center justify-center p-8" x-data="{show: true}" x-show="show">
    <div class="{{ $backgroundCSS() }} w-full md:w-1/2 rounded-xl p-8">
        <h3 class="text-3xl">{{ $title }}</h3>
        <div class="mt-4">
            {{ $message }}
        </div>
        <button class="mt-8 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md 
        font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 
        focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled: opacity-25 transition ease-in-out duration-150" x-on:click="show=false">
            Close
        </button>
    </div>
</div>