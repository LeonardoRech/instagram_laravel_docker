@extends('layouts.admin')

@section('content')

    <div class="w-full h-full flex flex-row justify-center items-center py-24">
        <div class="w-1/3 h-5/6 bg-gray-100 p-3 rounded space-y-5">
            <div class="w-full h-14 flex flex-row space-x-2 justify-center items-center">
                <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1662729718794-6a24869dc921?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
                <a href="{{route('profile', $user->name)}}">
                    <span>{{$user->name}}</span>
                </a>
            </div>
            <div class="w-full h-96 bg-white pt-5 pb-1 px-2 space-y-3 overflow-y-auto">
                @foreach($messages as $message)
                    @if($message->user_id == auth()->user()->id && $message->to_user_id == $user->id)
                        <div class="w-full flex justify-end pl-20">
                            <span class="p-2 bg-blue-100 rounded">{{$message->message}}</span>
                        </div>
                    @elseif($message->user_id == $user->id && $message->to_user_id == auth()->user()->id)
                        <div class="w-full flex justify-start pr-20">
                            <span class="p-2 bg-red-100 rounded">{{$message->message}}</span>
                        </div>
                    @endif
                @endforeach
            </div>
            <form method="POST" action="{{route('message.store')}}" class="w-full flex flex-row space-x-2 items-center">
                @csrf
                <input type="hidden" name="to_user_id" value="{{$user->id}}">
                <input name="comment" type="text" placeholder="Envie uma mensagem" class="h-8 w-full rounded border border-sky-500">
                <button type="submit" class="p-2 text-white">
                    <i class="lar la-paper-plane w-8 text-lg rounded-full bg-sky-500"></i>
                </button type="submit">
            </form>
        </div>
    </div>

@endsection
