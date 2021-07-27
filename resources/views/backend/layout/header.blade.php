<?php
use Illuminate\Support\Facades\Auth;
use App\User;?>
@if(Auth::check())
<?php $user = Auth::User();?>
<ul class="navbar-right">
    <!-- <li><a href="#"><i class="fa fa-bell"></i><span class="label label-warning">16</span></a></li> -->
     @handheld<li class="mobi-nav-icon"><i class="fa fa-navicon" aria-hidden="true"></i></li> @endhandheld
    <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
</ul>
<p class="welcome">Xin chào <a href="#">{{$user->name}}</a></p>
@endif