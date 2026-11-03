@extends('layouts.app')

@section('title', 'Editar proyecto')
@section('heading', 'Editar proyecto')

@section('content')
    <form method="POST" action="{{ route('projects.update', $project) }}" class="mx-auto max-w-4xl">
        @csrf
        @method('PUT')
        @include('projects._form')
    </form>
@endsection