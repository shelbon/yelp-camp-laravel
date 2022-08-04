<?php

namespace App\Http\Controllers;

use App\Services\CampgroundService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Http\Request;
class CampgroundController extends Controller
{
    private CampgroundService $campgroundService;

    public function __construct(CampgroundService $campgroundService){
        $this->campgroundService=$campgroundService;
    }

    public function  home(): Factory|View|Application
    {

        return view('campgrounds.home',['campgrounds'=>
            $this->campgroundService->getCamprounds()]);
    }
    public  function showCampgroundDetail(string $id): Factory|View|Application
    {
        return view('campgrounds.detail',['campground'=>$this->campgroundService->getCampgrounds($id)]);
    }
    public  function  showAddCampground() : Factory|View|Application
    {
        return view('campgrounds.create');
    }
    public  function processAddCampground(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price'=>'required|numeric',
            'image'=>'required|url'
        ]);
        $this->campgroundService->create($validated);
        return Redirect::back()->with(['success'=>"campground created"]);
    }
}
