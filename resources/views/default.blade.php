@extends('layouts.app')

@section('keywords')
    {{ $page->keywords }}
@endsection

@section('description')
    {{ $page->description }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ $page->title }}</div>
        <div class="card-body">
            {!! $page->content !!}
        </div>
    </div>
@endsection
