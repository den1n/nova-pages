@extends('layouts.app')

@section('meta-keywords', implode(',', $page->keywords))
@section('meta-description', $page->description)
@section('title', $page->title)

@section('content')
    <div class="col-md-12">
        <div class="card pages-card">
            <div class="card-header">{{ $page->title }}</div>
            <div class="card-body">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection
