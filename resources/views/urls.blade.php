<!DOCTYPE html>
<html lang="en">
@extends('layouts.app')

@section('content')
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

      {{ $urls->links() }}

      </nav>
    </div>
  </div>
@endsection

</html>
