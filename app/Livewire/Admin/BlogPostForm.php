<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\BlogPost;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class BlogPostForm extends Component
{
    use HandlesTranslations;
    use WithFileUploads;

    public string $activeLocale = 'en';

    public ?BlogPost $post = null;

    public array $form = [];

    public $imageUpload;

    public function mount(?BlogPost $post = null): void
    {
        $this->post = $post?->exists ? $post : null;
        $this->form = [
            'title' => $this->post ? $this->fillTranslations($this->post->getTranslations('title')) : $this->blankTranslations(),
            'slug' => $this->post?->slug ?? '',
            'excerpt' => $this->post ? $this->fillTranslations($this->post->getTranslations('excerpt')) : $this->blankTranslations(),
            'content' => $this->post ? $this->fillTranslations($this->post->getTranslations('content')) : $this->blankTranslations(),
            'image' => $this->post?->image ?? '',
            'category' => $this->post?->category ?? '',
            'author' => $this->post?->author ?? '',
            'published_at' => optional($this->post?->published_at)->format('Y-m-d\TH:i'),
            'is_published' => $this->post?->is_published ?? true,
        ];
    }

    public function save()
    {
        $rules = [
            'form.slug' => ['nullable', 'string', 'max:255'],
            'form.category' => ['nullable', 'string', 'max:255'],
            'form.author' => ['nullable', 'string', 'max:255'],
            'form.published_at' => ['nullable', 'date'],
            'form.is_published' => ['boolean'],
            'imageUpload' => ['nullable', 'image', 'max:2048'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $required = $locale === default_locale() ? 'required' : 'nullable';
            $rules["form.title.{$locale}"] = [$required, 'string', 'max:255'];
            $rules["form.excerpt.{$locale}"] = ['nullable', 'string'];
            $rules["form.content.{$locale}"] = [$required, 'string'];
        }

        $this->validate($rules);

        if ($this->imageUpload) {
            $this->form['image'] = $this->imageUpload->store('blog', 'public');
        }

        $englishTitle = $this->form['title'][default_locale()] ?? '';
        $this->form['slug'] = filled($this->form['slug']) ? Str::slug($this->form['slug']) : Str::slug($englishTitle);

        $post = BlogPost::updateOrCreate(['id' => $this->post?->id], Arr::except($this->form, ['title', 'excerpt', 'content']));
        $post->setTranslations('title', $this->normalizeTranslations($this->form['title']));
        $post->setTranslations('excerpt', $this->normalizeTranslations($this->form['excerpt']));
        $post->setTranslations('content', $this->normalizeTranslations($this->form['content']));
        $post->save();

        Cache::forget('homepage.posts');
        session()->flash('status', 'Blog post saved successfully.');

        return $this->redirectRoute('admin.blog.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.blog-post-form')->layout('components.layouts.admin', ['title' => $this->post ? 'Edit Blog Post' : 'Create Blog Post']);
    }
}
