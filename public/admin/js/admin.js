$(document ).ready(function(){	
	$('#frm-sustainability .add-row').click(function(e){
		e.preventDefault();
		var html = $('.att-temp tbody').html();
		var number = $(this).parents('#frm-sustainability').find('tbody.sortable tr').length + 1; 
		$('#frm-sustainability tbody.sortable').append(html);
		var item = $(this).parents('#frm-sustainability').find('tbody.sortable tr:last-child');
		item.find(".img-upload").attr("id","img-sutai-"+number);
		item.attr("data-position",number);
		item.find("td.stt").text(number);
		item.find("textarea.sch-content").attr("id","edit-content-"+number);
		ckeditor("edit-content-"+number);	
	});
	//add row mutual
	$('#frm-mutual .add-mutual').click(function(e){
		e.preventDefault();
		var html = $('.att-temp tbody').html();
		var number = $(this).parents('#frm-mutual').find('tbody.sortable tr').length + 1; 
		$('#frm-mutual tbody.sortable').append(html);
		var item = $(this).parents('#frm-mutual').find('tbody.sortable tr:last-child');
		item.find(".img-upload").attr("id","img-mutual-"+number);
		item.attr("data-position",number);
		item.find("td.stt").text(number);
		item.find("textarea.sch-content").attr("id","edit-mutual-"+number);
		ckeditor("edit-mutual-"+number);	
	});
	//add row support
	$('#frm-support .add-support').click(function(e){
		e.preventDefault();
		var html = $('.att-temp tbody').html();
		var number = $(this).parents('#frm-support').find('tbody.sortable tr').length + 1; 
		$('#frm-support tbody.sortable').append(html);
		var item = $(this).parents('#frm-support').find('tbody.sortable tr:last-child');
		item.find(".img-upload").attr("id","img-support-"+number);
		item.attr("data-position",number);
		item.find("td.stt").text(number);
		item.find("textarea.sch-content").attr("id","edit-support-"+number);
		ckeditor("edit-support-"+number);	
	});
    //back to top
    $('body').append('<div id="backtotop"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></div>');
        $(window).scroll(function() {
            if($(window).scrollTop() >200) {
              $('#backtotop').fadeIn();
              } else {
              $('#backtotop').fadeOut();
              }
            });
        $('#backtotop').click(function() {
        $('html, body').animate({scrollTop:0},500);
    });
	$('.scrollbar-inner').scrollbar();	
	/*$('.select2').select2();
	$("ul.select2-selection__rendered").sortable({
	  containment: 'parent'
	});*/

	//var selectEl = $('.select2').select2();
	/*$(".select2-selection__rendered").sortable({
		containment: 'parent', stop: function (event, ui) {
			var select = $(this).closest('select.select2');
			ui.item.parent().children('[title]').each(function () {
				var title = $(this).attr('title');
				var original = $( 'option:contains(' + title + ')', select ).first();
				original.detach();
				select.append(original)
			});
			select.change();
		}
	});*/
	/*selectEl.next().children().children().children().sortable({
		containment: 'parent', stop: function (event, ui) {
			ui.item.parent().children('[title]').each(function () {
				var title = $(this).attr('title');
				var original = $( 'option:contains(' + title + ')', selectEl ).first();
				original.detach();
				selectEl.append(original)
			});
			selectEl.change();
		}
	});*/

	$('.select2').select2().on("select2:select", function (evt) {
	  	var element = evt.params.data.element;
	  	var $element = $(element);
	  
	  	$element.detach();
	  	$(this).append($element); 
	  	$(this).trigger("change");
	});
	if($('.select2').length){
		$('.select2').each(function(evt){
			if($(this).attr('data-order') != undefined && $(this).attr('data-order') != ''){ 
				//sortable
				var selectEl = $(this);

				//append value
				let select = $(this);
				let str = $(this).attr('data-order');
				let array = str.split(","); 
				//$(this).val(array).trigger('change'); // Notify any JS components that the value changed
				$(this).val(array[0]).trigger('change');

				//var option = new Option('Da Nang', 72, false, true);
				//$(this).append(option).trigger("change");
				for(let i=1; i < array.length; i++){
					let title = select.find('option[value='+ array[i] +']').text();
					if(title != ''){
						//remove old option
						select.find("option[value='" + array[i] + "']").remove();
						//create new option
						let option = new Option(title, array[i], true, true);
						select.append(option).trigger("change");
					}
				}

				selectEl.select2({
				    placeholder: 'Select value'
				}).on("select2:select", function (evt) {
				        var id = evt.params.data.id;

				        var element = $(this).children("option[value="+id+"]");

				        moveElementToEndOfParent(element);

				        $(this).trigger("change");
				    });
				var ele=selectEl.parent().find("ul.select2-selection__rendered");
				ele.sortable({
				    containment: 'parent',
				    update: function() {
				        orderSortedValues();
				        console.log(""+selectEl.val())
				    }
				});

				orderSortedValues = function() {
				var value = ''
				    selectEl.parent().find("ul.select2-selection__rendered").children("li[title]").each(function(i, obj){

				        var element = selectEl.children('option').filter(function () { return $(this).html() == obj.title });
				        moveElementToEndOfParent(element)
				    });
				};

				moveElementToEndOfParent = function(element) {
				    var parent = element.parent();

				    element.detach();

				    parent.append(element);
				};

			}
		});
	}

	$(".dev-form .drop_nvp .toggle_up").on('click', function(e){
		e.preventDefault();
		$(this).parents('tr').addClass('current');
	});
	$(".dev-form .drop_nvp .toggle_down").on('click', function(e){
		e.preventDefault();
		$(this).parents('tr').removeClass('current');
	});

	/*
	* set height for left sidebar menu 
	*/
	$(document).ready(function(){
		var height_window = $(window).height();
		var height_document = $(document).outerHeight(); 
		var css_text = '';
		if(height_document <= height_window){
			css_text = (height_window - 110) + 'px !important';
			$('#sidebar .wrap-sidebar').css('cssText', 'max-height:' + css_text);
		}
		else{
			css_text = (height_document - 110) + 'px !important';
			$('#sidebar .wrap-sidebar').css('cssText', 'max-height:' + css_text );
		}
	});

	//empty search form
	$(".search-frm").on('click','.fa-close', function(){
		$(".search-frm .s").val("");
	})
	//create slug for post
	$(".add-post #title .title").keyup(function(){
		$(".add-post #title .slug").val($(this).val());
	});
	/**
	 * dell select item
	 */
	$(document).on("click", "#check-all", function(){
		if($(this).find("input").is(":checked")){			
			$(".dev-form tbody .check input").prop("checked", true);
			$(".dev-form .table").before('<button class="dell-all btn btn-top">Xóa</button>');
			$(".dev-form .table").after('<button class="dell-all btn btn-bottom">Xóa</button>');
		}else{			
			$(".dev-form .dell-all").remove();			
			$(".dev-form tbody .check input").prop('checked', false);
		}
	})
	$(".dev-form").on("click", "tbody .check", function(){ 
		var items = new Array();
		$(".dev-form .dell-all").remove();
		$(".dev-form tbody tr").each(function(){
			if($(this).find(".check input").is(":checked")){
				items.push($(this).find("input").val());
			}
		});		
		if(items.length>0){
			$(".dev-form .table").before('<button class="dell-all btn btn-top">Xóa</button>');
			$(".dev-form .table").after('<button class="dell-all btn btn-bottom">Xóa</button>');
		}
	});	

	//delete all
	$(".dev-form").on('click','.dell-all',function(e){ 
		e.preventDefault();
		var url = $(this).parents("form").attr("data-delete");
		var form = $(this).closest('form');
		if(typeof url !== typeof undefined && url !== false){
	  		var _token = $(this).parents("form").find("input[name='_token']").val();
			var items = new Array();
			$(".dev-form tbody tr").each(function(){
				if($(this).find(".check input").is(":checked")){
					items.push($(this).find("input").val());
				}
			});		
			if(items<0){		       	
		       	new PNotify({
					title: 'Error',
					text: 'Please choose row delete.!',
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$('#overlay').show();
	       		$('.loading').show();
				$.ajax({
					type:'GET',            
					url:$(this).parents("form").attr("data-delete"),
					cache: false,
					/*data:{
						'_token': _token,
						'items': JSON.stringify(items)
					},*/
					data: form.serialize()+'&items='+JSON.stringify(items),
				}).done(function(data) {
					$('#overlay').hide();
       				$('.loading').hide();
       				
					if(data.html != undefined){
						$('#tb-result').html(data.html);
						new PNotify({
							title: 'Successfully',
						    text: 'Successfully deleted',
							type: 'success',
							hide: true,
							delay: 2000,
						});		
					}
					else if(data=="success"){ 
						$(".dev-form tbody .check input").prop('checked', false);
						$('.dev-form .dell-all.btn-top').remove();
						$.each(items, function(index, value){
							$(".dev-form #item-"+value).remove();
						});
						items = new Array();
						$(".dev-form  .dell-all").remove();
						new PNotify({
							title: 'Successfully',
						    text: 'Successfully deleted',
							type: 'success',
							hide: true,
							delay: 2000,
						});						
					}else{
						new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try again. ',						    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
			}

			return false;
		}

	});

	//delete location
  	$(document).on('click', '.dev-form .btn-delete', function(e){
  		e.preventDefault();
  		var href = $(this).attr("href");
  		(new PNotify({
		    title: 'Delete',
		    text: 'Do you want delete?',
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
  	});

  	$('.dev-form .btn-delete').click(function(e){  
  		e.preventDefault();
  		var href = $(this).attr("href");
  		(new PNotify({
		    title: 'Delete',
		    text: 'Do you want delete?',
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

	/**
	 * menu left
	 */
	$("#sidebar #menu .has-children").click(function(){		
		var check = 0;
		if($(this).hasClass("active")){
			check = 1;
		}
		$("#sidebar #menu .has-children").removeClass('active');
		if(check==0){
			$(this).toggleClass("active");			
		}	
	});
	//check change password
	$("#change-user .check-password .custom-control-input").click(function(){		
		if($(this).is(":checked")){			
			$("#change-user .change-password .form-control").removeAttr("disabled");
			$("#change-user .change-password").slideDown();
			$(this).val("on");
		}else{
			$(this).val("");
			$("#change-user .change-password .form-control").attr("disabled","");
			$("#change-user .change-password").slideUp();
		}
	})

	$(".dev-form .action").on('click', '.delete', function(){
		var title = $(this).parents("tr").find(".title").text();
		var link = $(this).attr("href");
		$('.delete-modal .modal-footer .btn-primary').attr("href",link);
		$('.delete-modal .modal-body p').html("Bạn chắc là muốn xóa <strong>"+title+" ?</strong>");		
		$('.delete-modal').modal('toggle');
		return false;
	});
	
	/**
	 * library
	 */
	$(".dev-form").on('click','.library',function(){		
		$("#library-op").removeClass('multi');
		var _token = $(".dev-form input[name='_token']").val();		
		var link = $(this).attr("href");
		var tag_id = $(this).parents(".img-upload").attr("id");			
		$("#library-op .modal-footer .btn-primary").attr("id",tag_id);
		$(".loadding").show();
		$.ajax({
			type:'POST',            
			url:link,
			cache: false,
			data:{
				'_token': _token
			},
			success:function(data){
				$(".loadding").hide();				
				if(data.message!='error'){
					$("#library-op #file-detail").empty();
					$('#library-op .modal-body #files .list-media').html(data.html);					
					$("#library-op #files .limit").val(data.limit);					
					$("#library-op #files .current").val(data.current);
					$("#library-op #files .total").val(data.total);
					$("#library-op").modal('toggle');
				}
			}
		})
		return false;			
	});
	//load more media	
	var total = 0;
	var current = 0;
	var limit = 0;	
	$("#library-op #files").scroll(function(){
		var _token = $(".dev-form input[name='_token']").val();
		var mediaCatId = $("#library-op #media-cat .dropdown-toggle").attr("data-value");
		var s = $("#library-op #media-find input").val();
		total = parseInt($("#library-op #files .total").val());
		current = parseInt($("#library-op #files .current").val());
		limit = $("#library-op #files .limit").val();		
		if(total>current){
			if($("#library-op #files").scrollTop() + $("#library-op #files").height()>= $("#library-op .list-media").height() + 10) {
				$.ajax({
					type:'POST',            
					url:$("#library-op .more-media").val(),
					cache: false,
					data:{
						'_token': _token,
						'catId': mediaCatId,
						's': s,										
						'limit': $("#library-op #files .limit").val(),										
						'current': $("#library-op #files .current").val(),
					},
					success:function(data){
						if(data!="error"){
							total = data.total;
							current = data.current
							$('#library-op .modal-body #files .list-media').append(data.html);											
							$("#library-op #files .limit").val(data.limit);							
							$("#library-op #files .current").val(data.current);
							$("#library-op #files .total").val(data.total);
						}
					}
				})					       
		    }
	    }
	});
	$("#library-op .nav-tabs li").click(function(){
		$("#library-op .nav-tabs li").removeClass("active");
		$(this).addClass("active");
	});

	//change thumbnail
	$("#library-op .modal-footer").on('click','.btn-primary',function(){			
		$("#library-op .modal-footer .library-notify").empty();
		var img_url = $("#library-op .modal-body li.active img").attr("src"); 
		var img_alt = $("#library-op .modal-body li.active img").attr("alt");
		var img_id;
		if( $(".list-media li.active").length){
			img_id = $(".list-media li.active").attr("id").split("-");
		} 
		var tag_id = $(this).attr("id"); 
		if(img_url === undefined){	
			$("#library-op .modal-footer .library-notify").text("Vui lòng chọn file!!");
		}else{

			if(!$('#library-op').hasClass('multi')){ //old
				$(".dev-form #"+ tag_id+ " img").attr("src", img_url);
				$(".dev-form #"+ tag_id+ " .thumb-media").val(img_id[1]); 
				$("#library-op").modal('toggle');
				$(".modal-backdrop").modal('toggle');

				//if add pdf file
				if(tag_id == 'frm-pdf'){ 
					var file_name = $("#library-op .modal-body li.active img").attr("alt"); 
					var html = '';
					html += '<div class="wrap-pdf add">';
						html += '<img src="'+img_url+'" alt="pdf-icon"/>';
						html +='<h5>'+file_name+'</h5>';
						html += '<span class="remove-file">x</span>'
					html += '</div>';
					$(".dev-form #"+ tag_id).prepend(html);
					$(".dev-form #"+ tag_id +" .library").addClass('hide');
				}
				
			}
			else{//select multi
				var array_chose = $('#library-op input[name=array_chose]').val(); 
				var chosed = JSON.parse(array_chose);
				var html = '';
				var array_value = new Array();
				if($(".list-media li.active").length){
					for(var i=0; i<chosed.length; i++){
						var img_path = $('#image-'+chosed[i]+' img').attr('src'); 
						html += '<div class="gallery-item item-'+ chosed[i] +'" data-id="'+ chosed[i] +'" >';
							html += '<div class="wrap-item">'
								html += '<img src="'+img_path+'" alt="image"/>';
								html += '<span class="remove-gallery">x</span>'
							html += '</div>';
						html += '</div>';
					}
				}				
				$(".dev-form #"+ tag_id+ " .wrap-gallery").append(html); 
				$('#' + tag_id +' .wrap-gallery .gallery-item').each(function(){
					array_value.push($(this).attr('data-id'));
				});
				$(".dev-form #"+ tag_id+ " .thumb-media").val(JSON.stringify(array_value));
				$("#library-op").modal('toggle');
			}
			
		}
		return false;
	});
	//detail media file
	$("#library-op.single .modal-body").on('click', '.list-media li', function(e){	
		e.preventDefault();
		if(!$(this).parents('#library-op').hasClass('multi')){
			$(".list-media li").removeClass("active");
			$(this).addClass('active');						
			var _token = $("#library-op #media input[name='_token']").val();
			var height = $("#library-op #files").height();
			$("#library-op .file-detail").css({'min-height':height});			
			$("#library-op .file-detail .wrap").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>');						
			$.ajax({
				type:'POST',
				url:location.protocol + "//" + location.host+'/admin/media/detail',
				cache: false,
				data:{
					'_token': _token,
					'id': $(this).attr("id")
				},
			}).done(function(data) {
				if(data.message=="success"){
					$("#library-op .file-detail .wrap").attr('data-id',data.file_id);
					$("#library-op .file-detail .wrap").html(data.html);
				}           		
			});
		}
		else{
			if(!$(this).hasClass('selected')){
				var img_id = $(this).attr("id").split("-");
				var array_chose = $('#library-op input[name=array_chose]').val();
				if($(this).hasClass('active')){
					$(this).removeClass('active');
					if(array_chose != ''){
						var chosed = JSON.parse(array_chose);
						var removeItem = img_id[1];
						chosed = jQuery.grep(chosed, function(value) {
					        return value != removeItem;
				      	});
				      	$('#library-op input[name=array_chose]').val(JSON.stringify(chosed));
					}
				}
				else{
					$(this).addClass('active');
					if(array_chose != ''){
						var chosed = JSON.parse(array_chose);
						chosed.push(img_id[1]);
						$('#library-op input[name=array_chose]').val(JSON.stringify(chosed)); 
					}
					else{
						$('#library-op input[name=array_chose]').val(JSON.stringify([img_id[1]]));
					}
				}
			}
		}	
	});
	//change attrbute media detail
	$("#library-op .file-detail").on('focusout', '.att-item .frm-input', function(){
		var _token = $("#library-op #media input[name='_token']").val();		
		$.ajax({
			type:'POST',            
			url:location.protocol + "//" + location.host+'/admin/media/attribute',
			cache: false,
			data:{
				'_token': _token,
				'id': $('#library-op .file-detail .wrap').attr("data-id"),
				'type': $(this).attr("data-value"),
				'value': $(this).val()
			}
		})
		return false;
	});
	//change cateogry media detail
	$("#library-op .file-detail").on('click', '.attachment-cat .list .checkbox', function(){
		var _token = $("#library-op #media input[name='_token']").val();
		var categories = new Array();       	       	
       	$("#library-op .file-detail .attachment-cat .list .checkbox").each(function(){
       		if($(this).find("input").is(':checked')){
       			categories.push($(this).find("input").val());
       		}
       	});
       	$.ajax({
			type:'POST',            
			url:location.protocol + "//" + location.host+'/admin/media/change-category',
			cache: false,
			data:{
				'_token': _token,
				'id': $('#library-op .file-detail .wrap').attr("data-id"),
				'type': $(this).attr("data-value"),
				'categories': JSON.stringify(categories)
			}
		});		
	});
	//delete media
	$("#library-op .file-detail").on('click', '.attachment-info .delete', function(){
		var _token = $("#library-op #media input[name='_token']").val();
		var id = $('#library-op .file-detail .wrap').attr("data-id");
		var link = $("#library-op .tab-content #media form").attr("action");		
		$.ajax({
			type:'POST',            
			url:link,
			cache: false,
			data:{
				'_token': _token,
				'id': id
			},
			success:function(data){
				if(data!="error"){
					$("#library-op .modal-body #image-"+id).remove();
					$("#library-op #file-detail").empty();
				}
			}
		})
		return false;
	});

	//view detail order
	$(".tb-results .action .view").click(function(){		
		var id = $(this).attr("data-value");
		var check = 0;
		if($(".tb-results tbody .item-"+id).hasClass("active")){
			check = 1;
		}
		$(".tb-results tbody .detail").removeClass('active');
		if(check==0){
			$(".tb-results tbody .item-"+id).addClass("active");
		}
		return false;
	});
	//dropdown
	$('body').on('click', '.local-dropdown .dropdown-menu .list-item a' ,function(e){
		e.preventDefault();
		$(this).parents('.dropdown').find('.dropdown-toggle').text($(this).text());
		$(this).parents('.dropdown').find('.dropdown-toggle').attr("data-value",$(this).attr("data-value"));
		$(this).parents(".dropdown-menu").removeClass("show");
		$(".local-dropdown .dropdown-menu .list-item a").removeClass('active');
		$(this).addClass('active');
		return false;
	});
	//vs-drop
	$('body').on('click', '.vs-drop .list-item a', function(e){ 
		e.preventDefault();
		$(this).parents(".vs-drop").find(".dropdown-toggle").attr("data-value",$(this).attr("data-value"));
		$(this).parents(".vs-drop").find(".dropdown-toggle").text($(this).text());
		if($(this).parents('.dropdown').find('input.value').length){ 
			$(this).parents('.dropdown').find('input.value').val($(this).attr("data-value"));
		}
		$(this).closest('.vs-drop').find('.dropdown-menu .list-item a').removeClass('active'); 
		$(this).addClass('active'); 
	});


	//active item in dropdown
	if($('.dropdown').length){ 
		$('.dropdown').each(function(e){
			var value = $(this).find('.dropdown-toggle').attr('data-value'); 
			$(this).find('.list-item li a').each(function(){
				var temp = $(this).attr('data-value');
				if(temp == value) $(this).addClass('active'); 
			});
		});
	}

	$('body').on('click', '.dropdown .dropdown-toggle', function(e){ 
		e.preventDefault();
		var data_toggle = $(this).attr('data-toggle'); 
		if(data_toggle == undefined){
			$(this).closest('.dropdown').find('.dropdown-menu').toggleClass('show')
			var height = $(this).closest('.dropdown').find('.list-item').outerHeight(true); 
		}
		//scroll-inner
		$(this).closest('.dropdown').find('.scrollbar-inner').scrollbar();
		//scroll to
		
		if($(this).closest('.dropdown').find('.list-item li a').hasClass('active')){
			var height_scroll = 0;
			$(this).closest('.dropdown').find('.dropdown-menu').show().find('.list-item li').each(function(){
				if($(this).find('a').hasClass('active')) return false;
				else{
					height_scroll += $(this).outerHeight(true);
				}
			}); 

			$(this).closest('.dropdown').find('.dropdown-menu .list-item').animate({scrollTop: height_scroll}, 1); 
			$(this).closest('.dropdown').find('.dropdown-menu').hide();
		}
		
	});


	/**
	 * tags
	 */
	$(".tags input").keypress(function(e){
		if(e.which == 13) {			
			if($(this).val()!=""){
		    	$(this).parents(".tags").find(".list").append('<li class="new"><i class="fa fa-close" aria-hidden="true"></i><span>'+$(this).val()+'</span></li>');
		    	$(this).parents(".tags").find("input").val("");
		    }
	    	return false;
	    }	    
	});
	$(".tags button").click(function(){
		var value = $(this).parents(".tags").find("input").val();
		if(value!=""){
			$(this).parents(".tags").find(".list").append('<li class="new"><i class="fa fa-close" aria-hidden="true"></i><span>'+value+'</span></li>');	
			$(this).parents(".tags").find("input").val("");
		}		
		return false;
	});
	$(".tags .list").on('click','i',function(){
		$(this).parent("li").remove();
	});

	//Active country parent
	$('#edit-country').ready(function(){
		var cr_value = $('#sb-parent #dropdown-parent').attr('data-value');
		$('#sb-parent .list-item li').each(function(){
			if($(this).find('a').attr('data-value') == cr_value){
				$(this).find('a').addClass('active');
			}
		});
	});

	//Edit tour page
	if($('#edit-tour').length){
		var cr_value = $('#sb-duration #dropdown-duration').attr('data-value');
		$('#sb-duration .list-item li').each(function(){
			if($(this).find('a').attr('data-value') == cr_value){
				$(this).find('a').addClass('active');
			}
		});

		//active country
		/*if($('#sb-country input[name=countries_active]').val() != ''){
			countries_active = $('#sb-country input[name=countries_active]').val().split(','); 
			for(i=0; i<countries_active.length; i++){
				$("#sb-country .list-item li input").each(function(){
					if($(this).val() == countries_active[i]){
						$(this).prop('checked', true);
					}
				});
			}
		}*/
	}

	/*
	* Sidebar country
	*/
	if($('#sb-country').length){
		//active country
		if($('#sb-country input[name=countries_active]').length && $('#sb-country input[name=countries_active]').val() != ''){
			countries_active = $('#sb-country input[name=countries_active]').val().split(','); 
			var height_scroll = 0;
			for(i=0; i<countries_active.length; i++){
				$("#sb-country .list-item li input").each(function(){
					if($(this).val() == countries_active[i]){
						$(this).prop('checked', true);
					}
				});
			}

			//scroll to item active
			$("#sb-country .list-item li input").each(function(){
				if($(this).val() == countries_active[0]) return false;

				height_scroll += $(this).closest('li').outerHeight(true) - 2; 
			});
			$('#sb-country .list-item').animate({scrollTop: height_scroll}, 1); 
		}
	}


	/*
	* library gallery
	*/
	$(".dev-form").on('click','.library-gallery',function(){
		$("#library-op #file-detail").empty();
		$("#library-op .modal-footer .library-notify").empty();
		$('#library-op input[name=array_chose]').val('');
		$("#library-op").addClass('multi');
		var _token = $(".dev-form input[name='_token']").val();		
		var link = $(this).attr("href");
		var tag_id = $(this).parents(".img-upload").attr("id");			
		$("#library-op .modal-footer .btn-primary").attr("id",tag_id);
		$(".loadding").show();
		$.ajax({
			type:'POST',            
			url:link,
			cache: false,
			data:{
				'_token': _token
			},
			success:function(data){
				$(".loadding").hide();				
				if(data.message!='error'){
					$('#library-op .modal-body #files .list-media').html(data.html);					
					$("#library-op #files .limit").val(data.limit);					
					$("#library-op #files .current").val(data.current);
					$("#library-op #files .total").val(data.total);
					$("#library-op").modal('toggle');
					
					//check item selected
					if($('#' + tag_id + ' .wrap-gallery .gallery-item').length){
						$('#' + tag_id + ' .wrap-gallery .gallery-item').each(function(){
							var cr_id = $(this).attr('data-id');
							$('#library-op.multi #image-'+cr_id).addClass('selected');
						});
					}
				}
			}
		})
		return false;			
	});

	//remove image gallery
	$('.dev-form').on('click', '.wrap-gallery .gallery-item .remove-gallery', function(){ 
		var tag_id = $(this).parents(".img-upload").attr("id");	
		$(this).parents('.gallery-item').remove();
		if($('#'+ tag_id + ' .wrap-gallery .gallery-item').length){ 
			var array_value = new Array();
			$('#'+ tag_id +' .wrap-gallery .gallery-item').each(function(){
				array_value.push($(this).attr('data-id'));
			}); 
			$('#'+ tag_id +' .thumb-media').val(JSON.stringify(array_value));
		}
		else{
			$('#'+ tag_id +' .thumb-media').val('');
		}
	});

	//remove file pdf in tour
	$('#frm-pdf').on('click', '.wrap-pdf .remove-file', function(){
		//$(this).parents('#frm-pdf').find('.wrap-pdf').remove();
		$(this).parents('#frm-pdf').find('input.thumb-media').val('');
		$(this).parents('#frm-pdf').find('.library').removeClass('hide');
		$(this).parents('#frm-pdf').find('.wrap-pdf').remove();
	});

	/*
	* Delete item
	*/
	$(".delete-item").click(function(){
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


	/*
	* Schedule tour
	*/
	$('#frm-schedule .add-chedule').click(function(e){
		e.preventDefault();
		var number_item = $('#frm-schedule tbody tr').length + 1; 
		var linkMedia = $(this).attr('data-link');
		var html = '';
		var checked_meal = '';
		if(number_item > 1){ checked_meal = 'checked'; }
		html += '<tr class="add" data-position="'+ number_item +'">';
			html += '<td>'+number_item+'</td>'; //column 1
			html += '<td>'; //column 2
				html += '<div class="sch-title field-row">';
					html += '<div class="row-left">';
						html += '<label>Title</label>';
					html += '</div>';
					html += '<div class="row-right">';
						html += '<input name="sch-title-'+ number_item +'" class="form-control" />';
					html += '</div>';
				html += '</div>';

				html += '<div class="sch-meal field-row">';
					html += '<div class="row-left">';
						html += '<label>Meal</label>';
					html += '</div>';
					html += '<div class="row-right">';
						html += '<ul class="no-list-style">';
							html += '<li class="checkbox checkbox-success">';
								html += '<input value="b" type="checkbox" name="meal[]" id="b'+ number_item +'"/>';
								html += '<label for="b'+ number_item +'">B</label>';
							html += '</li>';
							html += '<li class="checkbox checkbox-success">';
								html += '<input value="l" type="checkbox" name="meal[]" id="l'+ number_item +'" />';
								html += '<label for="l'+ number_item +'">L</label>';
							html += '</li>';
							html += '<li class="checkbox checkbox-success">';
								html += '<input value="d" type="checkbox" name="meal[]" id="d'+ number_item +'" />';
								html += '<label for="d'+ number_item +'">D</label>';
							html += '</li>';
						html += '</ul>';
					html += '</div>';
				html += '</div>';

				html += '<div class="sch-content field-row">';
					html += '<div class="row-left">';
						html += '<label>Schedule of date</label>';
					html += '</div>';
					html += '<div class="row-right">';
						html += '<textarea name="add-sch-content-'+ number_item +'" class="sch-content" id="edit-sch-content-'+ number_item +'" ></textarea>';
					html += '</div>';
				html += '</div>';

				html += '<div class="sch-notes field-row">';
					html += '<div class="row-left">';
						html += '<label>Notes</label>';
					html += '</div>';
					html += '<div class="row-right form-group">';
						html += '<textarea name="add-sch-notes-'+ number_item +'" class="sch-notes form-control" id="edit-sch-notes-'+ number_item +'" ></textarea>';
					html += '</div>';
				html += '</div>';

				html += '<div id="frm-gallery-'+ number_item + '" class="sch-gallery field-row img-upload">';
					html += '<div class="row-left">';
						html += '<label>Gallery</label>';
					html += '</div>';
					html += '<div class="row-right">';
						html += '<div class="wrap-gallery"></div>';
						html += '<div class="bot-wrap">';
							html += '<a href="'+ linkMedia + '" class="btn btn-default library-gallery">Add to gallery</a>';
							html += '<input type="hidden" name="gallery" class="thumb-media" value="">';
						html += '</div>';
					html += '</div>';
				html += '</div>';
				//list icons
				html += $('#wp-data-icon-schedule').html();
			html += '</td>';

			html += '<td class="delete text-center">';  //column 3
				html += '<div class="del-tooltip">';
					html += '<a href="#" class="remove-row"><span>─</span></a>';
					html += '<div class="tooltip">';
						html += '<div class="wrap">Are you sure?';
							html += '<div id="d-yes"><a href="#" class="yes">Yes</a></div>';
							html +='<div id="d-no"><a href="#" class="no">Cancle</a></div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';
				/*html += '<span class="toggle_down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>';
				html += '<span class="toggle_up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>';*/
			html += '</td>';
		html += '</tr>';
		$('#frm-schedule tbody').append(html);
		//ckeditor("add-sch-brief-"+number_item);
		ckeditor("add-sch-content-"+number_item);
		ckeditor("add-sch-notes-"+number_item);
	});


	//delde row in table(row add)
    $('table').on('click', 'tr.add a.remove-row', function(){
   		$(this).addClass('active');
		$(this).parents('td.delete').find('.tooltip').addClass('active');
		$(this).parents('td.delete').find('#d-no').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.no'), function(){
			$(this).parents('.tooltip').removeClass('active');
			$(this).find('a.remove-row').removeClass('active');
			return false;
		});
		$(this).parents('td.delete').find('#d-yes').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.yes'), function(e){
			e.preventDefault();
			//change number item each tr
			var number_item = '';
			var itemTemp = $(this).closest('tbody'); 
			numberParent = $(this).parents('tr').length; 

			if(numberParent === 3){ //if have menu parent (it's lv = 3)
				number_item += ($(this).parents('tr').eq(2).index() + 1) + '.'; 
				number_item += ($(this).parents('tr').eq(1).index() + 1) + '.'; 
			}
			else if(numberParent === 2){ //if have menu parent (it's lv = 2)
				number_item += ($(this).parents('tr').eq(1).index() + 1) + '.';
			}
			
			$(this).parents('tr').eq(0).fadeOut();
			$(this).parents('tr').eq(0).remove(); 
			var recount = 0; 
			itemTemp.find('> tr').each(function(){
				recount++;
				$(this).find('> td:first-child').text(number_item + recount); //replace number for each tr same level

				//replace number items child 
				if($(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').length && $(this).find('> td:nth-child(2) tbody').eq(1).find('> tr').length ){ //if it's lv 1
					$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){ // each item have 3 level
						var child = recount + '.' + parseInt($(this).eq(0).index() + 1) ;
						$(this).find('> td:first-child').text(child);
						$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
							var grand = child + '.' + parseInt($(this).index() + 1);
							$(this).find('> td:first-child').text(grand);
						});
					}); 
				}
				else if($(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').length  && !$(this).find('> td:nth-child(2) tbody').find('> tr').eq(1).length ){ //if it's lv 2
					$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){ // each item have 2 level
						var child = recount + '.' + parseInt($(this).eq(0).index() + 1) ;
						$(this).find('> td:first-child').text(child);
					}); 
				}
			}); 
			return false;
		});	
		return false;
    });

    $('table').on('click', 'tr.edit a.remove-row', function(e){ 
    	e.preventDefault();
    	$(this).addClass('active');
		$(this).parents('td.delete').find('.tooltip').addClass('active');
		$(this).parents('td.delete').find('.no').click(function(){
			$(this).parents('.tooltip').removeClass('active');
			$(this).find('a.remove-row').removeClass('active');
			return false;
		});
		//call action remove row table if have
		$(this).closest('td.delete').find('.yes').click(function(e){
			e.preventDefault();
			var link = $(this).attr('href');
			var _token = $('input[name=_token]').val();
			var id = $(this).closest('tr').attr('data-id');
			var temp = $(this).closest('tr');
			var number_item = '';
			var itemTemp = $(this).closest('tbody'); 
			numberParent = $(this).parents('tr').length; 

			if(numberParent === 3){ //if have menu parent (it's lv = 3)
				number_item += ($(this).parents('tr').eq(2).index() + 1) + '.'; 
				number_item += ($(this).parents('tr').eq(1).index() + 1) + '.'; 
			}
			else if(numberParent === 2){ //if have menu parent (it's lv = 2)
				number_item += ($(this).parents('tr').eq(1).index() + 1) + '.';
			}
			if(link != '#'){
				$.ajax({
					type:'POST',            
					url: link,
					cache: false,
					data:{
						'_token': _token,
						'id': id
					},
				}).done(function(data) {
					if(data=="success"){				       					       	
						temp.remove();	
						var recount = 0; 
						itemTemp.find('> tr').each(function(){
							recount++;
							$(this).find('> td:first-child').text(number_item + recount); //replace number for each tr same level

							//replace number items child 
							if($(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').length && $(this).find('> td:nth-child(2) tbody').eq(1).find('> tr').length ){ //if it's lv 1
								$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){ // each item have 3 level
									var child = recount + '.' + parseInt($(this).eq(0).index() + 1) ;
									$(this).find('> td:first-child').text(child);
									$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
										var grand = child + '.' + parseInt($(this).index() + 1);
										$(this).find('> td:first-child').text(grand);
									});
								}); 
							}
							else if($(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').length  && !$(this).find('> td:nth-child(2) tbody').find('> tr').eq(1).length ){ //if it's lv 2
								$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){ // each item have 2 level
									var child = recount + '.' + parseInt($(this).eq(0).index() + 1) ;
									$(this).find('> td:first-child').text(child);
								}); 
							}
						}); 
					}	           		
				});
			}
			return false;
		});
    });

    
    /*
    * Country not have tour style
    */
   	//Add
    $('#country-cat .add-row').click(function(e){
    	e.preventDefault();
   		var html = $('#country-cat #frm-add').html();
   		$('#country-cat form #frm-country-cat').append(html);
   		$('#country-cat #frm-country-cat .add-item').removeClass('hide');
   		$('#country-cat button.submit').removeClass('hide');
    });
    //remove add item row
    $('#frm-country-cat').on('click', '.add-item .remove-row', function(e){ 
    	e.preventDefault();
    	$(this).parents('.add-item').remove();
    });
    $('#frm-country-cat').on('click', '.edit-item .remove-row', function(e){ 
    	e.preventDefault();
    	var href = $(this).attr("href");
    	(new PNotify({
		    title: 'Delete',
		    text: 'Are you sure?',
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
    });

    //edit slug
  	$('#frm-slug .edit-slug').click(function(e){
  		e.preventDefault();
  		$(this).addClass('hide');
  		$('#frm-slug span').addClass('hide');
  		$('#frm-slug input').removeClass('hide');
  		$('#frm-slug .save-slug').removeClass('hide');
  		$('#frm-slug .cancel').removeClass('hide');
  	});

  	//cancel edit slug
  	$('#frm-slug .cancel').click(function(e){
  		e.preventDefault();
  		var value = $('#frm-slug span').text();
  		$('#frm-slug .save-slug').addClass('hide');   
		$('#frm-slug .cancel').addClass('hide');   
		$('#frm-slug input').val(value).addClass('hide');  
		$('#frm-slug span').removeClass('hide');					
		$('#frm-slug .edit-slug').removeClass('hide');	
  	});

  	//change edit slug
  	$('#frm-slug .save-slug').click(function(e){
  		e.preventDefault();
  		var value =  $('#frm-slug input').val();
		$('#frm-slug .save-slug').addClass('hide');   
		$('#frm-slug .cancel').addClass('hide');   
		$('#frm-slug input').addClass('hide');  
		$('#frm-slug span').text(value).removeClass('hide');					
		$('#frm-slug .edit-slug').removeClass('hide');	
  	});

  	//fixed group group-fixed sidebar when scroll
    if($('.sidebar .group-fixed').length){
        var height_topHeader = $('header .top').outerHeight() + $('menu-top').outerHeight();
        
        $(window).scroll(function(){ 
            var height_window = $(window).scrollTop(); 
            var width_sidebar = $('.sidebar .gr-not-fixed').outerWidth();
            var distance_sidebar = $('.sidebar').offset().top;
            //var height_sidebar = $('#sidebar').outerHeight() - $('#sidebar .group-fixed').outerHeight();
            var height_sidebar = $('.sidebar .gr-not-fixed').outerHeight(); 
            if( height_window > ( height_sidebar + distance_sidebar)){ 
                $('.sidebar .group-fixed').addClass('fixed').css('max-width', width_sidebar);
            } 
            else{
                $('.sidebar .group-fixed').removeClass('fixed');
            }
        });
    }

    //count characters when input metavalue
    $('.form-group input, .form-group textarea').on('input', function(){
    	$(this).parents('.form-group').find('.count-characters').text('( ' + $(this).val().length + ' characters )');
    });

    /*
    * Add table content in admin page
    */
   	if($('#frm-tb-content').length){
	   	$('#frm-tb-content .add-row').click(function(event){
	   		//var number_item = $('#frm-tb-content > table > tbody > tr').length + 1; 
	   		frmTbContent = $(this).closest('#frm-tb-content');
	   		var number_item = frmTbContent.find(' > table > tbody > tr').length + 1; 
	   		var id; 
	   		var list_city = $('#frm-list-city').html();
	   		var list_style = $('#frm-list-style').html();
	   		var list_tour = $('#frm-list-tour').html();
	   		//console.log(list_city);
	   		//check exist id textarea
	   		do{
	   			id = makeid();
	   		}while(!$('#' + id))

	   		if($('#frm-tb-content').hasClass('has-duration')) {
				var html = tableContent(event, number_item, id, number_item , 1, '2', list_city, list_style, list_tour);
			}else var html = tableContent(event, number_item, id, number_item); //lv1 number_item == position number
			frmTbContent.find(' > table > tbody').append(html);		
			//ckeditor("add-sch-brief-"+number_item);
			/*ckeditor("tb-content-"+ number_item);*/
			ckeditor(id);
			$('#frm-list-city select.form-control').select2();
			$('#frm-list-style select.form-control').select2();
			$('#frm-list-tour select.form-control').select2();
	   	});
	   	$("body").on("select2:select","#frm-list-city select.form-control", function (evt) {
		    var elm = evt.params.data.element;
		    $elm = $(elm);
		    $t = $(this);
		    $t.append($elm);
		    $t.trigger('change.select2');
		  });
	   	$('#frm-tb-content').on('click', '.add-child', function(e){
	   		var number_item = ''; 
	   		var id; 
	   		var position;
	   		//check exist id textarea
	   		do{
	   			id = makeid();
	   		}while(!$('#' + id))
	   		var level = 2;
			var html = '';

			if($(this).parents('tbody').eq(0).length && $(this).parents('tbody').eq(1).length){
				level = 3;
				number_item += ($(this).parents('tr').eq(1).index() + 1) + '.'; 
				number_item += ($(this).parents('tr').eq(0).index() + 1) + '.';
			}
			else{
				number_item += ($(this).parents('tr').eq(0).index() + 1) + '.';
			}
			number_item += parseInt(parseInt($(this).closest('.field-row').find('> .wrap-child > table > tbody > tr').length) + 1);
			position = 	parseInt(parseInt($(this).closest('.field-row').find('> .wrap-child > table > tbody > tr').length) + 1); 

			html += tableContent(e, number_item, id, position, level);
			$(this).closest('.field-row').find(' > .wrap-child > table > tbody').append(html); 
			ckeditor(id);
	   	});

	   	$(".sortable" ).sortable({
	   		start: function (event, ui) 
	        {
	            var id_textarea = ui.item.find(".tb-content textarea").attr("id");
	            //var id_textarea = ui.item.find("textarea").attr("id");
	            CKEDITOR.instances[id_textarea].destroy();
	        } ,
	        stop: function (event, ui) 
	        {
	            var id_textarea = ui.item.find(".tb-content textarea").attr("id");
	            //var id_textarea = ui.item.find("textarea").attr("id");
	            CKEDITOR.replace(id_textarea);
	        },   			
		    update: function(e, ui) { 
		    	var tbParent = ui.item.closest('.sortable'); 
		    	//
		        var count = 0;
		        var route_count = 0;
		        var routes = new Array();
		        //$(".sortable > tr").each(function(){
		        tbParent.find(" > tr").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-value"),						
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;

					//rewrite number position item
					var number_item = count;
					$(this).find('> td:first-child').text(count); //item lv 1
					$(this).find('> td:nth-child(2)').find('tbody').eq(0).find('> tr').each(function(){
						var child = number_item + '.' + parseInt($(this).index() + 1) ; 
						$(this).find('> td:first-child').text(child);
						$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
							var grand = child + '.' + parseInt($(this).index() + 1); 
							$(this).find('> td:first-child').text(grand);
						});
					});

		        });		        	
		    }     
		});

		//function add table content
		function tableContent(event, number_item, id, position, level = 1, image = null , list_city , list_style, list_tour){  
			var point = $(event.target);
			var type = 'multi_level';

			var html = '';
			var array = new Array;

			if(point.closest('.just-level-1').html() != undefined)
				type = 'single_level';

			html += '<tr class="add '+image+'" data-position="'+ position +'" >';
				html += '<td>'+number_item+'</td>'; //column 1
				html += '<td>'; //column 2
					html += '<div class="tb-title field-row">';
						html += '<div class="row-left">';
							html += '<label>Title</label>';
						html += '</div>';
						html += '<div class="row-right">';
							html += '<input type="text" name="sch-title-'+ number_item +'" class="form-control" />';
						html += '</div>';
					html += '</div>';
					if(image != null) {
						if(point.closest('.has-thumb').html() != undefined){
							var link_loadMedia = point.closest('.has-thumb').attr('data-load-media');
							html += ` 
								<div class="tb-image field-row">
									<div class="row-left">
										<label>Image</label>
									</div>
									<div class="row-right">
										<div id="frm-image-`+ id +`" class="desc img-upload">							
											<div class="image">
												<a href="`+ link_loadMedia +`" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
												<img src="`+ location.protocol + "//" + location.host +`/image/noimage.png/150/150" alt="image" />
												<input type="hidden" class="thumb-media" value="" />
											</div>
										</div>
									</div>
								</div>
							`;
						}
					}
					if(list_city) {
						html += '<div id="frm-list-city" class="field-row">' + list_city + '</div>';
					}
					if(list_style) {
						html += '<div id="frm-list-style" class="field-row">' + list_style + '</div>';
					}
					if(list_tour) {
						html += '<div id="frm-list-tour" class="field-row">' + list_tour + '</div>';
					}
					//if have thumb 
					/*if(point.closest('.has-thumb').html() != undefined){
						var link_loadMedia = point.closest('.has-thumb').attr('data-load-media');
						html += ` 
							<div class="tb-image field-row">
								<div class="row-left">
									<label>Image</label>
								</div>
								<div class="row-right">
									<div id="frm-image-`+ id +`" class="desc img-upload">							
										<div class="image">
											<a href="`+ link_loadMedia +`" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
											<img src="`+ location.protocol + "//" + location.host +`/image/noimage.png/150/150" alt="image" />
											<input type="hidden" class="thumb-media" value="" />
										</div>
									</div>
								</div>
							</div>
						`;
					}*/
					
					//if have thumb 
					if(point.closest('.has-map').html() != undefined){
						var link_loadMedia = point.closest('.has-thumb').attr('data-load-media');
							html += ` 
									<div class="tb-map field-row">
										<div class="row-left">
											<label>Map</label>
											<p>Note: Add Zoom Value</p>
										</div>
										<div class="row-right">
											<textarea name="tb-map-`+ number_item +`" class="tb-map form-control" ></textarea>
										</div>
									</div>
								`;
					}

					html += '<div class="tb-content field-row">';
						html += '<div class="row-left">';
							html += '<label>Content</label>';
						html += '</div>';
						html += '<div class="row-right">';
							html += '<textarea name="tb-content-'+ number_item +'" id="'+ id +'" class="tb-content" ></textarea>';
						html += '</div>';
					html += '</div>';

					//add child btn
					if(level < 3 && type == 'multi_level'){
						html += '<div class="tb-child field-row">';
							html += '<div class="row-left">';
								html += '<label>Children (level '+ parseInt(level + 1) +')</label>';
							html += '</div>';
							
								html += '<div class="wrap-child">';
									html += '<table class="field block-style">';
										html += '<tbody class="sortable-lv-'+ parseInt(level + 1) +'">';
										html += '</tbody>';
									html += '</table>';
								html += '</div>';
							
							html += '<div class="row-right text-right">';
								html += '<a href="javascript:void(0)" class="btn add-child">Add child</a>';
							html += '</div>';
						html += '</div>';
					}
				html += '</td>';

				html += '<td class="delete text-center">';  //column 3
					html += '<div class="del-tooltip">';
						html += '<a href="#" class="remove-row"><span>─</span></a>';
						html += '<div class="tooltip">';
							html += '<div class="wrap">Are you sure?';
								html += '<div id="d-yes"><a href="#" class="yes">Yes</a></div>';
								html +='<div id="d-no"><a href="#" class="no">Cancle</a></div>';
							html += '</div>';
						html += '</div>';
					html += '</div>';
				html += '</td>';
			html += '</tr>';
			
			$(".sortable-lv-"+level ).sortable({
		   		start: function (event, ui) 
		        {
		            array = new Array;
		            ui.item.find("textarea").each(function(){
		            	var name_child = $(this).attr("id");
		            	array.push(name_child);
		            	CKEDITOR.instances[name_child].destroy();
		            });
		        } ,
		        stop: function (event, ui) 
		        {
		            if(array.length){
		            	for(var i=0; i<array.length; i++){
		            		CKEDITOR.replace(array[i]);
		            	}
		            }
		        },   			
			    update: function(e, ui) {
			        var count = 0;
			        var route_count = 0;
			        var routes = new Array();
			        var number_item = parseInt($(this).parents('tr').eq(0).index()) + 1; 
			        $(".sortable-lv-"+level+ " tr").each(function(){
			        	count = count + 1;
			        	$(this).attr("data-position",count);
			        	
			        	routes[route_count] = {
							'id' : $(this).attr("data-value"),						
							'position' : $(this).attr("data-position")
						}
						route_count = route_count + 1;

										
			        });	
			        //rewrite number position item
					if(level === 2){ //if move group level 2, rewrite list the same level(in parent) and rewrite list child level 3 of it
						$(this).closest('tbody').find('> tr').each(function(){ 
							var child = number_item + '.' + parseInt($(this).index() + 1) ;
							$(this).find('> td:first-child').text(child);
							$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
								var grand = child + '.' + parseInt($(this).index() + 1);
								$(this).find('> td:first-child').text(grand);
							});
						}); 
					}
					else if(level === 3){ 
						number_item = parseInt($(this).parents('tr').eq(1).index()) + 1;
						number_item += '.' + parseInt($(this).parents('tr').eq(0).index() + 1);
						$(this).closest('tbody').find('> tr').each(function(){
							var child = number_item + '.' + parseInt($(this).index() + 1); 
							$(this).find('> td:first-child').text(child);
						});
					}		        	
			    }     
			});
			return html;
		}
   	}

   	$(".sortable-lv-2" ).sortable({
   		start: function (event, ui) 
        {
            array = new Array;
            level = 2;
            ui.item.find("textarea").each(function(){
            	var name_child = $(this).attr("id");
            	array.push(name_child);
            	CKEDITOR.instances[name_child].destroy();
            });
        } ,
        stop: function (event, ui) 
        {
            if(array.length){
            	for(var i=0; i<array.length; i++){
            		CKEDITOR.replace(array[i]);
            	}
            }
        },   			
	    update: function(e, ui) {
	        var count = 0;
	        var route_count = 0;
	        var routes = new Array();
	        var number_item = parseInt($(this).parents('tr').eq(0).index()) + 1; 
	        $(".sortable-lv-"+level+ " tr").each(function(){
	        	count = count + 1;
	        	$(this).attr("data-position",count);
	        	
	        	routes[route_count] = {
					'id' : $(this).attr("data-value"),						
					'position' : $(this).attr("data-position")
				}
				route_count = route_count + 1;

								
	        });	
	        //rewrite number position item
			if(level === 2){ //if move group level 2, rewrite list the same level(in parent) and rewrite list child level 3 of it
				$(this).closest('tbody').find('> tr').each(function(){ 
					var child = number_item + '.' + parseInt($(this).index() + 1) ;
					$(this).find('> td:first-child').text(child);
					$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
						var grand = child + '.' + parseInt($(this).index() + 1);
						$(this).find('> td:first-child').text(grand);
					});
				}); 
			}
			else if(level === 3){ 
				number_item = parseInt($(this).parents('tr').eq(1).index()) + 1;
				number_item += '.' + parseInt($(this).parents('tr').eq(0).index() + 1);
				$(this).closest('tbody').find('> tr').each(function(){
					var child = number_item + '.' + parseInt($(this).index() + 1); 
					$(this).find('> td:first-child').text(child);
				});
			}		        	
	    }     
   	});

   	$(".sortable-lv-3" ).sortable({
   		start: function (event, ui) 
        {
            array = new Array;
            level = 3;
            ui.item.find("textarea").each(function(){
            	var name_child = $(this).attr("id");
            	array.push(name_child);
            	CKEDITOR.instances[name_child].destroy();
            });
        } ,
        stop: function (event, ui) 
        {
            if(array.length){
            	for(var i=0; i<array.length; i++){
            		CKEDITOR.replace(array[i]);
            	}
            }
        },   			
	    update: function(e, ui) {
	        var count = 0;
	        var route_count = 0;
	        var routes = new Array();
	        var number_item = parseInt($(this).parents('tr').eq(0).index()) + 1; 
	        $(".sortable-lv-"+level+ " tr").each(function(){
	        	count = count + 1;
	        	$(this).attr("data-position",count);
	        	
	        	routes[route_count] = {
					'id' : $(this).attr("data-value"),						
					'position' : $(this).attr("data-position")
				}
				route_count = route_count + 1;

								
	        });	
	        //rewrite number position item
			if(level === 2){ //if move group level 2, rewrite list the same level(in parent) and rewrite list child level 3 of it
				$(this).closest('tbody').find('> tr').each(function(){ 
					var child = number_item + '.' + parseInt($(this).index() + 1) ;
					$(this).find('> td:first-child').text(child);
					$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
						var grand = child + '.' + parseInt($(this).index() + 1);
						$(this).find('> td:first-child').text(grand);
					});
				}); 
			}
			else if(level === 3){ 
				number_item = parseInt($(this).parents('tr').eq(1).index()) + 1;
				number_item += '.' + parseInt($(this).parents('tr').eq(0).index() + 1);
				$(this).closest('tbody').find('> tr').each(function(){
					var child = number_item + '.' + parseInt($(this).index() + 1); 
					$(this).find('> td:first-child').text(child);
				});
			}		        	
	    }     
   	});



   	/*
   	Hotels
   	 */

   	$('#frm-nearby .add-row').click(function(e){
   		e.preventDefault();
   		var number_item = $('#frm-nearby table tbody tr').length + 1;
   		var data = $('#frm-nearby .data-box').html();
   		var html = '';
   		html += '<tr class="add" data-position="'+ number_item +'">';
   			html += '<td>'+ number_item +'</td>';
   			html += '<td>'+ data +'</td>';
   			html += '<td class="delete text-center">';  //column 3
				html += '<div class="del-tooltip">';
					html += '<a href="#" class="remove-row"><span>─</span></a>';
					html += '<div class="tooltip">';
						html += '<div class="wrap">Are you sure?';
							html += '<div id="d-yes"><a href="#" class="yes">Yes</a></div>';
							html +='<div id="d-no"><a href="#" class="no">Cancle</a></div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';
			html += '</td>';
   		html += '</tr>';
   		
   		$('#frm-nearby tbody').append(html);
   		
   		$('#frm-nearby tbody select.select2-append').select2();
   		$('#frm-nearby tbody select.select2-append').next().next().remove();
 		
 		/*TEST*/
 		/*var sub_select2 = $('#frm-nearby .select2-container').closest('.row-right').html(); 
 		$('#frm-nearby tbody tr.add .attraction .row-right').html(sub_select2);*/
   	});

   	
   	if($('.table-sortable').length){ 
   		$(".table-sortable .sortable" ).sortable({
	   		start: function (event, ui) 
	        {
	        	if(ui.item.find("textarea").length){
	        		var id_textarea = ui.item.find("textarea").attr("id");
	            	CKEDITOR.instances[id_textarea].destroy();
	        	}
	        } ,
	        stop: function (event, ui) 
	        {
	        	if(ui.item.find("textarea").length){
		            var id_textarea = ui.item.find("textarea").attr("id");
		            CKEDITOR.replace(id_textarea);
		        }
	        },   			
		    update: function(e, ui) {
		        var count = 0;
		        var route_count = 0;
		        var routes = new Array();
		        $(".sortable > tr").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-value"),						
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;

					//rewrite number position item
					var number_item = count;
					$(this).find('> td:first-child').text(count); //item lv 1
					$(this).find('> td:nth-child(2)').find('tbody').eq(0).find('> tr').each(function(){
						var child = number_item + '.' + parseInt($(this).index() + 1) ; 
						$(this).find('> td:first-child').text(child);
						$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
							var grand = child + '.' + parseInt($(this).index() + 1); 
							$(this).find('> td:first-child').text(grand);
						});
					});
		        });		        	
		    }     
		});
   	}

   	/*
   	* add row favoutite book of blogger
   	*/
  	/*if($('#frm-favourite-books').length){
  		$('#frm-favourite-books .add-row').click(function(e){
  			e.preventDefault();
  			var html = '';
  			var number_item = $('#frm-favourite-books tbody tr').length + 1;
  			html += '<tr class="add">';
				html += '<td>'+number_item+'</td>'; //column 1
				html += '<td>'; //column 2
					html += '<div class="tb-title field-row">';
						html += '<div class="row-left">';
							html += '<label>Title</label>';
						html += '</div>';
						html += '<div class="row-right">';
							html += '<input name="title-'+ number_item +'" class="form-control" />';
						html += '</div>';
					html += '</div>';

					html += '<div class="tb-link field-row">';
						html += '<div class="row-left">';
							html += '<label>Link</label>';
						html += '</div>';
						html += '<div class="row-right">';
							html += '<input name="link-'+ number_item +'" class="form-control" />';
						html += '</div>';
					html += '</div>';
				html += '</td>';

				html += '<td class="delete text-center">';  //column 3
					html += '<div class="del-tooltip">';
						html += '<a href="#" class="remove-row"><span>─</span></a>';
						html += '<div class="tooltip">';
							html += '<div class="wrap">Are you sure?';
								html += '<div id="d-yes"><a href="#" class="yes">Yes</a></div>';
								html +='<div id="d-no"><a href="#" class="no">Cancle</a></div>';
							html += '</div>';
						html += '</div>';
					html += '</div>';
				html += '</td>';
			html += '</tr>';

			$('#frm-favourite-books tbody').append(html);
  		});
  	}*/

  	//click to copy
  	$('.click-to-copy a').click(function(e){
  		e.preventDefault();
  		url = $(this).attr('href');

  		var $temp = $("<input>");
	  	$("body").append($temp);
	  	$temp.val(url).select();
	  	document.execCommand("copy");
	  	$temp.remove();

	  	$(this).closest('.tooltip').find('.tooltiptext').text('Copied');
  	});
  	$('.click-to-copy a').mouseleave(function(){
  		$(this).closest('.tooltip').find('.tooltiptext').text('Click to copy URL');
  	});


  	/*****************************************
  	* Events in banner by country
  	* 1. on select change post type
  	* 2. update banner post by country
  	******************************************/
  	/*on select change post type*/
  	$('#banners').on('change', 'select#chose-post-type', function(){
  		var post_type = $(this).val();
  		var link = $(this).attr('data-action');
  		$('#overlay').show();
  		$('.loading').show();
		$.ajax({
            url: link,
            type: "GET",
            async: true,
            data : {
                'post_type': post_type
            },
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) { 
                $('#overlay').hide();
	  			$('.loading').hide();
				if(data.msg=="success"){ 	
					$('#banners .group-country').html(data.html);
				}
            }
        });
  	});

  	/*update banner*/
  	$('#banners form').submit(function(e){
  		var link = $(this).attr('action');
  		var data_send = $(this).serialize()
  		$('#overlay').show();
   		$('.loading').show();
		$.ajax({
			type:'POST',            
			url: link,
			cache: false,
			data: data_send,
		}).done(function(data) { 
			$('#overlay').hide();
	  		$('.loading').hide();
			if(data=="success"){ 
				new PNotify({
					title: 'Successfully',
				    text: 'Successfully saved',
					type: 'success',
					hide: true,
					delay: 2000,
				});						
			}else{
				new PNotify({
					title: 'Error',
					text: 'The system is busy. Please try again. ',						    
					hide: true,
					delay: 2000,
				});
			}	           		
		});
  		return false;
  	});
  	/*** End Event in banner by country***/
  		
  	/*
  	* sortable table
  	*/
  	if($('.table .sortable').length){
  		$(".table .sortable" ).sortable({ 			
		    update: function(e, ui) { 
		        var count = 0;
		        var route_count = 0;
		        var routes = new Array();
		        var link = $(this).attr('data-action');
		        var _token = $("form input[name='_token']").val();
		        $(".sortable > tr").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-id"),						
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;

					//rewrite number position item
					var number_item = count;
					$(this).find('> td.stt').text(count); 
		        });		 

		        if(link != undefined && link != ''){ 
		        	$.ajax({
		               	type:'POST',            
					    url:link,
					    cache: false,
			            data:{
			                '_token': _token,
							'routes': JSON.stringify(routes)
			            },
		           	}).done(function(data) {
		           		if(data=="success"){
		           			new PNotify({
							    title: 'Successfully',
							    text: 'Change position successfully.',
							    type: 'success',
							    hide: true,
							    delay: 2000,
							});						
		           		}else{
		           			new PNotify({
							    title: 'Error',
							    text: 'The system is busy. Please try later.',						    
							    hide: true,
							    delay: 2000,
							});
		           		}	           		
		           });
		        }   	
		    }     
		});
  	}

	/*
  	* sortable table days
  	*/
  	if($('.table-days .sortable').length){
  		function unloadEditors() {
		    $('textarea.sch-content:hidden,textarea.sch-notes:hidden').each(function(){
		        var tagId = $(this).attr('id');
		        CKEDITOR.instances[ tagId ].destroy();
		    });
		}
		function loadEditors() {
		    $('textarea.sch-content,textarea.sch-notes').each(function(){
		        var tagId = $(this).attr('id');
		        CKEDITOR.replace( tagId );
		    });
		}
  		$(".table-days .sortable" ).sortable({ 
  			revert: true,
  			start: function(event,ui){
		    	unloadEditors();
		  	},
		 	stop: function(event,ui){
		    	loadEditors();
		  	},
		    update: function(e, ui) { 
		        var count = 0;
		        var route_count = 0;
		        var routes = new Array();
		        var link = $(this).attr('data-action');
		        var _token = $("form input[name='_token']").val();
		        $(".sortable > tr").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-id"),						
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;

					//rewrite number position item
					var number_item = count;
					$(this).find('> td.stt').text(count); 
		        });		 

		        if(link != undefined && link != ''){ 
		        	$.ajax({
		               	type:'POST',            
					    url:link,
					    cache: false,
			            data:{
			                '_token': _token,
							'routes': JSON.stringify(routes)
			            },
		           	}).done(function(data) {
		           		if(data=="success"){
		           			new PNotify({
							    title: 'Successfully',
							    text: 'Change position successfully.',
							    type: 'success',
							    hide: true,
							    delay: 2000,
							});						
		           		}else{
		           			new PNotify({
							    title: 'Error',
							    text: 'The system is busy. Please try later.',						    
							    hide: true,
							    delay: 2000,
							});
		           		}	           		
		           });
		        }   	
		    }     
		});
  	}
  	/**
	 * frm-add-row
	 */
	$('.frm-add-row .add-row').click(function(e){
		e.preventDefault();
		let frm = $(this).closest('.frm-add-row');
		let group_field = frm.find('.group-row-add').html();
		let number = frm.find('table tbody tr').length + 1;
		let percent_field = 100 / (frm.find('.group-row-add .field-row').length); 
		let html = '';

		html += `<tr class="add" data-position="`+ number +`">
					<td>`+ number +`</td>
					<td><div class="gr-field">`+ group_field +`</div></td>
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
				</tr>`;
		frm.find('table tbody').append(html);
		frm.find('table tbody select.select2-append').select2();
   		frm.find('table tbody select.select2-append').next().next().remove();
   		//add width column-style
   		if(frm.find('table').hasClass('column-style'))
   			frm.find('table tbody .field-row').css('width', percent_field+'%');

   		//if has image
		if(frm.find('.group-row-add .img-upload').length){
			let number_img = frm.find('table .img-upload').length + 1;
			let id_name = frm.find('.group-row-add .img-upload').attr('data-id-name');
			frm.find('.group-row-add .img-upload').attr('id', id_name + '-' + number_img);
		}
	});

    $('table').on('click', 'tr a.remove-row', function(){
   		$(this).addClass('active');
		$(this).parents('td.delete').find('.tooltip').addClass('active');
		$(this).parents('td.delete').find('#d-no').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.no'), function(){
			$(this).parents('.tooltip').removeClass('active');
			$(this).find('a.remove-row').removeClass('active');
			return false;
		});
		$(this).parents('td.delete').find('#d-yes').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.yes'), function(e){
			e.preventDefault();
			//change number item each tr
			var number_item = '';
			var itemTemp = $(this).closest('tbody'); 
			numberParent = $(this).parents('tr').length; 
			
			if($(this).closest('tr').hasClass('edit')){ ;
				var id = $(this).closest('tr').attr('data-id');
				var str_delete = $(this).closest('.frm-add-row').find('input.str-delete').val(); 
				if(str_delete != ''){
					array_delete = str_delete.split(',');
				}else{
					array_delete = [];
				}
				array_delete.push(id); console.log(array_delete);
				$(this).closest('.frm-add-row').find('input.str-delete').val(array_delete.toString());
			}
			//$(this).parents('tr').eq(0).fadeOut();
			$(this).parents('tr').eq(0).remove(); 
			var recount = 0; 
			itemTemp.find('> tr').each(function(){
				recount++;
				$(this).find('> td:first-child').text(number_item + recount); //replace number for each tr same level
				$(this).attr('data-position', number_item + recount);
			}); 
			return false;
		});	
		return false;
    });


    $(".frm-add-row .sortable" ).sortable({
   		start: function (event, ui) 
        {
            var id_textarea = ui.item.find("textarea").attr("id");
            //CKEDITOR.instances[id_textarea].destroy();
        } ,
        stop: function (event, ui) 
        {
            var id_textarea = ui.item.find("textarea").attr("id");
            //CKEDITOR.replace(id_textarea);
        },   			
	    update: function(e, ui) { 
	    	var tbParent = ui.item.closest('.sortable'); 
	    	//
	        var count = 0;
	        var route_count = 0;
	        var routes = new Array();
	        //$(".sortable > tr").each(function(){
	        tbParent.find(" > tr").each(function(){
	        	count = count + 1;
	        	$(this).attr("data-position",count);
	        	routes[route_count] = {
					'id' : $(this).attr("data-value"),						
					'position' : $(this).attr("data-position")
				}
				route_count = route_count + 1;

				//rewrite number position item
				var number_item = count;
				$(this).find('> td:first-child').text(count); //item lv 1
				$(this).find('> td:nth-child(2)').find('tbody').eq(0).find('> tr').each(function(){
					var child = number_item + '.' + parseInt($(this).index() + 1) ; 
					$(this).find('> td:first-child').text(child);
					$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
						var grand = child + '.' + parseInt($(this).index() + 1); 
						$(this).find('> td:first-child').text(grand);
					});
				});

	        });		        	
	    }     
	});

});
//format currency
function formatCurrency(number, places, symbol, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 0;
    symbol = symbol !== undefined ? symbol : "đ";
    thousand = thousand || ".";
    decimal = decimal || ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "")+" "+symbol;
}
//convert to slug
function convertToSlug(str){
	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();

	// remove accents, swap ñ for n, etc
	var from = "àáäảâẫạặăẵèéëêệẹìịíïîòóöôộùúüûưủñçđ·/_,:;";
	var to   = "aaaaaaaaaaeeeeeeiiiiiooooouuuuuuncd------";

	for (var i=0, l=from.length ; i<l ; i++)
	{
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, '-') // collapse whitespace and replace by -
		.replace(/-+/g, '-'); // collapse dashes

	return str;
}
//validate email
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

//random id
function makeid(length = 4) {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < length; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

function init($elem) {
    $elem.select2({
        minimumResultsForSearch: -1,
        width: 'resolve'
    });   
}