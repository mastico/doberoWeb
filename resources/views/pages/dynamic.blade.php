<x-layouts.app :title="$page->meta_title ?: $page->title" :description="$page->meta_description ?: ''">
    <article class="houzez-container py-20 pt-36">
        <h1 class="font-sans text-4xl font-bold text-navy mb-10">{{ $page->title }}</h1>
        <div class="prose max-w-none">
            {!! $page->body !!}
        </div>
    </article>
</x-layouts.app>
