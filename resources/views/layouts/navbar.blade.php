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

    <a href="/giftcon" style="color: white">
      <strong>GIFTCON</strong>
    </a>

     <a href="/board/free" style="color: white; margin-left:10px;">
      <strong>자유게시판</strong>
    </a>

    
     <a href="/board/humor" style="color: white; margin-left:10px;">
      <strong>유머게시판</strong>
    </a>

    
     <a href="/board/game" style="color: white; margin-left:10px;">
      <strong>게임게시판</strong>
    </a>

    
 <a href="/board/sport" style="color: white; margin-left:10px;">
      <strong>스포츠게시판</strong>
    </a>

     <a href="/giftcon/mygiftcons" style="color: #FEE715FF; margin-left:10px;">
      <strong>내 기프티콘</strong>
    </a>



    @if(Auth::check())
    <div class="ml-auto">
      <div class="dropdown">
        <button class="btn"> <a href="#"> <strong>{{ Auth::user()->name}}님 안녕하세요!</strong>  </a></button>
        <div class="dropdown-content">
          <a href="/mypage/trades">기프티콘 거래현황</a>
          <a href="/mypage/posts">내 글들</a>
          <a href="#">설정</a>
        </div>
      </div>
  


      <a href="/logout">
        <strong style="color: #FEE715FF; margin-left:30px">LOGOUT</strong>
      </a>

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

@push('style')

<style>
  /* Dropdown Button */
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.btn a{
  color: white;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
    
@endpush