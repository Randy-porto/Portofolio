<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('kategori', 'semua');
        if (! is_string($category) || ! array_key_exists($category, config('portfolio.categories'))) {
            $category = 'semua';
        }

        return view('portfolio', [
            'projects' => config('portfolio.projects'),
            'category' => $category,
        ]);
    }

    public function show(string $slug): View
    {
        $projects = collect(config('portfolio.projects'));
        $project = $projects->firstWhere('slug', $slug);
        abort_unless($project, 404);

        $index = $projects->search(fn ($item) => $item['slug'] === $slug);

        return view('project', [
            'project' => $project,
            'nextProject' => $projects[($index + 1) % $projects->count()],
        ]);
    }
}
