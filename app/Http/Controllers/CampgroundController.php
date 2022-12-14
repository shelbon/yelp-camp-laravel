<?php

namespace App\Http\Controllers;

use App\Models\Campground;
use App\Models\User;
use App\Rules\UserExist;
use App\Services\CampgroundService;
use App\Services\UserService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class CampgroundController extends Controller
{
    private CampgroundService $campgroundService;
    private UserService $userService;

    public function __construct(CampgroundService $campgroundService, UserService $userService)
    {
        $this->campgroundService = $campgroundService;
        $this->userService = $userService;
    }

    public function home(Request $request): Factory|View|Application
    {
        if ($request->search) {
            return $this->search($request);
        }
        //eager load relationship to mitigate the N+1 problem
        $campground = $this->campgroundService->getCamprounds()->load('author');
        return view('campgrounds.home', ['campgrounds' => $campground]);
    }

    private function search(Request $request): Factory|View|Application
    {
        $request->validate([
            'search' => 'alpha_num|max:200'
        ]);
        Debugbar::info($request->search);
        return view('campgrounds.home', ['campgrounds' => $this->campgroundService->search($request->search)]);
    }

    public function showCampgroundDetail(Campground $campground): Factory|View|Application
    {
        //eager load relationships to mitigate the N+1 problem
        $campground = $campground->load(['author', 'reviews' => [
            'author'
        ]]);

        return view('campgrounds.detail', ['campground' => $campground]);
    }

    public function showAddCampground(): Factory|View|Application
    {

        return view('campgrounds.create');
    }

    public function processAddCampground(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'alpha_num', new UserExist($this->userService)],
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'required|url'
        ]);
        $this->campgroundService->create($validated);
        return Redirect::back()->with(['success' => "campground created"]);
    }

    public function deleteCampgrounds(Campground $campground): RedirectResponse
    {
        $response = Gate::inspect('delete', $campground);
        if (!$response->allowed()) {
            abort(403, $response->message());
        }
        $this->campgroundService->delete($campground);
        return Redirect::back()->with(['success' => "campground deleted"]);
    }

    public function showEditForm(Campground $campground)
    {
        $response = Gate::inspect('update', $campground);
        if (!$response->allowed()) {
            abort(403, $response->message());

        }
        return view('campgrounds.edit', ["campground" => $campground]);
    }

    public function processEditCampground(Request $request, Campground $campground)
    {
        $response = Gate::inspect('update', $campground);
        if (!$response->allowed()) {

            abort(403, $response->message());

        }
        $newCampground = $request->validate([
            'id' => 'required|alpha_num',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'required|url'
        ]);
        $this->campgroundService->edit($newCampground, $campground);
        return Redirect::back()->with(['success' => "campground edited"]);
    }

    public function showFormAddComment(Campground $campground, User $user): Factory|View|Application
    {
        return view('campgrounds.new-comment', ['campground' => $campground, 'userId' => Auth::user()->_id]);
    }

    public function processFormAddComment(Campground $campground, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'author_id' => ['required', 'alpha_num', new UserExist($this->userService)],
            'campground_id' => 'required|alpha_num',
            'comment' => 'required|max:255'
        ]);
        $this->campgroundService->addReview($campground, $validated);
        return \redirect('/campgrounds/' . $campground->id);
    }
}
