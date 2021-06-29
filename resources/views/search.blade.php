<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}" >
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
  <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
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
  @if (count($posts)==0)
    <div style="margin-top:200px;">
    <h1> {{__('messages.Nothing found here')}}</h1>
    <p id="error1"> {{__('messages.We found nothing when looking for your query. Try again!')}}</p>
    </div>
  @else
  <h1>{{__('messages.Your search results:')}} </h1>
    <table style="border: none; table-layout: fixed;width: 30%; border-collapse: separate;border-spacing: 0 25px;">
  @foreach ($posts as $post)
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
</script>
</body>
</html>