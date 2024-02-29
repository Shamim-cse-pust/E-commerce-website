@extends('frontend.layouts.master')
@section('frontend-title')
Home Page
@endsection

@section('frontend-content')
@include('frontend.pages.widgets.slider')
@include('frontend.pages.widgets.feature-area')
@include('frontend.pages.widgets.count-down')
@include('frontend.pages.widgets.best-seller')
@include('frontend.pages.widgets.latest-product')
@include('frontend.pages.widgets.testmonial')
@endsection


