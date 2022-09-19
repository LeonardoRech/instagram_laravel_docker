@extends('layouts.admin')

@section('content')
    <div class="flex justify-center">
        <div class="w-1/2  border-b border-gray-200">
            <div class="flex w-full">
                <div class="w-1/3 flex py-8 justify-center items-center">
                    <img class="rounded-full w-44 h-44" src="https://images.unsplash.com/photo-1663017909418-6d3d764b8956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
                </div>
                <div class="flex flex-col w-2/3 items-center justify-center space-y-5">
                    <div class="flex items-center w-3/4 justify-between">
                        <span class="text-2xl">{{$user->name}}</span>
                        <a href="{{route('talk', $user->name)}}">
                            <button class=" border-2 border-gray-100 px-4 py-1 rounded">Enviar mensagem</button>
                        </a>
                        @if((!$authfollows))
                            <form action="{{route('follow.store')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$user->id}}" name="to_user_id">
                                <button class="bg-sky-500 text-white px-4 py-1 rounded">Seguir</button>
                            </form>
                        @else
                            <form action="{{route('desfollow')}}" method="POST">
                                @csrf
                                <input type="hidden" name="to_user" value="{{$user->id}}">
                                <button class=" border-2 border-gray-100 px-4 py-1 rounded">Deixar de Seguir</button>
                            </form>
                        @endif
                    </div>
                    <div class="flex flex-row w-3/4 justify-around">
                        <span> 
                            <span class="font-semibold">
                                {{count($posts)}}
                            </span> 
                            publicações
                        </span>
                        <span> 
                            <span class="font-semibold">
                                {{count($tofollows)}}
                            </span> 
                            seguidores
                        </span>
                        <span> 
                            <span class="font-semibold">
                                {{count($follows)}}
                            </span> 
                            seguindo
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-1/2 flex flex-wrap  border-b border-gray-200 py-5 grid grid-cols-3 gap-3">
            @foreach($posts->where('user_id', '=', $user->id) as $post)
                <button class="text-sm text-left" type="button" data-modal-toggle="{{$post->path}}">
                    <img  class="w-full h-72" src="/storage/{{$post->path}}" alt="">
                </button>






                <!-- Default Modal -->
                <div id="{{$post->path}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                    <div class="relative p-10 w-full w-2/3 h-full md:h-auto">
                        <!-- Modal content -->
                        <div class="relative flex flex-row bg-gray-100 rounded-lg shadow">
                            <div class="w-1/2 flex items-center center bg-black">
                                <img class="w-full" src="/storage/{{$post->path}}" alt="">
                            </div>
                            <div class="w-1/2 flex flex-col">
                                <div class="w-full p-3 flex flex-row items-center border-b border-gray-200 mb-5">
                                    <img class="mr-2 w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1662729718794-6a24869dc921?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="user photo">
                                    <span>{{$user->name}}</span>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="{{$post->path}}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        <span class="sr-only">Close modal</span> 
                                    </button>
                                </div>
                                <div class="space-y-5 overflow-y-auto" style="height: 810px">
                                    @foreach($comments->where('post_id', '=', $post->id)  as $comment)
                                        <div class="w-full px-5 flex flex-row">
                                            <img class="mr-2 w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1662729718794-6a24869dc921?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="user photo">
                                            <div class="px-1 w-full text-sm">
                                                <span class="font-semibold">
                                                    @foreach($users as $user)
                                                        @if($comment->user_id == $user->id)
                                                            {{$user->name}}
                                                        @endif
                                                    @endforeach
                                                </span>
                                                <span>{{$comment->comment}}</span>
                                                <div class="flex flex-row space-x-3 text-xs text-gray-500 mt-3 font-semibold">
                                                    <span>{{$post->created_at}}</span>
                                                    <span>{{count($likecomments->where('comment_id', '=', $comment->id))}} curtidas</span>
                                                </div>
                                            </div>
                                            @if(count($likecomments->where('comment_id', '=', $comment->id)))
                                                @foreach($likecomments->where('comment_id', '=', $comment->id) as $likecomment)
                                                    <form action="{{route('deslikecomment')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="likecomment_id" value="{{$likecomment->id}}">
                                                        <button type="submit">
                                                            <i class="lar la-heart text-2xl bg-red-500 text-white rounded-full"></i>
                                                        </button>
                                                    </form>
                                                @endforeach
                                            @else
                                                <form action="{{route('likecomment.store')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                    <button type="submit">
                                                        <i class="lar la-heart text-2xl"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <form action="{{route('comment.store')}}" method="POST" class="h-12 w-full flex flex-row items-center py-2 px-4">
                                    @csrf
                                    <input type="hidden" value="{{$post->id}}" name="post_id">
                                    <input name="comment" type="text" placeholder="Comente" class="h-8 w-full rounded border border-sky-500">
                                    <button type="submit" class="p-2 text-white"><i class="lar la-paper-plane w-8 text-lg rounded-full bg-sky-500"></i></button type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
       </div>
    </div>











    @endsection
