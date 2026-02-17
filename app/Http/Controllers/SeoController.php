<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * GET /sitemap.xml
     */
    public function sitemap()
    {
        $vehicles = Vehicle::where('is_available', true)->select('slug', 'updated_at')->get();
        $cities   = City::select('slug', 'updated_at')->get();

        $content = view('seo.sitemap', compact('vehicles', 'cities'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * GET /robots.txt
     */
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /admin/*\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /api/*\n\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
