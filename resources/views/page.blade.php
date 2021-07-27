@extends('templates.master')
@section('title', $page->title)
@if($seo)
@section('description', $seo->value)
@section('keywords', $seo->key)
@endif
@section('content')
<div class="container page">
	{{ Breadcrumbs::render('page', $page) }}
    <h2 class="title">{{$page->title}}</h2>
    <div class="main">{!! $page->content !!}</div>
</div>
@stop