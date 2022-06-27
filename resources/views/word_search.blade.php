@extends('layouts.app')

@section('title', 'Home')

@section('search-result')

<?php $search=1 ?>
<div class="search-result">
    <p class="search-result__title">Импорт завершен.</p>
    <p class="search-result__text">Найдена статья по адресу:
        @foreach ($latest_article_informations as $information)
            {{$information->article_url}}
        @endforeach
    </p>
    <p class="search-result__text">Время обработки:
        @foreach ($latest_article_informations as $information)
            {{$information->article_execution_time}} сек.
        @endforeach
    </p>
    <p class="search-result__text">Размер статьи:
        @foreach ($latest_article_informations as $information)
            {{$information->article_size}} Kb.
        @endforeach
    </p>
    <p class="search-result__text">Кол-во слов:
        @foreach ($latest_article_informations as $information)
            {{$information->article_number_of_words}}
        @endforeach
    </p>
</div>
@endsection

@section('content')
<table class="table table-success table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th scope='col'>Название статьи</th>
            <th scope='col'>Ссылка</th>
            <th scope='col'>Размер статьи</th>
            <th scope='col'>Кол-во слов</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($article_informations as $information)
        <tr>
            <td>{{$information->article_title}}</td>
            <td>{{$information->article_url}}</td>
            <td>{{$information->article_size}}</td>
            <td>{{$information->article_number_of_words}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('atom_word_search_result')
<div class="atom_word_search_result">
    <div class="atom_word_search_result__matches">
        <p>
            Найдено {{ $NumberOfOccurrences }} совпадений(я)
            в {{ $CountArticle }} статьях(е).
        </p>

        <?php
            foreach ($link_tables as $row) {
                $row_id = $row->Article_ID;
                $matches = $row->NumberOfOccurrences;
                foreach ($article_informations as $text_source) {
                    if ($row_id == $text_source->id) {
                        echo '<p class="atom_word_search_result__matches_link" href="">' .
                        $text_source->article_title .
                        '(вхождений: ' . $matches . ')'.
                        '</p>' . '</br>';
                    }
                }
            }
            ?>

        <div>
        </div>
    </div>
    <div class="atom_word_search_result__articles">
        <p class="article">
        <?php
            foreach ($link_tables as $row) {
                $row_id = $row->Article_ID;
                foreach ($article_informations as $text_source) {
                    if ($row_id == $text_source->id) {
                        echo '<p class="article__text">' .
                        $text_source->article_text .
                        '</p>';
                    }
                }
            }
            ?>
        </p>
    </div>
</div>
@endsection

