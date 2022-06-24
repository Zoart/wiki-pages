<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Models\WikiPage;
use Illuminate\Support\Facades\Log;

class GetArticleController extends Controller
{

    public function index() {

        return view('home', [
            'plain_article_texts' => WikiPage::get(),
        ]);
    }
    public function findPage(Request $request) {
        $page_title = $request->articleName;
        $plain_wiki_text = $this->request_wiki_page($page_title);
        $this->save_aricle_plain_text($page_title, $plain_wiki_text);

        return redirect('/');
    }

    public function save_aricle_plain_text($page_title, $page_text_content) {
        $newWikiPage = new WikiPage;
        $newWikiPage->article_title = $page_title;
        $newWikiPage->article_text = $page_text_content;
        $newWikiPage->save();
    }

    public function request_wiki_page($page_title) {
        $searchPage = $page_title;

        $endPoint = "https://ru.wikipedia.org/w/api.php";
        $params = [
            "action" => "query",
            'prop' => 'extracts',
            // 'exintro' => '',
            'origin' => '*',
            'explaintext' => '',
            "format" => "json",
            "exlimit" => "max",
            "utf8" => "1",
            'redirects'=>'true',
            'titles' => $searchPage,
        ];

        $url = $endPoint . "?" . http_build_query( $params );
        $get_content = file_get_contents($url);
        $decode = json_decode($get_content, true);
        $plain_wiki_text = ((current($decode['query']['pages'])['extract']));

        return $plain_wiki_text;
    }
}
