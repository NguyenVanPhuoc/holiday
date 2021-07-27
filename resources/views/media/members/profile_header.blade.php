<?php 
if(Auth::check()){
    $user = Auth::User();
	$userMeta = getUserMeta($user->id);
	$banner = getMedia($userMeta->banner);
	$banner_url = url('public/uploads').'/'.$banner->image_path;
}?>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
	function ckeditor(name){
        CKEDITOR.replace(name, {
            filebrowserBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html') }}',
            filebrowserImageBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html?type=Images') }}',
            filebrowserFlashBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html?type=Flash') }}',
            filebrowserUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
            filebrowserImageUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
            filebrowserFlashUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
        } );
    }
</script>
<div id="pro-header">
	<div class="pro-avatar"<?php if($banner) echo ' style="background-image:url('.$banner_url.')"';?>>
		<form action="{{ route('libraryProfile')}}" name="media" method="post">
			{!! csrf_field() !!}
			<div class="wrap">
				<div class="left">
					<div class="picture">
						{!!image($user->image,174,174,$user->name)!!}
						<i id="pro-picture" class="fas fa-camera-retro library" data-route="{{route('avatarProfile')}}"></i>
					</div>
					<button id="pro-banner" type="button" class="library" data-route="{{route('bannerProfile')}}"><i class="fas fa-camera-retro"></i>Đổi ảnh nền</button>
					<h2 class="code">HU - {{$user->id}}</h2>
					<p class="email">{{$user->email}}</p>
				</div>
				<div class="right">
					<a href="{{route('storeNews')}}" class="pro-edit"><i class="fas fa-user-edit"></i>Cập nhật</a>
					<a href="{{route('newsProfile')}}" class="pro-news">Tin đăng<i class="fas fa-angle-right"></i></a>
				</div>
			</div>
		</form>
	</div>
	<ul class="pro-menu">
		<li><a href="{{route('newsProfile')}}"{{ Request::is('profile/news') ? ' class=active' : '' }}>Tất cả tin</a></li>
		<li><a href="#">Tin yêu thích</a></li>
	</ul>
</div>
@include('media.library')