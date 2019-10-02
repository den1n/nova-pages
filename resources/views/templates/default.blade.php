@extends('layouts.app')

@section('meta-keywords', implode(',', $page->keywords))
@section('meta-description', $page->description)
@section('title', $page->title)

@section('content')
    <link rel="stylesheet" href="{{ mix('index.css', 'vendor/nova-pages') }}">
    <div class="col-md-12">
        <div class="card pages-card">
            <div class="card-header">{{ $page->title }}</div>
            <div class="card-body">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection
