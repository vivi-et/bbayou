<div class="navbar navbar-dark bg-dark shadow-sm">
  <div class="container d-flex justify-content-between">
    <a href="/" class="navbar-brand d-flex align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2"
        viewBox="0 0 24 24" focusable="false">
        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
        <circle cx="12" cy="13" r="4" /></svg>
      <strong>BBAYOU</strong>

    </a>

    <a href="/post" style="color: white">
      <strong>POST</strong>
    </a>

    @if(Auth::check())
    <div class="ml-auto">
      <strong style="color: white;">{{ Auth::user()->name}}님 안녕하세요!</strong>
  


      <a href="/logout">
        <strong style="color: #FEE715FF; margin-left:30px">LOGOUT</strong>
      </a>
      {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> --}}
    </div>
    @else
    <div class="ml-auto">
      <a href="/login">
        <strong style="color: white;">LOGIN</strong>
      </a>
      <a href="/register">
        <strong style="color: white;">REGISTER</strong>
      </a>
    </div>
    @endif
  </div>
</div>