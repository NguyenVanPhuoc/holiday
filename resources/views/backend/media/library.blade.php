<?php $mediaCats = getMediaCats();?>
<div id="library-op" class="modal single" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Mời chọn file</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation"><a href="#addFile" aria-controls="addFile" role="tab" data-toggle="tab">Thêm tập tin</a></li>
					<li role="presentation" class="active"><a href="#media" aria-controls="media" role="tab" data-toggle="tab">Thư viện</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane" id="addFile">
						<div id="dropzone">	
							<div class="row">			
								<div class="col-md-3 sidebar">
									<div id="sb-mediaCat" class="box-wrap">
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
									</div>
								</div>
								<div class="col-md-9 content">
									<form action="{{ route('createMedia') }}" class="dropzone" id="frmTarget">
										{!! csrf_field() !!}
										<input type="hidden" name="category" id="category" value="">
									</form>
									<div class="group-action">
										<button type="submit" name="submit" class="btn">Lưu</button>
										<button type="button" class="btn btn-cancel" data-dismiss="modal">Đóng</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane active" id="media">
						<form action="{{ route('deleteMediaSingle')}}" name="media" method="post">
							{!! csrf_field() !!}
							<input type="hidden" name="loadMoreMedia" class="more-media" value="{{route('loadMorePage')}}">
							<input type="hidden" name="array_chose" value="" />
							<div class="row">
								<div class="col-md-10">
									<div class="row top">
										<div id="media-cat" class="col-md-2 dropdown show">
											<a class="dropdown-toggle" href="#" role="button" id="dropMediaCat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-value="">Tất cả</a>
											<div class="dropdown-menu" aria-labelledby="dropMediaCat">
												<div class="search-input">
													<i class="fa fa-search" aria-hidden="true"></i>
													<input type="text" class="frm-input" placeholder="Tìm kiếm danh mục"/>
												</div>
												<div class="list-item">
													@if($mediaCats)
														<a href="#all" data-value="">Tất cả</a>
														@foreach($mediaCats as $item)
															<a href="#{{$item->slug}}" data-value="{{$item->id}}">{{$item->title}}</a>
														@endforeach
													@endif
												</div>
											</div>
										</div>
										<div id="media-find" class="col-md-10 search-input">
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" class="frm-input" placeholder="Tìm kiếm file">
										</div>
									</div>																		
									<div id="files" class="scrollbar-inner">
										<ul class="list-media"></ul>										
									  	<input type="hidden" name="limit" class="limit" value="">									  	
									  	<input type="hidden" name="current" class="current" value="">									  	
									  	<input type="hidden" name="current" class="total" value="">									  	
									</div>
								</div>
								<div class="col-md-2 file-detail scrollbar-inner"><div id="file-detail" class="wrap"></div></div>								
							</div>
							<div class="modal-footer group-action">
								<span class="library-notify"></span>      	
								<a href="#" class="btn btn-primary">Đồng ý</a>
								<button type="button" class="btn btn-cancel" data-dismiss="modal">Đóng</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document ).ready(function(){
		//search key
		$("#library-op #media-find input").keyup(function(){
			var value = $(this).val();			
			var _token = $("#library-op #media input[name='_token']").val();
			var catId = $("#library-op #media #media-cat .dropdown-toggle").attr("data-value");
			$.ajax({
				type:'POST',            
				url:'{{route("filterMedia")}}',
				cache: false,
				data:{
					'_token': _token,
					's': value,
					'catId': catId,
				},
				success:function(data){
					$(".loadding").hide();
					if(data.message!="error"){
						$('#library-op .modal-body #files .list-media').html(data.html);
						$("#library-op #files .limit").val(data.limit);
						$("#library-op #files .current").val(data.current);
						$("#library-op #files .total").val(data.total);
					}
				}
			});
		});
       //filter media by cat
       $("#library-op #media-cat").on('click','.list-item a',function(){
       		var value = $(this).attr("data-value");
   			var _token = $("#library-op #media input[name='_token']").val();
   			$(this).parents("#media-cat").find(".dropdown-toggle").attr("data-value",value);
   			$(this).parents("#media-cat").find(".dropdown-toggle").text($(this).text());
   			$("#library-op #files .limit").val('');			
			$("#library-op #files .current").val('');
			$("#library-op #media-cat .list-item a").removeClass("active");
			$(this).addClass("active");
        	$.ajax({
				type:'POST',            
				url:'{{route("filterMedia")}}',
				cache: false,
				data:{
					'_token': _token,
					'catId': value,
					's': $("#library-op #media-find input").val(),
				},
				success:function(data){
					$(".loadding").hide();
					if(data.message!="error"){
						$('#library-op .modal-body #files .list-media').html(data.html);
						$("#library-op #files .limit").val(data.limit);
						$("#library-op #files .current").val(data.current);
						$("#library-op #files .total").val(data.total);
					}
				}
			});			
       });
       //search media cat
       $("#library-op #media-cat .search-input input").keyup(function(){       		
   			var _token = $("#library-op #media input[name='_token']").val();			
        	$.ajax({
				type:'POST',            
				url:'{{route("searchCatMedia")}}',
				cache: false,
				data:{
					'_token': _token,
					's': $(this).val(),
				},
				success:function(data){
					$(".loadding").hide();
					if(data.message!="error"){
						$('#library-op #media-cat .list-item').html(data.html);						
					}
				}
			});			
       });
       //add media
		var cat_ids = new Array();		
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
		        	$("#category").val("");
		        	$("#sb-mediaCat .checkbox").each(function(){
		        		if($(this).find("input").is(":checked")){
		        			cat_ids.push($(this).find("input").val());
		        		}
		        	});
		        	$("#category").val(cat_ids.toString());		            
		        	myDropzone.processQueue();
		        });
		        this.on('sending', function(file, xhr, formData) {
		            // Append all form inputs to the formData Dropzone will POST
		            var data = $('#frmTarget').serializeArray();
		            $.each(data, function(key, el) {
		            	formData.append(el.name, el.value);
		            });
		            formData.append('category', $('#category').val());
		        });
		        this.on("complete", function(file) {
		        	cat_ids = [];
		        	$("#sb-mediaCat .checkbox input").prop('checked', false);
		        	myDropzone.removeFile(file);
		        	var _token = $("#library-op #media input[name='_token']").val();		
		        	$.ajax({
						type:'POST',            
						url:'{{route("loadMedia")}}',
						cache: false,
						data:{
							'_token': _token
						},
						success:function(data){
							if(data.message=="success"){
								$('#library-op #files .list-media').html(data.html);
								$("#library-op #media-cat .dropdown-toggle").attr("data-value","");
								$("#library-op #media-find input").val("");
								$("#library-op #media-cat .list-item a").removeClass("active");
							}
						}
					})
		        });
		    }
		}		
	});
</script>