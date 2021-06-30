<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post.css') }}" >
    <title>Post</title>
</head>
<body>
    <!-- Nav Bar -->
    <section class="navbar">
    <ul>
        <li><a href="/">TOMOON</a></li>
        <li>
            <form id="search_form" autocomplete="off"  method="POST" action="{{action([App\Http\Controllers\WelcomeController::class, 'store']) }}">
                @csrf
                <input type="text" name="text" id="search" placeholder="{{ __('messages.Search') }}">
            </form>
        </li>
        @guest
        <li><a href="{{ route('register') }}">{{ __('messages.REGISTER') }}</a></li>
        <li><a href="{{ route('login') }}">{{ __('messages.LOGIN') }}</a></li>
        @endguest
        @auth
        <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
        <li><a href="/messages">{{ __('messages.Messages') }}</a></li>
        @endauth
    </ul>
    </section>
    <!-- Post -->
    <section id="post">
        <div class="post">
            <table style="margin-top:100px;width:100%;">
                <tr>
                    <div class="post_info">
                        <td>
                            <p id="user" onclick="showUser( {{ $post->user_id }} )"> {{$post->user->name}} </p>
                            {{ $post->text }}<br>
                            <span id="dateAndTime">{{$post->created_at}}</span><br>
                            <p id="post_views"> {{$post->views}} {{__('messages.Views')}} </p> 
                        </td>
                    </div>
                </tr>
            </table>
            @can('destroy', $post)
            <div class="buttons">
                <button onclick="showEdit()" id="edit_button">{{ __('messages.EDIT') }}</button>
                <form style="display: inline-block;" method="POST" action="{{ action([App\Http\Controllers\PostController::class, 'destroy'], $post->id) }}">
                    @csrf 
                    @method('DELETE')
                    <input type="submit" value="{{ __('messages.DELETE') }}">
                </form>
            </div>
            @endcan
        </div>
    </section>

    <div id="edit_form">
        <form  method="POST" action="{{ action([App\Http\Controllers\PostController::class, 'update'], $post->id) }}">
            @csrf 
            @method('PUT')
            <input type="text" name="text" id="edit_form_input" value="{{$post->text}}"><br>
            <button onclick="cancelEdit()" id="edit_button">{{ __('messages.CANCEL') }}</button>
            <input type="submit" id="save" value="{{ __('messages.SAVE') }}">
        </form>
    </div>

    <!-- Comments -->
    <section id="comments">
    <div class="comments">
        <p>{{__('messages.Comments')}}:</p>
        @if (count($post->comment)==0)
            <p id="error1"> {{ __('messages.No comments found. Be first!') }}</p>
        @endif
        <form id="form1" autocomplete="off"  method="POST" action="{{action([App\Http\Controllers\PostController::class, 'store']) }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="text" name="text" id="text" placeholder="{{ __('messages.Write Something') }}">
        </form>
        @if (count($errors) > 0)
        <div>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <table style="border: none; table-layout: fixed;width: 100%; border-collapse: separate;border-spacing: 0 25px;">
            @foreach ($post->comment as $comment)
                <tr>
                    <td> <p id="user" onclick="showUser( {{ $comment->user->id }} )">{{$comment->user->name}}</p> {{ $comment->text }} <p id="dateAndTime">{{$comment->created_at}} </p>
                    <br><br>
                    @can('destroy', $comment)
                        <form style="display: inline-block;" method="POST" action="{{ action([App\Http\Controllers\PostController::class, 'destroyComment'], $comment->id) }}">
                            @csrf 
                            @method('DELETE')
                            <input type="submit" id="comment_edit_button" value="{{ __('messages.DELETE') }}">
                        </form>
                        <button onclick="showCommentEdit()" id="comment_edit_button">{{ __('messages.EDIT') }}</button>

                        <div id="comment_edit_form">
                            <form  method="POST" id="comment_edit_form2" action="{{ action([App\Http\Controllers\PostController::class, 'updateComment'], $comment->id) }}">
                                @csrf 
                                @method('PUT')
                                <input type="text" name="text" id="comment_edit_form_input" value="{{$comment->text}}">
                                <button onclick="cancelCommentEdit()" id="comment_edit_button">{{ __('messages.CANCEL') }}</button>
                                <input type="submit" id="save" value="{{ __('messages.SAVE') }}">
                        </form>
                    @endcan    
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    </section>

    <script>
        function showEdit() {
            document.getElementById("edit_form").style.display = "block";
        }
        function showCommentEdit() {
            document.getElementById("comment_edit_form").style.display = "block";
        }
        function cancelEdit() {
            document.getElementById("edit_form").style.display = "none";
        }
        function cancelCommentEdit() {
            document.getElementById("comment_edit_form").style.display = "none";
        }
        function showUser(userID) {
            window.location.href="/user/"+userID;
        }
    </script>
</body>
</html>