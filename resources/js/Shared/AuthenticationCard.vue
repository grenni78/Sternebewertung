<template>
    <div class="authentication-card min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-600 bg-img-security bg-img">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-800 bg-opacity-80 shadow-xl overflow-hidden sm:rounded-lg">
            <slot />
        </div>
        <div class="image-copyright">Bild von <a href="https://pixabay.com/de/users/insspirito-1851261/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1278069">Garik Barseghyan</a> auf <a href="https://pixabay.com/de/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1278069" rel="noreferrer noopener">Pixabay</a></div>
    </div>
</template>
