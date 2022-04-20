<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>
