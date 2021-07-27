@extends('backend.layout.index')
@section('title','articles')
@section('content')
<?php $categories = get_categories();	
	$category = isset($category)? $category : '';	
	if(isset($category) && $category!=""){
		$catId = $category;
		$catTitle = get_category($category)->title;
	}else{
		$catId = "";
		$catTitle = "---Category---";
	}
	$country = isset($country)? $country : '';	
	if(isset($country) && $country!=""){
		$countryId = $country;
		$countryTitle = get_countries($country)->title;
	}else{
		$countryId = "";
		$countryTitle = "---All country---";
	}
	$key = isset($s)? $s:'';

?>
@php
	$countries = getCountryLevel1();
@endphp
<div id="articles" class="page articles-page">
	<div class="head container">
		<h1 class="title">Blogs</h1>		
	</div>	
	<div class="main">
		<div class="search-form">
			<form name="s" action="{{route('searchBlogAdmin')}}" method="GET">
				<div class="row">
					<div id="s-country" class="col-md-4">
						<select name="country">
							<option value="{{$countryId}}">{{$countryTitle}}</option>
							@foreach($countries as $item)
								<option value="{{ $item->id }}">{{ $item->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-category" class="col-md-4">
						<select name="category">
							<option value="{{$catId}}">{{$catTitle}}</option>
							@if($categories)								
								@foreach($categories as $item)
									<option value="{{$item->id}}">{{$item->title}}</option>
								@endforeach
							@endif
						</select>
					</div>				
					<div id="frm-title" class="col-md-4"><input type="text" name="s" class="form-control" placeholder="Input keyword..." value="{{$key}}"></div>
				</div>
				<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
		<form action="{{route('blogAdmin')}}" method="POST" name="blog" class="dev-form" data-delete="{{ route('deleteBlogsAdmin') }}">
			{!!csrf_field()!!}
			<table class="table table-striped list">
				<thead class="thead-dark">
					<tr>
						<th id="check-all" scope="col" class="check">
							<div class="checkbox checkbox-success">
								<input id="check" type="checkbox" name="checkAll[]" value="">
								<label for="check"></label>
							</div>
						</th>
						<th scope="col" class="stt">#</th>
						<th scope="col" class="image">Image</th>
						<th scope="col" class="title">Title</th>
						<th scope="col" class="country">Country</th>
						<th scope="col" class="category">Category</th>
						<th scope="col" class="view-number">View</th>					
						<th scope="col" class="author">Author</th>					
						<th scope="col" class="status">Status</th>					
						<th scope="col" class="action"></th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;?>
					@foreach($articles as $item)
						<?php $count++;						
							$categories = implode(", ",get_titleByIds($item->categories,'category'));
							$author = getUser($item->user_id);
							$cat = get_category($item->cat_id);
							$country_id = getCountryOfArticleV1($item->id);
							//dd($country);
						?>
						<tr id="item-{{$item->id}}">
							<td class="check">
								<div class="checkbox checkbox-success">
									<input id="article-{{$item->id}}" type="checkbox" name="articles[]" value="{{$item->id}}">
									<label for="article-{{$item->id}}"></label>
								</div>
							</td>
							<th scope="row" class="stt">{{$count}}</th>
							<td class="image"><a href="{{ route('editBlogAdmin',['id'=>$item->id]) }}">{!!image($item->image, 50,50, $item->name)!!}</a></td>
							<td class="title"><a href="{{ route('editBlogAdmin',['id'=>$item->id]) }}">{{$item->title}}</a></td>
							<td class="country">
								@if(count($country_id)==0)
									{{$country_id[0]->title}}
								@else
									@foreach($country_id as $key1 => $value)
										@php
											$prefix = '';
											if($key1 != 0) $prefix = ', ';
											if($key1 == $value->count() - 1) $prefix = '';
										@endphp
										{{$prefix}}{{$value->title}}
									@endforeach
								@endif
							</td>
							<td class="category">@if($cat) {{$cat->title}} @endif</td>
							<td class="view-number">{{$item->view}}</td>
							<td class="author">{{$author->name}}</td>
							<td class="status status-{{$item->status}}">
								@if($item->status == 1)
									Active
								@else
									Inactive
								@endif
							</td>
							<td class="action">						
								<a href="{{ route('editBlogAdmin',['id'=>$item->id]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
								<a href="{{ route('deleteBlogAdmin',['slug'=>$item->id]) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
							</td>
						</tr>				
					@endforeach				
				</tbody>
			</table>
		</form>
	</div>
	@if($catId=="" && $country=="" && $key=="")
		{!! $articles->links() !!}
	@else
		{!! $articles->appends(['category'=>$catId,'country'=>$country,'s'=>$key])->links() !!}		
	@endif
</div>
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Successfully',
		    text: 'Successfully deleted',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {
		$(".search-form").on('click','button',function(){
			var category = $(".search-form #frm-category select").val();
			var country = $(".search-form #s-country select").val();
			var key = $(".search-form #frm-title input").val();			

			if(category==""&& country=="" && key==""){
				new PNotify({
					title: 'Error',
					text: 'Please choose a category / input keyword',						    
					hide: true,
					delay: 6000,
				});
			}else{
				return true;
			}
			return false;
		});
		
		//delete location
      	$("#articles .delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Delete',
			    text: 'Do you delete?',
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
	});	
</script>
@stop