<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/messages.css') }}" >
    <title>TOMOON</title>
</head>
<body>
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

<section id="User Information Section">
    <div if="user_info">
        
    </div>
</section>
<div class="messages">
    @if (count($messages)==0)
      <h2> {{ __('messages.No Messages Found') }}</h2>
    @else
    <h2> {{ __('messages.Your messages') }}</h2>
      <table style="border: none; table-layout: fixed;width: 30%; border-collapse: separate;border-spacing: 0 25px;">
    @foreach ($messages as $message)
        <tr>
          <td onclick="showMessage( {{ $message->id }} )"> {{ $message->subject }}</td>
        </tr>
    @endforeach
    </table>
    @endif
</div>
<script>
function showMessage(userID) {
        window.location.href="/message/"+userID;
    }
</script>
</body>
</html>