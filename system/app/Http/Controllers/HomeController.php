<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thujohn\Twitter\Facades\Twitter;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Session::has('oauth_request_token')){

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && !isset($credentials->error))
            {
                $feeds = Twitter::getUserTimeline(['count' => 20, 'format' => 'json']);
                $tweets = json_decode($feeds, true);
                return view('home',$tweets);
            }
            else
            {
                return redirect("/feeds");
            }
        }
        else
        {
            return redirect("/feeds");
        }
    }
    public function web()
    {
        
        return view('home');
    }
    public function tweet(Request $req)
    {
        if (Session::has('oauth_request_token')){

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && !isset($credentials->error))
            {
                
                Twitter::postTweet(['status' => $req->get("tweet"), 'format' => 'json']);
                return back();
            }
            else
            {
                return redirect("/feeds");
            }
        }
        else
        {
            return redirect("/feeds");
        }


        
    }
    public function retweet(Request $req)
    {
        if (Session::has('oauth_request_token')){

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && !isset($credentials->error))
            {
                
                Twitter::postTweet(['status' => $req->get("tweet"), 'format' => 'json']);
                return back();
            }
            else
            {
                return redirect("/feeds");
            }
        }
        else
        {
            return redirect("/feeds");
        }


        
    }
}
