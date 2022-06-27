<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Models\WikiPage;
use App\Models\WikiAtomText;
use App\Models\LinkTable;
use Illuminate\Support\Facades\DB;

class WordSearchController extends Controller
{

    public function get_word_search_page() {


        return view('word_search', [
            'article_informations' => WikiPage::get(),
            'latest_article_informations' => WikiPage::orderBy('id', 'desc')->limit(1)->get(),
            'atom_article_texts' => WikiAtomText::get(),
            'link_tables' => LinkTable::get(),
            'NumberOfOccurrences' => LinkTable::sum('NumberOfOccurrences'),
            'CountArticle' => LinkTable::count('NumberOfOccurrences'),
        ]);
    }

    public function word_search_process(Request $request) {

        $this->find_matches($request->WordForSearch);

        return redirect('/word_search');
    }

    public function find_matches($word){
        LinkTable::whereNotNull('Article_ID')->delete();
        $db_information = WikiAtomText::get();
        foreach ($db_information as $object) {
            $id_article = $object->wiki_page_id;
            $word_id = $word;
            $word_matches = substr_count($object->article_atom_text, $word);
            if ($word_matches > 0) {
                $this->save_in_link_table($id_article, $word_id, $word_matches);
            }
        };
    }

    public function save_in_link_table($id_article, $word_id, $word_matches) {
        $newLinkTable = new LinkTable;
        $newLinkTable->Word_ID = $word_id;
        $newLinkTable->Article_ID = $id_article;
        $newLinkTable->NumberOfOccurrences = $word_matches;
        $newLinkTable->save();
    }
}
