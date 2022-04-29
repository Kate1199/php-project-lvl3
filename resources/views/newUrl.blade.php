@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-lg mt-3">
  <div class="row">
    <div class = "col-12 col-md-10 col-lg-8 mx-auto border rounded-3 bg-light p-5">
      <h2 class="display-3">
        Анализатор страниц
      </h2>
      <p class="lead">Бесплатно проверяйте сайты на SEO-пригодность</p>
      <form method="POST" action="/urls" class="d-flex justify-content-center">
        @csrf
        <input type="text" class="form-control form-control-lg" placeholder="https://www.example.com" id="url" name="url[name]" required>
        <input type="submit" class="btn btn-primary btn-lg ms-3 px-5 text-uppercase mx-3" value="Проверить"></input>
      </form>
    </div>
  </div>
</div>

@endsection

