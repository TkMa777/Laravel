@extends('layout')

@section('content')
    <characters :characters="{{ json_encode($characters) }}"></characters>
@endsection

