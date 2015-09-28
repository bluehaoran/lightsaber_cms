<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Roumen\Feed;

class FeedController extends Controller
{


    public function rss() {

        // creating rss feed with our most recent 20 posts
        $getPosts = function() {
            DB::table('posts')->orderBy('created_at', 'desc')->take(20)->get();
        };
        $feed = $this->compileFeed($site, $getPosts);

        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        return $feed->render('rss');

        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }


    public function atom() {

        // creating rss feed with our most recent 20 posts
        $getPosts = function() {
            DB::table('posts')->orderBy('created_at', 'desc')->take(20)->get();
        };
        $feed = $this->compileFeed($site, $getPosts);

        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        return $feed->render('atom');

        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }


    /**
     * Compile a feed
     * @param type $site An object that contains data about the Site and Feed.
     * @param callable $getPosts A function that generates posts. This allows us to defer, or not-run at all if cached properly.
     * @return type
     */
    public function compileFeed($site, $getPosts) {

        // create new feed
        $feed = Feed::make();

        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(60, 'laravelFeedKey');

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached())
        {

            // set your feed's title, description, link, pubdate and language
            $feed->title = 'Your title';
            $feed->description = 'Your description';
            $feed->logo = 'http://yoursite.tld/logo.jpg';
            $feed->link = URL::to('feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = $posts[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            $posts = $getPosts();
            
            foreach ($posts as $post)
            {
               // set item's title, author, url, pubdate, description and content
               $feed->add($post->title, $post->author, URL::to($post->slug), $post->created, $post->description, $post->content);
            }

        }

        return $feed;

    }

}
