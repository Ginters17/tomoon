<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show_message.css') }}" >
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
  <li><a href="{{ route('login') }}">{{ __('messages.LOGIN') }}</a></li>
  @endguest
  @auth
  <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
  <li><a href="/messages">{{ __('messages.Messages') }}</a></li>
  @endauth
</ul>
</section>


<h1>{{ __('messages.Message from') }} {{$sender->name}}</h1>
<div class="message">
  <div id="subject_line">
    <p>{{$message->subject}}</p>
  </div>
  <div id="message_text">
    <p>{{$message->text}}</p>
    <p>{{$message->created_at}}</p>
  </div>
</div>

</body>
</html>