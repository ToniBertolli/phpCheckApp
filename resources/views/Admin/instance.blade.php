@extends('layouts.app')

@section('content')
    <div class="container">
        <v-main-instance :user="{{ Auth::user()}}" :instance="{{$instance}}"></v-main-instance>
    </div>
@endsection
