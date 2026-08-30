<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold">Please fix the highlighted property form fields.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 flex gap-1 border-b border-slate-200">
        @foreach (available_locales() as $code => $info)
            <button type="button" wire:click="$set('activeLocale', '{{ $code }}')" class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-colors {{ $activeLocale === $code ? 'bg-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}">{{ $info['short'] }}</button>
        @endforeach
    </div>
    <form wire:submit="save" class="grid gap-6 lg:grid-cols-2">
        <div>
            <label class="form-label">Title</label>
            <input wire:key="property-title-{{ $activeLocale }}" wire:model="form.title.{{ $activeLocale }}" class="form-input">
            @error('form.title.'.$activeLocale)<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Slug</label>
            <input wire:model="form.slug" class="form-input">
            @error('form.slug')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="lg:col-span-2">
            <label class="form-label">Description</label>
            <textarea wire:key="property-description-{{ $activeLocale }}" wire:model="form.description.{{ $activeLocale }}" rows="5" class="form-input"></textarea>
            @error('form.description.'.$activeLocale)<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Address</label>
            <input wire:model="form.address" class="form-input">
            @error('form.address')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">City</label>
            <input wire:model="form.city" class="form-input">
            @error('form.city')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">State / Country</label>
            <input wire:model="form.state_country" class="form-input">
            @error('form.state_country')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Postal Code</label>
            <input wire:model="form.postal_code" class="form-input">
            @error('form.postal_code')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Price</label>
            <input type="number" step="0.01" wire:model="form.price" class="form-input">
            @error('form.price')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Currency</label>
            <input wire:model="form.currency" class="form-input">
            @error('form.currency')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Property Type</label>
            <select wire:model="form.property_type" class="form-input">@foreach($propertyTypes as $option)<option value="{{ $option }}">{{ ucfirst($option) }}</option>@endforeach</select>
            @error('form.property_type')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Status</label>
            <select wire:model="form.status" class="form-input">@foreach($statuses as $option)<option value="{{ $option }}">{{ ucwords(str_replace('_',' ',$option)) }}</option>@endforeach</select>
            @error('form.status')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Bedrooms</label>
            <input type="number" wire:model="form.bedrooms" class="form-input">
            @error('form.bedrooms')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Bathrooms</label>
            <input type="number" wire:model="form.bathrooms" class="form-input">
            @error('form.bathrooms')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Square Meters</label>
            <input type="number" step="0.01" wire:model="form.sqm" class="form-input">
            @error('form.sqm')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Reference ID</label>
            <input wire:model="form.property_id_ref" class="form-input">
            @error('form.property_id_ref')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="lg:col-span-2 flex items-center gap-3"><input id="featured" type="checkbox" wire:model="form.is_featured" class="rounded border-slate-300 text-dobero-blue"><label for="featured" class="text-sm text-slate-600">Featured property</label></div>
        <div>
            <label class="form-label">Main Photo</label>
            <input type="file" wire:model="mainImageUpload" class="form-input" accept="image/*">
            <p class="mt-2 text-xs text-slate-500">Used as the main listing and hero image.</p>
            @error('mainImageUpload')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Other Photos</label>
            <input type="file" wire:model="galleryImageUploads" multiple class="form-input" accept="image/*">
            <p class="mt-2 text-xs text-slate-500">You can select several gallery photos at once.</p>
            @error('galleryImageUploads')<p class="form-error">{{ $message }}</p>@enderror
            @error('galleryImageUploads.*')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        @if ($existingMainImage)
            <div class="lg:col-span-2">
                <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Current Main Photo</p>
                <div class="relative overflow-hidden rounded-2xl border border-slate-200">
                    <img src="{{ image_url($existingMainImage) }}" alt="Current main property photo" class="h-56 w-full object-cover">
                    <button type="button" wire:click="removeMainImage" class="absolute right-3 top-3 rounded-full bg-white px-3 py-1 text-xs text-rose-600">Remove main photo</button>
                </div>
            </div>
        @endif
        @if ($existingGalleryImages)
            <div class="lg:col-span-2">
                <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Current Gallery Photos</p>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($existingGalleryImages as $index => $image)
                        <div class="relative overflow-hidden rounded-2xl border border-slate-200"><img src="{{ image_url($image) }}" alt="Gallery property image {{ $index + 1 }}" class="h-40 w-full object-cover"><button type="button" wire:click="removeGalleryImage({{ $index }})" class="absolute right-3 top-3 rounded-full bg-white px-3 py-1 text-xs text-rose-600">Remove</button></div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="lg:col-span-2 border-t border-slate-200 pt-4">
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-400">SEO</p>
            <div class="grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="form-label">Meta Title</label>
                    <input wire:key="property-meta-title-{{ $activeLocale }}" wire:model="form.meta_title.{{ $activeLocale }}" class="form-input" placeholder="Override page title for search engines">
                    @error('form.meta_title.'.$activeLocale)<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Meta Description</label>
                    <textarea wire:key="property-meta-description-{{ $activeLocale }}" wire:model="form.meta_description.{{ $activeLocale }}" rows="2" class="form-input" placeholder="160-character summary for search results"></textarea>
                    @error('form.meta_description.'.$activeLocale)<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 flex gap-4">
            <button type="submit" class="btn-primary">Save Property</button>
            <a href="{{ route('admin.properties.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-600">Cancel</a>
        </div>
    </form>
</div>
