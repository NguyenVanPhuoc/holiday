@php
	/*
	* Template table tour
	*/
@endphp
<table class="table-days field row-style">
	<tbody class="sortable" data-action="{{ route('positionDaysTour') }}">
		@if($list_schedule)
			@foreach($list_schedule as $key => $item)
			
				<tr class="edit-{{$item->id}} edit current" data-id="{{$item->id}}" data-position="{{$item->position ? $item->position : $key+1}}">
					<td class="stt">{{$key+1}}</td>
					<td>
						<div class="sch-title field-row">
							<div class="row-left"><label>Title</label></div>
							<div class="row-right">
								<input name="sch-title-{{$key+1}}" value="{{$item->title}}" class="form-control" />
							</div>
						</div>
					<div class="content_days">
						<div class="sch-meal field-row">
							<div class="row-left"><label>Meal</label></div>
							<div class="row-right">
								@php $meal = json_decode($item->meal) @endphp
								<ul class="no-list-style">
									<li class="checkbox checkbox-success">
										<input value="b" type="checkbox" name="meal[]" id="b{{$key+1}}" @if($meal && in_array('b', $meal)) checked @endif />
										<label for="b{{$key+1}}">B</label>
									</li>
									<li class="checkbox checkbox-success">
										<input value="l" type="checkbox" name="meal[]" id="l{{$key+1}}" @if($meal && in_array('l', $meal)) checked @endif />
										<label for="l{{$key+1}}">L</label>
									</li>
									<li class="checkbox checkbox-success">
										<input value="d" type="checkbox" name="meal[]" id="d{{$key+1}}" @if($meal && in_array('d', $meal)) checked @endif />
										<label for="d{{$key+1}}">D</label>
									</li>
								</ul>
							</div>
						</div>

						<div class="sch-content field-row">
							<div class="row-left"><label>Schedule of date</label></div>
							<div class="row-right">
								<textarea name="edit-sch-content-{{$item->id}}" id="edit-sch-content-{{$item->position ? $item->position : $key+1}}" class="sch-content form-control" >{{$item->content}}</textarea>
							</div>
						</div>
						<div class="sch-notes field-row">
							<div class="row-left"><label>Notes</label></div>
							<div class="row-right form-group">
								<textarea name="edit-sch-notes-{{$item->id}}" id="edit-sch-notes-{{$item->position ? $item->position : $key+1}}" class="sch-notes form-control" >{{$item->notes}}</textarea>
							</div>
						</div>
						
						<div id="frm-gallery-{{$item->id}}" class="sch-gallery field-row img-upload">
							<div class="row-left"><label>Gallery</label></div>
							<div class="row-right">
								<div class="wrap-gallery">
									@php $gallery_schedule = json_decode($item->gallery); @endphp
									@if($gallery_schedule)
										@foreach($gallery_schedule as $value)
											@php $image = getMedia($value); @endphp
											<div class="gallery-item item-{{$value}}" data-id="{{$value}}" >
												<div class="wrap-item">
													{!! imageAuto($value, $tour->title) !!}
													<span class="remove-gallery">x</span>
												</div>
											</div>
										@endforeach
									@endif
								</div>
								<div class="bot-wrap">
									<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
									<input type="hidden" name="gallery" class="thumb-media" value="{{ $item->gallery }}">
								</div>
							</div>
						</div>	

						<!-- <div class="sch-brief field-row">
							<div class="row-left"><label>Brief</label></div>
							<div class="row-right">
								<textarea name="edit-sch-brief-{{$item->id}}" class="sch-brief" >{{$item->brief}}</textarea>
							</div>
						</div> -->
						<div class="sch-icon field-row">
							<div class="row-left"><label>Icons details</label></div>
							<div class="row-right">
								@foreach ($catIconSchedules as $cat)
									@php
										$iconSchedules = getIconScheduleByCat($cat->id);
										$iconChecked = json_decode($item->icon);
									@endphp
									@if($iconSchedules)
										<div class="cat-icons" data-id="{{$cat->id}}">
											<strong class="cat-title">{{$cat->title}}</strong>
											<ul class="no-list-style">
												@foreach ($iconSchedules as $icon)
													<li class="checkbox checkbox-success">
														<input value="{{$icon->id}}" type="checkbox" name="icon[]" 
														@if($iconChecked && in_array($icon->id, $iconChecked)) checked @endif />
														<label for="{{$icon->id}}">{{$icon->title}}</label>
													</li>
												@endforeach
											</ul>
										</div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
					</td>
					<td class="delete text-center drop_nvp">
						<div class="del-tooltip">
							<a href="#" class="remove-row"><span>─</span></a>
							<div class="tooltip">
								<div class="wrap">Bạn đồng ý xóa?
									<div id="d-yes"><a href="#" class="yes">Yes</a></div>
									<div id="d-no"><a href="#" class="no">Cancel</a></div>
								</div>
							</div>
						</div>
						<span class="toggle_up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
						<span class="toggle_down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>

