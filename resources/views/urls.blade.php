<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анализатор страниц</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container-lg">
    <h1 class="mt-5 mb-3">Сайты</h1>
    <div class="table-responsive">
      <table class="table table-bordered table-hover text-nowrap">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Последняя проверка</th>
            <th scope="col">Код ответа</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($urls as $url)
            <tr>
              <th scope="row">{{ $url->id }}</th>
              <td scope="row">
                <a href="/urls/{{ $url->id }}"> {{ $url->name }} </a>
              </td>
              <td scope="row">{{ $url->last_check_created_at }}</td>
              <td scope="row">{{ $url->status_code }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <a href="/" class="btn btn-primary">New</a>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
