@extends('backend.layout.index')
@section('title','Sửa thành viên')
@section('content')

<div id="edit-user" class="container page route">
	<div class="head">
		<a href="{{route('users')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">{{$user->name}}</h1>		
	</div>	
	<form id="{{ $user->id }}" action="{{route('updateAdmin',['id'=>$user->id])}}" method="post" name="addUser" class="dev-form edit-post user-form" enctype="multipart/form-data">
		{!!csrf_field()!!}
		<div class="row">
			<div class="col-md-9 content">
				<div class="form-group" id="frm-name">
					<label for="name">Full name<small>(*)</small></label>
					<input type="text" name="name" class="form-control" value="{{ $user->name }}"/>
				</div>
				<div class="form-group" id="frm-phone">
					<label for="phone">Phone</label>
					<input type="text" name="phone" class="form-control" value="{{ $user->phone }}"/>
				</div>
				<div class="form-group" id="frm-email">
					<label for="email">Email<small>(*)</small></label>
					<input type="email" name="email" class="form-control" value="{{ $user->email }}"readonly/>
				</div>
				<div id="roles-sex" class="row">
					<div class="col-md-6">
						<div class="form-group custom-controls-stacked d-block my-3" id="frm-sex">
							<label for="sex" class="lb-sex">Gender</label>
							<div class="radio radio-success radio-inline">
								<input name="sex" type="radio" id="sex-nam" class="custom-control-input" value="male" @if($user->sex == 'male') checked @endif/>
								<label for="sex-nam">Male</label>
							</div>
							<div class="radio radio-success radio-inline">
								<input name="sex" type="radio" id="sex-nu" class="custom-control-input" value="female" @if($user->sex == 'female') checked @endif />        
								<label for="sex-nu">Female</label>
							</div>
						</div>
					</div>
					<div class="col-md-6" id="frm-roles">
						<label for="role">Role<small>(*)</small></label>
						{!!getRoleHtml($user->level)!!}
					</div>
				</div>	
				<div class="checkbox checkbox-success check-password">
					<input id="change-password" type="checkbox" name="changePassword">
					<label for="change-password">Change password</label>
				</div>
				<div class="change-password">
					<div class="form-group" id="password">
						<label for="password">Password<small>(*)</small></label>
						<input type="password" name="password" class="form-control" value="" disabled placeholder="***" />
					</div>			
					<div class="form-group" id="confirmPassword">
						<label for="confirmPassword">Confirm Password<small>(*)</small></label>
						<input type="password" name="confirmPassword" class="form-control" value="" disabled placeholder="***" />
					</div>
				</div>
			</div>
			<div class="col-md-3 sidebar">
				<section id="sb-image" class="box-wrap">
					<h2 class="title">Avatar</h2>
					<div id="frm-image" class="desc img-upload">
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image($user->image, 150,150, $user->name)!!}
							<input type="hidden" name="image" class="thumb-media" value="{{ $user->image}}" />
						</div>
					</div>
				</section>
			</div>
		</div>		
		<div class="group-action">
			<a href="{{route('deleteAdmin',['id'=>$user->id])}}" class="btn btn-delete">Delete</a>
			<button type="submit" name="submit" class="btn">Save</button>
			<a href="{{route('users')}}" class="btn btn-cancel">Back</a>
		</div>
	</form>
</div>
@include('backend.media.library')
@if(session('success'))
	<script type="text/javascript">
		$(document ).ready(function(){
			new PNotify({
		        title: 'Thành công',
		        text: 'Cập nhật thành công.',
		        type: 'success',
		        hide: true,
		        delay: 2000,
		    });
		})
	</script>
@endif
@if(count($errors)>0)
	<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul></div>
	<script type="text/javascript">
		$(document ).ready(function(){
			new PNotify({
		        title: 'Lỗi',
		        text: $('.alert-danger').html(),
		        type: 'error',
		        hide: true,
		        delay: 2000,
		    });
		})
	</script>
@endif
<script type="text/javascript">
	$(document).ready(function(){
		//change password
		$(".check-password input").change(function(){
			if($(this).is(':checked')){
				$(".change-password input").prop('disabled', false);
				$(this).val("on");			
			}else{
				$(".change-password input").prop('disabled', true);
				$(this).val("");				
			}
			$(".change-password").slideToggle(100);
		});
		//validate form
		$("#edit-user .dev-form").on('click', '.group-action button',function(){
	        var name = $(".dev-form #frm-name input").val();	        
	        var sex = $(".dev-form #frm-sex input:checked").val();
	        var role = $(".dev-form #frm-roles select").val();
	        var errors = new Array();
	        var error_count = 0;	        
	        if(name==""){
	            errors[0] = "Vui lòng nhập họ & tên.";
	        }else{
	            errors[0] = "";
	        }
	        if(sex == undefined){
	            errors[1] = "Vui lòng chọn giới tính.";
	        }else{
	            errors[1] = "";
	        }
	        if(role==""){
	            errors[2] = "Vui lòng chọn vai trò.";
	        }else{
	            errors[2] = "";
	        }
	        var i;
	        var html = "<ul>";
	        for(i = 0; i < errors.length; i++){
	            if(errors[i] != ""){
	                html +='<li>'+errors[i]+'</li>';
	                error_count += 1;
	            }
	        }
	        html += "</ul>";
	        if(error_count>0){
	            new PNotify({
	                title: 'Lỗi dữ liệu ('+error_count+')',
	                text: html,                         
	                hide: true,
	                delay: 6000,
	            });
	        }else{          
	            $(".dev-form").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>')
	            return true;
	        }
	        return false;
	    });
		$("#edit-user .btn-delete").click(function(){
			var href = $(this).attr("href");
			(new PNotify({
				title: 'Xóa',
				text: 'Bạn muốn xóa thành viên này?',
				icon: 'glyphicon glyphicon-question-sign',
				type: 'error',
				hide: false,
				confirm: {
					confirm: true
				},
				buttons: {
					closer: false,
					sticker: false
				},
				history: {
					history: false
				}
			})).get().on('pnotify.confirm', function() {			    
				window.location.href = href;
			});
			return false;
		});
	})
</script>
@stop