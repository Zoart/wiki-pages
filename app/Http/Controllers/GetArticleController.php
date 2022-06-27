<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Models\WikiPage;
use App\Models\WikiAtomText;
use Throwable;

class GetArticleController extends Controller
{


    public function index() {
        return view('home');
    }

    public function get_wiki_page() {
        return view('result', [
            'article_informations' => WikiPage::get(),
            'latest_article_informations' => WikiPage::orderBy('id', 'desc')->limit(1)->get(),
            'atom_article_texts' => WikiAtomText::get(),
        ]);
    }

    public function findPage(Request $request) {
        $start = microtime(true);
        $page_title = $request->articleName;
        $wiki_page_information = $this->request_wiki_page($page_title);
        $this->save_aricle_page_information($wiki_page_information, $start);

        // Функция разбивает текст на слова и добавляет в отдельную таблицу
        $this->add_atom_text($wiki_page_information['plain_wiki_text']);

        return redirect('/result');
    }

    public function save_aricle_page_information($wiki_page_information, $start) {
        $execution_time = round(microtime(true) - $start, 2);

        $newWikiPage = new WikiPage;
        $newWikiPage->article_title = $wiki_page_information['article_title'];
        $newWikiPage->article_text = $wiki_page_information['plain_wiki_text'];
        $newWikiPage->article_url = $wiki_page_information['article_url'];
        $newWikiPage->article_size = $wiki_page_information['article_size'];
        $newWikiPage->article_number_of_words = $wiki_page_information['number_of_words'];
        $newWikiPage->article_execution_time = $execution_time;
        $newWikiPage->save();
    }

    public function request_wiki_page($page_title) {
        $searchPage = $page_title;

        $endPoint = "https://ru.wikipedia.org/w/api.php";
        $params = [
            "action" => "query",
            'prop' => 'extracts',
            'origin' => '*',
            'explaintext' => '',
            "format" => "json",
            "exlimit" => "max",
            "utf8" => "1",
            'redirects'=>'true',
            'titles' => $searchPage,
        ];

        $url = $endPoint . "?" . http_build_query( $params );
        $url_for_search = 'https://ru.wikipedia.org/wiki/' . $page_title;
        // проверить доступен ли файл по запрашиваемому адресу
        $get_content = file_get_contents($url);

        $decode = json_decode($get_content, true);

        $plain_wiki_text = ((current($decode['query']['pages'])['extract']));

        $number_of_words = str_word_count(
            $plain_wiki_text,
            0,
            "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя"
        );

        $article_size = ceil(strlen($plain_wiki_text)/1000);

        $wiki_article_information = [
            'plain_wiki_text' => $plain_wiki_text,
            'article_url' => $url_for_search,
            'number_of_words' => $number_of_words,
            'article_size' => $article_size,
            'article_title' => $page_title,
        ];

        return $wiki_article_information;
    }


    public function add_atom_text($plain_wiki_text) {

        $atom_wiki_text = str_word_count(
            $plain_wiki_text,
            1,
            "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя0123456789"
        );

        $atom_wiki_text_words = implode(' ', $atom_wiki_text);

        $atom_wiki_text_words_convert = mb_convert_encoding($atom_wiki_text_words, 'UTF-8', 'UTF-8');

        $newWikiAtomText = new WikiAtomText;
        $newWikiAtomText->article_atom_text = $atom_wiki_text_words_convert;
        $newWikiAtomText->save();
    }

    public function word_search_page() {
        return view('word_search', [
            'article_informations' => WikiPage::get(),
            'latest_article_informations' => WikiPage::orderBy('id', 'desc')->limit(1)->get(),
            'atom_article_texts' => WikiAtomText::get(),
        ]);
    }

    public function word_search_process() {
        redirect('/word_search');
    }
}
