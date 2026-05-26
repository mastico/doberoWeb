<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $page = Page::findBySlug($slug);
        abort_unless($page, 404);

        $locale = app()->getLocale();
        $canonical = $page->getTranslation('slug', $locale, true);

        if ($canonical && $canonical !== $slug) {
            return redirect()->to($page->urlFor($locale), 301);
        }

        return view('pages.dynamic', ['page' => $page]);
    }
}
