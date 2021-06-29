<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/userpage.css') }}" >
    <title>TOMOON</title>
</head>
<body>
<!-- NAVBAR -->
<section class="navbar">
<ul>
  <li><a href="/">TOMOON</a></li>
  <li>
  <form id="search_form" autocomplete="off"  method="GET" action="{{action([App\Http\Controllers\PostController::class, 'search']) }}">
      @csrf
      <input type="text" name="search" id="search" placeholder="{{ __('messages.Search') }}">
    </form>
  </li>
  @guest
  <li><a href="{{ route('register') }}">{{ __('messages.REGISTER') }}</a></li>
  <li><a href="{{ route('login') }}">{{ __('messages.LOGIN') }}</a></li>
  @endguest
  @auth
  <li><a href="/dashboard">{{ __('messages.Dashboard') }}</a></li>
  <li><a href="/messages">{{ __('messages.Messages') }}</a></li>
  @endauth
</ul>
</section>

@if (count($errors) > 0)
<div>
<ul>
@foreach ($errors->all() as $error)
<li id="error">{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<div class="posts">
  @if (count($userPosts)==0)
    <p id="error1"> {{ __('messages.Nothing found here') }}</p>
  @else
    <table style="border: none; table-layout: fixed;width: 30%; border-collapse: separate;border-spacing: 0 25px;">
  <h2>{{ __('messages.Viewing profile of') }} {{ $user->name }}</h2>
  @if(Auth::user())
    @if (Auth::user()->id != $user->id)
    <h4 onclick="sendMessage( {{$user->id}} )">{{ __('messages.SEND A MESSAGE') }}</h4>
    @endif
  @endif
  @foreach ($userPosts as $post)
      <tr>
        <td onclick="showPost( {{ $post->id }})"> {{ $post->text }}</td>
      </tr>
  @endforeach
  </table>
  @endif
</div>
<script>
    function showPost(postID) {
        window.location.href="/post/"+postID;
    }
    function sendMessage(userID) {
        window.location.href="/message/new/"+userID;
    }
</script>
</body>
</html>