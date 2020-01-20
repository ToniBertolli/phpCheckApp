@extends('layouts.main')

@section('content')
    <v-endpoints :instance="{{$instance}}"></v-endpoints>
@endsection
