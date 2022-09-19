@extends('layouts.admin')

@section('content')
    <div class="py-10 flex flex-col items-center space-y-5">
        <div>
            <button class="text-sm border border-gray-200 text-gray-500 px-3 py-2 rounded" type="button" data-modal-toggle="post-modal">
                <i class="las la-plus"></i> Novo Post
            </button>
        </div>
        <div class="h-24 w-1/3 rounded border border-gray-200 flex flex-row justify-around">
            @foreach ($users as $user)
                <a class="flex flex-col justify-center items-center" href="{{route('profile', $user->name)}}">
                    <img class="w-14 h-14 rounded-full" src="https://images.unsplash.com/photo-1662729718794-6a24869dc921?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
                    <span>{{$user->name}}</span>
                </a>
            @endforeach
        </div>
        @foreach($posts as $post)
            <div class="rounded overflow-hidden shadow-lg w-full md:w-1/3 border-2 border-gray-200">
                <div class="px-2 h-10 flex flex-row space-y-2 items-center">
                    <img class="mr-2 w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1662729718794-6a24869dc921?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="user photo">
                    <a href="{{route('profile', $post->name)}}">{{$post->name}}</a>
                </div>
                <img class="w-full mt-1" src="/storage/{{$post->path}}" alt="Sunset in the mountains">
                <div class="px-6 pt-4 pb-3 flex flex-row space-x-3">
                    @if(count($likes->where('post_id', '=', $post->id)) > 0)
                        @foreach($likes->where('post_id', '=', $post->id) as $like)
                            @if($like->post_id == $post->id && auth()->user()->id == $like->user_id)
                                <form action="{{route('deslike')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <button type="submit">
                                        <i class="lar la-heart text-2xl text-white bg-red-500 rounded-full"></i>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    @else
                        <form action="{{route('like.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <button type="submit">
                                <i class="lar la-heart text-2xl"></i>
                            </button>
                        </form>
                    @endif
                    <div>
                        <button class="text-sm text-left" type="button" data-modal-toggle="{{$post->path}}">
                            <i class="lar la-comment-alt text-2xl"></i>
                        </button>
                    </div>
                </div>
                <div class="px-6 pb-3 text-sm">
                    <span class="font-semibold mr-1">{{$post->name}}</span>
                    <span>{{$post->comment}}</span>
                </div>
                <div class="px-6 pb-3 flex flex-col text-gray-500 space-y-1">
                    <button class="text-sm text-left" type="button" data-modal-toggle="{{$post->path}}">
                        Ver 
                        {{count($comments->where('post_id', '=', $post->id));}}
                        Comentários
                    </button>
                    <span class="text-xs">{{$post->created_at}}</span>
                </div>
            </div>






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
                                <span>{{$post->name}}</span>
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




<!-- Default Modal -->
<div id="post-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative w-full w-1/3 h-full md:h-auto">
        <!-- Modal content -->
        <form action="{{route('post.store')}}" enctype="multipart/form-data" class="relative flex flex-col bg-gray-100 rounded-lg shadow space-y-5  p-10" method="POST">
            @csrf
            <span class="text-center">Novo Post</span>
            <input type="file" name="image" multiple>
            <input name="comment" type="text" placeholder="Comentário">
            <button type="submit" class="px-3 py-1 rounded text-sky-500 border border-sky-500">Postar</button>
        </form>
    </div>
</div>
@endsection
