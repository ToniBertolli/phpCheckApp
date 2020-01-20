@extends('layouts.app')

@section('content')
    <div class="container">
        <v-main-endpoint :endpoint="{{$endpoint}}"></v-main-endpoint>
    </div>
@endsection
