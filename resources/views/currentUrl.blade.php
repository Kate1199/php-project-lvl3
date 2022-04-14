<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анализатор страниц</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
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
                <th>{{ $urlCheck->h1 }}</th>
                <th>{{ $urlCheck->title }}</th>
                <th>{{ $urlCheck->description }}</th>
                <th>{{ $urlCheck->created_at }}</th>
            </tr>
            @endforeach
        </tbody>
        </table>

    </div>
    
</body>
</html>
