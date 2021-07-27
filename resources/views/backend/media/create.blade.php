@extends('backend.layout.index')
@section('title','Thêm file')
@section('content')
<?php $mediaCats = getMediaCats();?>
<div id="create-media" class="page">
	<div class="head">
		<a href="{{route('media')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">Thêm file</h1>		
	</div>
	<div id="dropzone">	
		<div class="row">			
			<div class="col-md-3 sidebar">
				<section id="sb-mediaCat" class="box-wrap">
					<h2 class="title">Danh mục</h2>
					@if(isset($mediaCats))
					<div class="desc list">
						@foreach($mediaCats as $item)
						<div class="checkbox checkbox-success item">
							<input id="item-{{$item->id}}" type="checkbox" name="mediaCats[]" value="{{$item->id}}">
							<label for="item-{{$item->id}}">{{$item->title}}</label>
						</div>
						@endforeach
					</div>
					@endif
				</section>
			</div>
			<div class="col-md-9 content">
				<form action="{{ route('createMedia') }}" class="dropzone" id="frmTarget">
					{!! csrf_field() !!}
					<input type="hidden" name="category" id="category" value="">					
				</form>
				<div class="group-action">
					<button id="submit" type="submit" name="submit" class="btn">Lưu</button>
					<a href="{{route('media')}}" class="btn btn-cancel">Hủy</a>									
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){		
		Dropzone.options.frmTarget = {
		    autoProcessQueue: false,
		    // uploadMultiple: true,
  			parallelUploads: 100,
		    maxFiles:100,
		    url: '{{ route("createMedia") }}',
		    init: function () {
		        var myDropzone = this;
		        // Update selector to match your button
		        $("#dropzone button").click(function (e) {
		            e.preventDefault();
		            var cat_ids = new Array();
		            $("#sb-mediaCat .checkbox").each(function(){
		            	if($(this).find("input").is(":checked")){
		            		cat_ids.push($(this).find("input").val());
		            	}
		            });
		            $("#category").val(cat_ids.toString());		            
		            myDropzone.processQueue();
		        });

		        this.on('sending', function(file, xhr, formData) {		            
		            var data = $('#frmTarget').serializeArray();
		            var category = $("#category").val();
		            formData.append('category', name); console.log(name);
		           $.each(data, function(key, el) {
		                formData.append(el.name, el.value);		                
		            });
		        });
		        this.on("complete", function(file) {
				  myDropzone.removeFile(file); console.log(file);
				});
		    }
		}		
	});
</script>
@stop