<!DOCTYPE html>
<html lang="en">

@extends('layouts.app')

@section('content')
@include('flash::message')

    <div class=" container container-lg">
        <h1 class="mt-5 mb-3">Сайт: {{ $url->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{ $url->id }}</td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td>{{ $url->name }}</td>
                    </tr>
                    <tr>
                        <td>Дата создания</td>
                        <td>{{ $url->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="/urls" class="btn btn-primary">Show All</a>

        <h2 class="mt-5 mb-3">Проверки</h2>
        <form method="post" action="/urls/{{ $url->id }}/checks">
            @csrf
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>

        <table class="table table-bordered table-hover text-nowrap">
        <thead>
            <tr>
                <th>ID</th>
                <th>Код ответа</th>
                <th>h1</th>
                <th>title</th>
                <th>description</th>
                <th>Дата создания</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($urlChecks  as $urlCheck)
            <tr>
                <th>{{ $urlCheck->id }}</th>
                <th>{{ $urlCheck->status_code }}</th>
                <th>{{ Str::limit($urlCheck->h1, 50) }}</th>
                <th>{{ Str::limit($urlCheck->title, 50) }}</th>
                <th>{{ Str::limit($urlCheck->description, 50) }}</th>
                <th>{{ $urlCheck->created_at }}</th>
            </tr>
            @endforeach
        </tbody>
        </table>

    </div>
@endsection
</html>
