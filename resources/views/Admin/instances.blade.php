@extends('layouts.app')

@section('content')
    <div class="container">
        <v-main-instances :user="{{ Auth::user()}}"></v-main-instances>
    </div>
@endsection
