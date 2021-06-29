<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/welcome.css') }}" >
    <title>TOMOON</title>
</head>
<body>
<!-- NAVBAR -->
<section class="navbar">
<ul>
  <li><a href="/">TOMOON {{ 384400 - count($posts)}}</a></li>
  <li>
    <form id="search_form" autocomplete="off"  method="GET" action="{{action([App\Http\Controllers\PostController::class, 'search']) }}">
      @csrf
      <input type="text" name="search" id="search" placeholder=" {{ __('messages.Search') }} ">
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
  <li><a href="/lang/lv">LV</a></li>
  <li><a href="/lang/en">EN</a></li>
</ul>
</section>

<form id="form1" autocomplete="off"  method="POST" action="{{action([App\Http\Controllers\WelcomeController::class, 'store']) }}">
 @csrf
<input type="text" name="text" id="text" placeholder="{{ __('messages.Write Something') }}">
</form>
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
  @if (count($posts)==0)
    <p id="error1"> {{ __('messages.Nothing found here') }}</p>
  @else
    <table style="border: none; table-layout: fixed;width: 30%; border-collapse: separate;border-spacing: 0 25px;">
  @foreach ($posts as $post)
      <tr>
        <td onclick="showPost( {{ $post->id }})"> {{ $post->text }}</td>
      </tr>
  @endforeach
  </table>
  @endif
</div>

<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

<script>
    function showPost(postID) {
        window.location.href="/post/"+postID;
    }
</script>
<script type="text/javascript" src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>