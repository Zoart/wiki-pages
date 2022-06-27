@extends('layouts.app')

<?php $search=0 ?>

@section('title', 'Home')

@section('wiki-tabs')

@endsection

@section('search-result')
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



