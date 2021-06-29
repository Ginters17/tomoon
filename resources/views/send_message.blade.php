<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/send_message.css') }}" >
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

<section id="send_message">
    <h2>{{ __('messages.Send Message To') }} {{$user->name}}</h2>
    <div if="message">
    <form id="form1" autocomplete="off"  method="POST" action="{{action([App\Http\Controllers\MessageController::class, 'store']) }}">
      @csrf
      <input type="hidden" name="receiver_id" id="receiver_id" value=" {{ $user->id }} ">
      <input type="text" name="subject" id="subject" placeholder="{{ __('messages.Subject Line') }}"><br>
      <input type="text" name="text" id="text" placeholder="{{ __('messages.Write a message') }}"><br>
      @foreach ($errors->all() as $error)
      <p id="error">{{ $error }}</p>
      @endforeach
      <input type="submit" id="btn-send" value="{{ __('messages.SEND') }}">
    </form>
    </div>
</section>

<script>
</script>
</body>
</html>