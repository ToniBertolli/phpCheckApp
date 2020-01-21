@extends('layouts.main')

@section('content')
    <v-endpoint-errors :logs="{{$logs}}"></v-endpoint-errors>
@endsection
