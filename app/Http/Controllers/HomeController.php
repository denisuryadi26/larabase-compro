<?php

namespace App\Http\Controllers;

use App\Models\Generator\About;
use App\Models\Generator\Client;
use App\Models\Generator\Contact;
use App\Models\Generator\Portfolio;
use App\Models\Generator\Service;
use App\Models\Generator\Slider;
use App\Models\Generator\Team;
use App\Models\Generator\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = Slider::all();
        $about = About::first();
        $services = Service::all();
        $portfolios = Portfolio::all();
        $clients = Client::all();
        $contact = Contact::first();

        return view('front.index', compact(
            'sliders',
            'about',
            'services',
            'portfolios',
            'clients',
            'contact',
        ));
    }

    public function about()
    {
        $about = About::first();
        $clients = Client::all();
        $teams = Team::all();
        $contact = Contact::first();
        $services = Service::all();

        return view('front.about', compact(
            'about',
            'clients',
            'teams',
            'contact',
            'services',
        ));
    }

    public function team()
    {
        $teams = Team::all();
        $contact = Contact::first();
        $services = Service::all();

        return view('front.team', compact(
            'teams',
            'contact',
            'services',
        ));
    }

    public function portfolio()
    {
        $portfolio = Portfolio::all();
        $contact = Contact::first();
        $services = Service::all();

        return view('front.portfolio', compact(
            'portfolio',
            'contact',
            'services',
        ));
    }

    public function contact()
    {
        $contact = Contact::first();
        $services = Service::all();

        return view('front.contact', compact(
            'contact',
            'services',
        ));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::all();
        $contact = Contact::first();
        $services = Service::all();

        return view('front.testimonials', compact(
            'testimonials',
            'contact',
            'services',
        ));
    }

    public function services()
    {
        $services = Service::all();
        $contact = Contact::first();

        return view('front.services', compact(
            'services',
            'contact',
        ));
    }
}
