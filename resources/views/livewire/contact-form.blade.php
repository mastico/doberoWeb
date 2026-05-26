<form wire:submit="submit" class="space-y-7">
    @if (session('contact_success'))
        <div class="border-l-4 border-primary bg-primary/10 px-4 py-3 font-sans text-sm text-navy">{{ session('contact_success') }}</div>
    @endif

    <div>
        <label class="form-label">{{ __('Inquiry Type') }}</label>
        <select wire:model="inquiry_type" class="form-input">
            <option value="">{{ __('Select an inquiry type') }}</option>
            <option value="buy">{{ __('Buy Property') }}</option>
            <option value="rent">{{ __('Rent Property') }}</option>
            <option value="investment">{{ __('Investment Search') }}</option>
            <option value="relocation">{{ __('Relocation Support') }}</option>
        </select>
        @error('inquiry_type') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-7 md:grid-cols-2">
        <div>
            <label class="form-label">{{ __('First Name') }}</label>
            <input type="text" wire:model="first_name" class="form-input" placeholder="Ada">
            @error('first_name') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="form-label">{{ __('Last Name') }}</label>
            <input type="text" wire:model="last_name" class="form-input" placeholder="Lovelace">
            @error('last_name') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="form-label">{{ __('Email') }}</label>
            <input type="email" wire:model="email" class="form-input" placeholder="ada@lovelace.uk">
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="form-label">{{ __('Phone') }}</label>
            <input type="text" wire:model="phone" class="form-input" placeholder="+34 ···">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-7 sm:grid-cols-4">
        <div>
            <label class="form-label">{{ __('Min €') }}</label>
            <input type="number" wire:model="min_price" class="form-input">
        </div>
        <div>
            <label class="form-label">{{ __('Max €') }}</label>
            <input type="number" wire:model="max_price" class="form-input">
        </div>
        <div>
            <label class="form-label">{{ __('Beds') }}</label>
            <input type="number" wire:model="bedrooms" class="form-input">
        </div>
        <div>
            <label class="form-label">{{ __('Baths') }}</label>
            <input type="number" wire:model="bathrooms" class="form-input">
        </div>
    </div>

    <div>
        <label class="form-label">{{ __('Details') }}</label>
        <textarea wire:model="message" rows="4" class="form-input" placeholder="{{ __('Tell us about the property you have in mind…') }}"></textarea>
    </div>

    <button class="btn-primary w-full justify-center">{{ __('Send Message') }} <span class="arrow">→</span></button>
</form>
