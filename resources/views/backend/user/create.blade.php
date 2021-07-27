@extends('backend.layout.index')
@section('title','Thêm thành viên')
@section('content')
<div id="create-user" class="container page route">
	<div class="head">
		<a href="{{route('users')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">Thêm thành viên</h1>		
	</div>	
	<form action="{{route('createAdmin')}}" method="post" name="addUser" class="dev-form edit-post user-form" enctype="multipart/form-data">
		{!!csrf_field()!!}
		<div class="row">
			<div class="col-md-9 content">
				<div class="form-group" id="frm-name">
					<label for="name">Full name<small>(*)</small></label>
					<input type="text" name="name" class="form-control" value="{{old('name')}}"/>
				</div>
				<div class="form-group" id="frm-phone">
					<label for="phone">Phone</label>
					<input type="text" name="phone" class="form-control" value="{{old('phone')}}"/>
				</div>
				<div class="form-group" id="frm-email">
					<label for="email">Email<small>(*)</small></label>
					<input type="email" name="email" class="form-control" value="{{old('email')}}"/>
				</div>				
				<div class="form-group" id="frm-pass">
					<label for="password">Password<small>(*)</small></label>
					<input type="password" name="password" class="form-control" placeholder="***" />
				</div>			
				<div class="form-group" id="frm-conPass">
					<label for="confirmPassword">Confirm Password<small>(*)</small></label>
					<input type="password" name="confirmPassword" class="form-control" placeholder="***" />
				</div>
				<div id="roles-sex" class="row">
					<div class="col-md-6">
						<div class="form-group custom-controls-stacked d-block my-3" id="frm-sex">
							<label for="sex" class="lb-sex">Gender</label>
							<div class="radio radio-success radio-inline">
								<input name="sex" type="radio" id="sex-nam" class="custom-control-input" value="male"/>
								<label for="sex-nam">Male</label>
							</div>
							<div class="radio radio-success radio-inline">
								<input name="sex" type="radio" id="sex-nu" class="custom-control-input" value="female"/>        
								<label for="sex-nu">Female</label>
							</div>
						</div>
					</div>
					<div class="col-md-6" id="frm-roles">
						<label for="role">Role<small>(*)</small></label>
						{!!getRoleHtml()!!}
					</div>
				</div>
			</div>
			<div class="col-md-3 sidebar">
				<section id="sb-image" class="box-wrap">
					<h2 class="title">Avatar</h2>
					<div id="frm-image" class="desc img-upload">
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image('', 150,150, 'avatar')!!}
							<input type="hidden" name="image" class="thumb-media" value="" />
						</div>
					</div>
				</section>
			</div>
		</div>		
		<div class="group-action">			
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
		        text: '{{session("success")}}',
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
		//validate form
		$("#create-user .dev-form").on('click', '.group-action button',function(){
	        var name = $(".dev-form #frm-name input").val();
	        var phone = $(".dev-form #frm-phone input").val();
	        var email = $(".dev-form #frm-email input").val();
	        var pass = $(".dev-form #frm-pass input").val();
	        var conPass = $(".dev-form #frm-conPass input").val();
	        var sex = $(".dev-form #frm-sex input:checked").val();
	        var role = $(".dev-form #frm-roles select").val();
	        var errors = new Array();
	        var error_count = 0;	        
	        if(name==""){
	            errors[0] = "Vui lòng nhập họ & tên.";
	        }else{
	            errors[0] = "";
	        }
	        if(email =="" || validateEmail(email)==false){
	            errors[1] = "Email không đúng định dạng.";
	        }else{
	            errors[1] = "";
	        }
	        if(pass ==""){
	            errors[2] = "Vui lòng nhập mật khẩu.";
	        }else{
	            errors[2] = "";
	        }
	        if(conPass != pass){
	            errors[3] = "Mật khẩu nhập lại không đúng.";
	        }else{
	            errors[3] = "";
	        }
	        if(sex == undefined){
	            errors[4] = "Vui lòng chọn giới tính.";
	        }else{
	            errors[4] = "";
	        }
	        if(role==""){
	            errors[5] = "Vui lòng chọn vai trò.";
	        }else{
	            errors[5] = "";
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