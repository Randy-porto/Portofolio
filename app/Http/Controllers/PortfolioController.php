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

        $projects = config('portfolio.projects');
        $visibleProjects = collect($projects)->filter(fn ($project) => $category === 'semua' || $project['category'] === $category);

        return view('portfolio', [
            'projects' => $projects,
            'category' => $category,
            'visibleProjectCount' => $visibleProjects->count(),
            'visibleVisualCount' => $visibleProjects->sum(fn ($project) => count($project['visuals'] ?? [null])),
        ]);
    }

    public function show(Request $request, string $slug): View
    {
        $projects = collect(config('portfolio.projects'));
        $project = $projects->firstWhere('slug', $slug);
        abort_unless($project, 404);

        $index = $projects->search(fn ($item) => $item['slug'] === $slug);
        $visuals = $project['visuals'] ?? [];
        $requestedVisual = $request->query('gambar', '1');
        $visualIndex = is_scalar($requestedVisual) && ctype_digit((string) $requestedVisual) ? (int) $requestedVisual - 1 : 0;
        if (! isset($visuals[$visualIndex])) {
            $visualIndex = 0;
        }

        return view('project', [
            'project' => $project,
            'nextProject' => $projects[($index + 1) % $projects->count()],
            'selectedVisual' => $visuals[$visualIndex] ?? null,
            'selectedVisualIndex' => $visualIndex,
        ]);
    }
}
