<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use App\Models\Property;
use Illuminate\View\View;

class PropertyLandingController extends Controller
{
    public function show(string $type, string $location, string $status = 'for_sale'): View
    {
        $properties = Property::query()
            ->where('status', $status)
            ->where('property_type', $type)
            ->where(fn ($q) => $q
                ->whereRaw('LOWER(city) = ?', [strtolower($location)])
                ->orWhereRaw('LOWER(city) LIKE ?', ['%'.strtolower($location).'%'])
            )
            ->latest()
            ->paginate(12);

        // Load an optional SEO intro paragraph from page_sections
        $sectionKey = "property_landing.{$type}.{$location}";
        $intro = PageSection::getSection('property_landing', $sectionKey);

        $statusLabel = $status === 'for_rent' ? 'for rent' : 'for sale';
        $title = ucfirst($type).'s '.ucfirst($statusLabel).' in '.ucfirst($location);

        $canonical = url()->current();

        return view('pages.property-landing', compact(
            'properties', 'intro', 'title', 'type', 'location', 'status', 'statusLabel', 'canonical'
        ));
    }
}
