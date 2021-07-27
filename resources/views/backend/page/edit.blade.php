@extends('backend.layout.index')
@section('title','Sửa Trang')
@section('content')
<?php 
use App\GroupMetas;
use App\Metas;

$groupMetas = GroupMetas::where('post_id','=',$page->id)->get();
if($seo){
	$key = $seo->key;
	$value = $seo->value;
}else{
	$key = "";
	$value = "";
}?>
<div id="edit-page" class="page route">
	<div class="head">
		<a href="{{route('pagesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All pages</a>
		<h1 class="title">{{$page->title}}</h1>
	</div>
	<form action="{{ route('editPageAdmin',['id'=>$page->id]) }}" method="POST" name="editPage" class="dev-form edit-post">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<div class="row">
			<div class="col-md-10 content">
				<div id="post-title" class="form-group section">
					<label for="title">Title<small>(*)</small></label>
					<input type="text" name="title" class="form-control" value="{{ $page->title }}"/>		
				</div>
				<div id="frm-metaKey" class="form-group">
					<label for="metakey">Keyword (SEO)</label>
					<input type="text" name="metakey" class="form-control" value="{{$key}}" placeholder="Input keyword (SEO)" class="frm-input">
				</div>
				<div id="frm-metaValue" class="form-group">
					<label class="metaValue">Meta Description (SEO)</label>
					<span class="count-characters">( {{strlen($value)}} characters )</span>
					<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$value}}</textarea>
				</div>	
				<div id="post-content" class="form-group section">
					<label for="name">Content<small>(*)</small></label>
					<textarea name="content" id="editor">{{ $page->content }}</textarea>
				</div>
				@foreach ($groupMetas as $group)
					<?php $group = GroupMetas::findBySlug($group->slug);			
					$metas = Metas::where('groupmeta_id','=', $group->id)->get();?>
					<div id="fields" class="row">
						<?php foreach ($metas as $meta): ?>
							<div id="{{ $meta->id }}" class="item col-md-{{ $meta->width }}">
								<div class="form-group">
									<label for="meta_name">{{$meta->title}}<small>(*)</small></label>
									<?php if($meta->type=="text"):?>
									<input type="text" name="meta_{{ $meta->id }}" id="meta_{{ $meta->id }}" class="form-control meta-value" value="{{ $meta->content }}" data-type="{{ $meta->type }}" />
									<?php elseif($meta->type=="textarea"):?>
										<textarea name="meta_{{ $meta->id }}" id="meta_{{ $meta->id }}" class="form-control meta-value" data-type="{{ $meta->type }}">{{ $meta->content }}</textarea>
									<?php elseif($meta->type=="image"):?>
										<div id="frm-icon-{{ $meta->id }}" class="desc img-upload">							
											<div class="image">
												<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
												{!!image($meta->content, 150,150, 'Image')!!}
												<input type="hidden" name="icon" class="thumb-media meta-value" value="{{$meta->content}}"/>
											</div>
										</div>
									<?php else:?>
										<textarea name="meta_{{ $meta->id }}" id="meta_{{ $meta->id }}" class="form-control meta-value" data-type="{{ $meta->type }}">{{ $meta->content }}</textarea>
										<script type="text/javascript">ckeditor("meta_{{ $meta->id }}")</script>
									<?php endif;?>
								</div>
							</div>								
						<?php endforeach;?>
					</div>
				@endforeach
				
				@if(in_array($page->id, $zzz))
					<div id="frm-sustainability" class="form-group sustainability">
						<label for="itinerary">Sustainability in Actions</label>
						<input type="hidden" name="sustainability" value="yes">
						<table class="field row-style">
							<tbody class="sortable">
							@if($pageMeta)
								@php 
									$list_content = json_decode($pageMeta->meta_value);
								@endphp
								@foreach($list_content as $key => $item)
									<tr class="add" data-position="{{ $item->position}}">
										<td>{{ $key + 1 }}</td>
										<td>
											<div class="sch-title field-row">
												<div class="row-left">
													<label>Title</label>
												</div>
												<div class="row-right">
													<input name="title" class="form-control" value="{{ $item->title }}" />
												</div>
											</div>
											<div class="tb-image field-row">
												<div class="row-left">
													<label>Image</label>
												</div>
												<div class="row-right">
													<div id="img-sutai-{{ $key + 1 }}" class="desc img-upload">							
														<div class="image">
															<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
															{!!image($item->image, 150,150, 'Image')!!}
															<input type="hidden" data-name="image" class="thumb-media" value="{{ $item->image }}" />
														</div>
													</div>
												</div>
											</div>
											<div class="sch-content field-row">
												<div class="row-left">
													<label>Desc</label>
												</div>
												<div class="row-right">
													<textarea name="content" class="sch-content-{{ $key + 1 }}" id="edit-content-{{ $key + 1 }}">{!! $item->content !!}</textarea>
												</div>
											</div>
										</td>
										<td class="delete text-center">
											<div class="del-tooltip">
												<a href="#" class="remove-row"><span>─</span></a>
												<div class="tooltip">
													<div class="wrap">Are you sure?
														<div id="d-yes"><a href="#" class="yes">Yes</a></div>
														<div id="d-no"><a href="#" class="no">Cancle</a></div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn btn-default add-row">Add row</a>
					</div>
					<div id="frm-mutual" class="form-group muatual">
						<label for="itinerary">A MUTUAL BENEFICIAL TOURISM</label>
						<table class="field row-style">
							<tbody class="sortable">
							@if($pageMutual)
								@php 
									$list_muatual = json_decode($pageMutual->meta_value);
								@endphp
								@foreach($list_muatual as $key => $item)
									<tr class="add" data-position="{{ $item->position}}">
										<td>{{ $key + 1 }}</td>
										<td>
											<div class="sch-title field-row">
												<div class="row-left">
													<label>Title</label>
												</div>
												<div class="row-right">
													<input name="title" class="form-control" value="{{ $item->title }}" />
												</div>
											</div>
											<div class="tb-image field-row">
												<div class="row-left">
													<label>Image</label>
												</div>
												<div class="row-right">
													<div id="img-mutual-{{ $key + 1 }}" class="desc img-upload">							
														<div class="image">
															<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
															{!!image($item->image, 150,150, 'Image')!!}
															<input type="hidden" data-name="image" class="thumb-media" value="{{ $item->image }}" />
														</div>
													</div>
												</div>
											</div>
											<div class="sch-content field-row">
												<div class="row-left">
													<label>Desc</label>
												</div>
												<div class="row-right">
													<textarea name="content" class="sch-content-{{ $key + 1 }}" id="edit-mutual-{{ $key + 1 }}">{!! $item->content !!}</textarea>
												</div>
											</div>
										</td>
										<td class="delete text-center">
											<div class="del-tooltip">
												<a href="#" class="remove-row"><span>─</span></a>
												<div class="tooltip">
													<div class="wrap">Are you sure?
														<div id="d-yes"><a href="#" class="yes">Yes</a></div>
														<div id="d-no"><a href="#" class="no">Cancle</a></div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn btn-default add-mutual">Add row</a>
					</div>
					<div id="frm-support" class="form-group support">
						<label for="itinerary">WHAT CAN YOU DO?</label>
						<table class="field row-style">
							<tbody class="sortable">
							@if($pageSupport)
								@php 
									$list_support = json_decode($pageSupport->meta_value);
								@endphp
								@foreach($list_support as $key => $item)
									<tr class="add" data-position="{{ $item->position}}">
										<td>{{ $key + 1 }}</td>
										<td>
											<div class="sch-title field-row">
												<div class="row-left">
													<label>Title</label>
												</div>
												<div class="row-right">
													<input name="title" class="form-control" value="{{ $item->title }}" />
												</div>
											</div>
											<div class="tb-image field-row">
												<div class="row-left">
													<label>Image</label>
												</div>
												<div class="row-right">
													<div id="img-support-{{ $key + 1 }}" class="desc img-upload">							
														<div class="image">
															<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
															{!!image($item->image, 150,150, 'Image')!!}
															<input type="hidden" data-name="image" class="thumb-media" value="{{ $item->image }}" />
														</div>
													</div>
												</div>
											</div>
											<div class="sch-content field-row">
												<div class="row-left">
													<label>Desc</label>
												</div>
												<div class="row-right">
													<textarea name="content" class="sch-content-{{ $key + 1 }}" id="edit-support-{{ $key + 1 }}">{!! $item->content !!}</textarea>
												</div>
											</div>
										</td>
										<td class="delete text-center">
											<div class="del-tooltip">
												<a href="#" class="remove-row"><span>─</span></a>
												<div class="tooltip">
													<div class="wrap">Are you sure?
														<div id="d-yes"><a href="#" class="yes">Yes</a></div>
														<div id="d-no"><a href="#" class="no">Cancle</a></div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn btn-default add-support">Add row</a>
					</div>		
					<div class="d-none att-temp" style="display: none;">
						<table><tbody>
							<tr class="add" data-position="1">
								<td class="stt"></td>
								<td>
									<div class="sch-title field-row">
										<div class="row-left">
											<label>Title</label>
										</div>
										<div class="row-right">
											<input name="title" class="form-control" />
										</div>
									</div>
									<div class="tb-image field-row">
										<div class="row-left">
											<label>Image</label>
										</div>
										<div class="row-right">
											<div id="img-" class="desc img-upload">							
												<div class="image">
													<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
													{!!image('', 150,150, 'Image')!!}
													<input type="hidden" data-name="image" class="thumb-media" value="" />
												</div>
											</div>
										</div>
									</div>
									<div class="sch-content field-row">
										<div class="row-left">
											<label>Desc</label>
										</div>
										<div class="row-right">
											<textarea name="content" class="sch-content"></textarea>
										</div>
									</div>
								</td>
								<td class="delete text-center">
									<div class="del-tooltip">
										<a href="#" class="remove-row"><span>─</span></a>
										<div class="tooltip">
											<div class="wrap">Are you sure?
												<div id="d-yes"><a href="#" class="yes">Yes</a></div>
												<div id="d-no"><a href="#" class="no">Cancle</a></div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</tbody></table>
					</div>
				@endif
				@if(in_array($page->id, $show_gallery))
					<div id="frm-gallery" class="form-group img-upload">
						<label for="itinerary">Gallery</label>
						<div class="wrap-gallery">
							@php $gallery = json_decode($page->gallery); @endphp
							@if($gallery)
								@foreach($gallery as $item)
									@php $image = getMedia($item); @endphp
									<div class="gallery-item item-{{$item}}" data-id="{{$item}}" >
										<div class="wrap-item">
											{!! imageAuto($item, $page->title) !!}
											<span class="remove-gallery">x</span>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="{{$page->gallery}}">
						</div>
					</div>
				@endif
			</div>
			<div class="col-md-2 sidebar">
				<div class="gr-not-fixed">
					<section id="sb-image" class="box-wrap">
						<h2 class="title">Image</h2>
						<div id="frm-image" class="desc img-upload">							
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!!image($page->image, 150,150, 'Image')!!}
								<input type="hidden" name="image" class="thumb-media" value="{{ $page->image }}" />
							</div>
						</div>
					</section>
				</div>
				<div class="group-fixed">
					<section id="sb-action">
						<div class="group-action">
							<a href="{{route('deletePageAdmin',['id'=>$page->id])}}" class="btn btn-delete">Delete</a>
							<button type="submit" class="btn">Save</button>
							<a href="{{route('pagesAdmin')}}" class="btn btn-cancel">Cancel</a>
						</div>
					</section>
				</div>
			</div>
		</div>
	</form>
</div>
	@include('backend.media.library')
	<script type="text/javascript">	
	$('#frm-sustainability table .sortable tr').each(function(){
		var data_id = $(this).attr('data-position');
		ckeditor("edit-content-"+data_id);
	});	
	$('#frm-mutual table .sortable tr').each(function(){
		var data_id = $(this).attr('data-position');
		ckeditor("edit-mutual-"+data_id);
	});	
	$('#frm-support table .sortable tr').each(function(){
		var data_id = $(this).attr('data-position');
		ckeditor("edit-support-"+data_id);
	});	
		ckeditor("editor");
		$(document).ready(function(){		
			$("#edit-page .group-action button").click(function(){
				var _token = $(".edit-post input[name='_token']").val();
				var title = $(".edit-post #post-title input").val();
				var content = CKEDITOR.instances['editor'].getData();								
				var metaKey = $("#frm-metaKey input").val();
				var metaValue = $("#frm-metaValue textarea").val();		
				var image = $('#frm-image input').val();		
				var metaFields = new Array();
				var count = 0;
				var errors = new Array();
	       		var error_count = 0;
	       		var array_gallery = $('#frm-gallery .thumb-media').val(); 
	       		var attr_items = new Array();
                var number = 0;
                $("#frm-sustainability .sortable tr").each(function(){
                   var title = $(this).find("input[name=title]").val();
                   var image = $(this).find("input.thumb-media").val();
                   var content = CKEDITOR.instances[$(this).find(".sch-content textarea").attr("id")].getData();
                        attr_items[number] = {
                            'title' : title,
                            'image' : image,
                            'content' : content,
                            'position' : $(this).attr("data-position")
                        }
                        number++;
                }); 
	            var attr_mutual = new Array();
	            var stt = 0;
               	$("#frm-mutual .sortable tr").each(function(){
                   var title = $(this).find("input[name=title]").val();
                   var image = $(this).find("input.thumb-media").val();
                   var content = CKEDITOR.instances[$(this).find(".sch-content textarea").attr("id")].getData();
                        attr_mutual[stt] = {
                            'title' : title,
                            'image' : image,
                            'content' : content,
                            'position' : $(this).attr("data-position")
                        }
                        stt++;
               });
               	var attr_support = new Array();
	            var so = 0;
               	$("#frm-support .sortable tr").each(function(){
                   var title = $(this).find("input[name=title]").val();
                   var image = $(this).find("input.thumb-media").val();
                   var content = CKEDITOR.instances[$(this).find(".sch-content textarea").attr("id")].getData();
                        attr_support[so] = {
                            'title' : title,
                            'image' : image,
                            'content' : content,
                            'position' : $(this).attr("data-position")
                        }
                        so++;
               });
				$("#fields .item").each(function(){		
					var meta = "meta_"+$(this).attr("id");
					var type = $(this).find(".meta-value").attr("data-type"); 
					var content1 = "";
					if(type == "editor"){
						content1 = CKEDITOR.instances[meta].getData();
					}else{
						content1 = $(this).find(".meta-value").val();
					}
					metaFields[count] = {
						'id' : $(this).attr("id"),
						'content' : content1
					}
					count = count + 1;
				});				
				if(title==""){
		       		errors[0] = "Please input title";
		       	}else{
					errors[0] = "";
		       	}
		       	if(content==""){
		       		errors[1] = "Please input content";
		       	}else{
					errors[1] = "";
		       	}
		       	var i;
		   		var html = "<ul>";
		       	for(i = 0; i < errors.length; i++){
		       		if(errors[i] != ""){
		       			html +='<li>'+errors[i]+'</li>';
		       			error_count += 1;
		       		}
		       	}
		       	if(error_count>0){
			       	html += "</ul>";	       	
			       	new PNotify({
						title: 'Error ('+error_count+')',
						text: html,						    
						hide: true,
						delay: 6000,
					});
		       	}else{
		       		$('#overlay').show();
		       		$('.loading').show();
					$.ajax({
						type:'POST',            
						url:'{{ route("editPageAdmin",["id"=>$page->id]) }}',
						cache: false,
						data:{
							'_token': _token,
							'title': title,
							'content': content,							
							'metaKey': metaKey,							
							'metaValue': metaValue,	
							'image': image,						
							'metaFields': JSON.stringify(metaFields),
							'attr_items': attr_items,
							'attr_mutual': attr_mutual,
							'attr_support': attr_support,
							'array_gallery': array_gallery
						},
						success:function(data){
							$('#overlay').hide();
		       				$('.loading').hide();
							if(data=="success"){										       					       	
								new PNotify({
									title: 'Successfully',
									text: 'Update success.',
									type: 'success',
									hide: true,
									delay: 2000,
								});						
							}else{
								new PNotify({
									title: 'Lỗi',
									text: 'Trình duyệt không hỗ trợ javascript.',						    
									hide: true,
									delay: 2000,
								});
							}
						}
					});
				}
				return false;
			});
		//delete location
		$(".dev-form .btn-delete").click(function(){
			var href = $(this).attr("href");
			(new PNotify({
				title: 'Xóa',
				text: 'Bạn muốn xóa trang này?',
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