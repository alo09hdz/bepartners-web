@extends('layouts.app')

@section('title', 'Nuevo proyecto')
@section('heading', 'Nuevo proyecto')

@section('content')
    <form method="POST" action="{{ route('projects.store') }}" class="mx-auto max-w-4xl">
        @csrf
        @include('projects._form')
    </form>
@endsection