@extends('layout')

@section('content')
    <characters></characters>
    <characters :characters="{{ json_encode($characters) }}"></characters>

@endsection

