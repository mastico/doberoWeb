<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegeneratePropertySlugs extends Command
{
    protected $signature = 'properties:regenerate-slugs';

    protected $description = 'Regenerate all property slugs to format: descriptive-text-{id}';

    public function handle(): int
    {
        $properties = Property::all();
        $bar = $this->output->createProgressBar($properties->count());
        $bar->start();

        foreach ($properties as $property) {
            $title = $property->getTranslation('title', config('locales.default', 'en'), true);
            $parts = array_filter([$title, $property->property_type, $property->city]);
            $base = Str::slug(implode(' ', $parts));
            $property->slug = ltrim($base, '-').'-'.$property->id;
            $property->saveQuietly();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Regenerated slugs for {$properties->count()} properties.");

        return self::SUCCESS;
    }
}
