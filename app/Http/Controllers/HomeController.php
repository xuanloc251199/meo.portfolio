<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\ResumeEntry;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tool;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'projects' => Project::with('tags')->orderBy('sort_order')->get(),
            'tools' => Tool::orderBy('sort_order')->get(),
            'services' => Service::with('tags')->orderBy('sort_order')->get(),
            'education' => ResumeEntry::where('type', ResumeEntry::TYPE_EDUCATION)->orderBy('sort_order')->get(),
            'experience' => ResumeEntry::where('type', ResumeEntry::TYPE_EXPERIENCE)->orderBy('sort_order')->get(),
            'achievements' => Achievement::orderBy('sort_order')->get(),
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }
}
