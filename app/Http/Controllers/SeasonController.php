<?php

namespace App\Http\Controllers;

use App\Enums\SeasonTypes;
use App\Iframes\SeasonIframe;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeasonController extends Controller
{
    public function index()
    {
        return view('admin.seasons.index', [
            'seasonsCount' => Season::count(),
            'fourSeasons' => [
                SeasonTypes::Special->name =>
                    Season::where('type_SHML', '=', SeasonTypes::Special->value)
                        ->get(['id', 'type_SHML', 'date_from', 'date_to', 'description', 'is_active']),
                SeasonTypes::High->name =>
                    Season::where('type_SHML', '=', SeasonTypes::High->value)
                        ->get(['id', 'type_SHML', 'date_from', 'date_to', 'description', 'is_active']),
                SeasonTypes::Medium->name =>
                    Season::where('type_SHML', '=', SeasonTypes::Medium->value)
                        ->get(['id', 'type_SHML', 'date_from', 'date_to', 'description', 'is_active']),
                SeasonTypes::Low->name =>
                    Season::where('type_SHML', '=', SeasonTypes::Low->value)
                        ->get(['id', 'type_SHML', 'date_from', 'date_to', 'description', 'is_active']),
            ],
        ]);
    }

    public function create()
    {
        return view('admin.seasons.create');
    }

    public function store(Request $request)
    {
        Season::create($this->validateSeason($request));

        return SeasonIframe::iframeCUClose() . '<br>' . SeasonIframe::reloadParent();
    }

    public function edit(Season $season)
    {
        return view('admin.seasons.edit', [
            'season' => $season,
        ]);
    }

    public function update(Request $request, Season $season)
    {
        $season->update($this->validateSeason($request, $season));

        return SeasonIframe::iframeCUClose() . '<br>' . SeasonIframe::reloadParent();
    }

    public function delete(Season $season)
    {
        return view('admin.seasons.delete', [
            'seasonDetails' => "$season->date_from to $season->date_to $season->type_SHML",
        ]);
    }

    public function destroy(Season $season)
    {
        $season->delete();

        return SeasonIframe::reloadParent();
    }

    public function validateSeason(Request $request, Season $season = null)
    {
        $attributes = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'type' => [
                'required',
                Rule::in(SeasonTypes::values()),
                Rule::unique('seasons', 'type_SHML')
                    ->ignore($season->type_SHML ?? '', 'type_SHML')
                    ->where('date_from', $request->input('from') ?? $season?->date_from)
                    ->where('date_to', $request->input('to') ?? $season?->date_to),
            ],
            'description' => 'required|string',
            'active' => 'nullable',
        ]);

        $attributes['active'] = (bool)($attributes['active'] ?? false);

        return [
            'date_from' => $attributes['from'],
            'date_to' => $attributes['to'],
            'type_SHML' => $attributes['type'],
            'description' => $attributes['description'],
            'is_active' => $attributes['active'],
        ];
    }
}
