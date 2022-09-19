@extends('layouts.admin')

@section('content')

    <div class="w-full flex flex-row justify-center items-center py-24">
        <div class="w-1/3 bg-gray-50 p-3 rounded space-y-5">
            @foreach($follows as $follow)
                <div class="w-full flex flex-row items-center justify-center space-x-1">
                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1662729718794-6a24869dc921?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
                    <a href="{{route('talk', $follow->name)}}">
                        <span>{{$follow->name}}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
