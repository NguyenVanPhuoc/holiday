<aside class="pro-asMenu">
	<div class="desc">
		<ul class="action">
			<li><a href="{{route('newsProfile')}}"{{ Request::is('profile/news') ? ' class=active' : '' }}><i class="far fa-newspaper"></i>Tất cả tin</a></li>
		    <li><a href="{{route('createNewsProfile')}}"{{ Request::is('profile/news/create') ? ' class=active' : '' }}><i class="fas fa-plus-circle"></i>Đăng tin</a></li>
		    <li><a href="{{route('mediaProfile')}}"{{ Request::is('profile/media','profile/media/*') ? ' class=active' : '' }}><i class="fas fa-images"></i>Thư viện</a></li>    
		    <li><a href="{{route('editProfile')}}"{{ Request::is('profile/edit') ? ' class=active' : '' }}><i class="fas fa-user-edit"></i>Cập nhật</a></li>
		    <li><a href="{{route('editPassword')}}"{{ Request::is('profile/password') ? ' class=active' : '' }}><i class="fas fa-key"></i>Mật khẩu</a></li>
		    <li><a href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i>Thoát</a></li>
		</ul>
	</div>
</aside>