$(document ).ready(function(){	
	$('form.activity-form').submit(function(){ 
        /* update value in ckeditor */
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();

        /*add value frm add row*/
        if($('.frm-add-row').length){
            $('.frm-add-row').each(function(){
                var array_add = [];
                var array_edit = [];
                //tr.add
                $(this).find('tr.add').each(function(){ //each tr
                    var obj = {};
                    obj.position = $(this).attr('data-position');
                    $(this).find('.field-item').each(function(){ //each field name
                        var name = $(this).attr('data-name');
                        var value = $(this).val();
                        obj[name] = value;
                    });
                    array_add.push(obj);
                });
                if(array_add.length)
                    $(this).find('.json-add').val(JSON.stringify(array_add));

                //tr.edit
                $(this).find('tr.edit').each(function(){ //each tr
                    var obj = {};
                    obj.id = $(this).attr('data-id');
                    obj.position = $(this).attr('data-position');
                    $(this).find('.field-item').each(function(){ //each field name
                        var name = $(this).attr('data-name');
                        var value = $(this).val();
                        obj[name] = value;
                    });

                    array_edit.push(obj);
                });
                if(array_edit.length)
                    $(this).find('.json-edit').val(JSON.stringify(array_edit));

            });
        }

        //if have table content
        if($('div[id=frm-tb-content]').length){
            $('div[id=frm-tb-content]').each(function(){
                //set content in input hiden
                if($(this).find('.string-value').length){
                    var tableContent = new Array();

                    if($(this).hasClass('edit')){ 
                        $(this).find(' > table > tbody > tr').each(function(key){ 
                            var ob_lv1 = {};
                            var title_lv1 = $(this).find('> td:nth-child(2) > .tb-title input').val();
                            var id_content_lv1 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
                            var content_lv1 = CKEDITOR.instances[id_content_lv1].getData(); 
                            var position_lv1 = $(this).attr('data-position');
                            var action_lv1 = 'add'; 
                            var id_lv1 = $(this).attr('data-id'); 
                            if($(this).hasClass('edit')) action_lv1 = 'edit';
                            var arr_child_lv1 = new Array();
                            //get array child lv 2
                            if($(this).find('.sortable-lv-2 > tr').length){
                                $(this).find('.sortable-lv-2 > tr').each(function(){
                                    var ob_lv2 = {};
                                    var title_lv2 = $(this).find('> td:nth-child(2) > .tb-title input').val();
                                    var id_content_lv2 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
                                    var content_lv2 = CKEDITOR.instances[id_content_lv2].getData();
                                    var position_lv2 = $(this).attr('data-position');
                                    var action_lv2 = 'add'; 
                                    var id_lv2 = $(this).attr('data-id');
                                    if($(this).hasClass('edit')) action_lv2 = 'edit';
                                    var arr_child_lv2 = new Array(); 
                                    //get array child lv 3
                                    if($(this).find('.sortable-lv-3 > tr').length){
                                        $(this).find('.sortable-lv-3 > tr').each(function(){
                                            var ob_lv3 = {};
                                            var title_lv3 = $(this).find('> td:nth-child(2) > .tb-title input').val();
                                            var id_content_lv3 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
                                            var content_lv3 = CKEDITOR.instances[id_content_lv3].getData();
                                            var position_lv3 = $(this).attr('data-position');
                                            var action_lv3 = 'add'; 
                                            var id_lv3 = $(this).attr('data-id');
                                            if($(this).hasClass('edit')) action_lv3 = 'edit';
                                            if(id_lv3 !== undefined) ob_lv3.id = id_lv3;
                                            ob_lv3.title = title_lv3;
                                            ob_lv3.content = content_lv3;
                                            ob_lv3.position = position_lv3;
                                            ob_lv3.action = action_lv3;
                                            arr_child_lv2.push(ob_lv3);
                                        });
                                    }
                                    if(id_lv2 !== undefined) ob_lv2.id = id_lv2;
                                    ob_lv2.title = title_lv2;
                                    ob_lv2.content = content_lv2;
                                    ob_lv2.position = position_lv2;
                                    ob_lv2.action = action_lv2;
                                    ob_lv2.child = arr_child_lv2;
                                    arr_child_lv1.push(ob_lv2);
                                });
                            }
                            if(id_lv1 !== undefined) ob_lv1.id = id_lv1;
                            ob_lv1.title = title_lv1;
                            ob_lv1.content = content_lv1;
                            ob_lv1.position = position_lv1;
                            ob_lv1.action = action_lv1;
                            ob_lv1.child = arr_child_lv1;
                            tableContent.push(ob_lv1);
                        });
                    }
                    else{ 
                        $(this).find(' > table > tbody > tr').each(function(key){ 
                            var ob_lv1 = {};
                            var title_lv1 = $(this).find('> td:nth-child(2) > .tb-title input').val();
                            var id_content_lv1 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
                            var content_lv1 = CKEDITOR.instances[id_content_lv1].getData(); 
                            var position_lv1 = $(this).attr('data-position');
                            var arr_child_lv1 = new Array();
                            //get array child lv 2
                            if($(this).find('.sortable-lv-2 > tr').length){
                                $(this).find('.sortable-lv-2 > tr').each(function(){
                                    var ob_lv2 = {};
                                    var title_lv2 = $(this).find('> td:nth-child(2) > .tb-title input').val();
                                    var id_content_lv2 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
                                    var content_lv2 = CKEDITOR.instances[id_content_lv2].getData();
                                    var position_lv2 = $(this).attr('data-position');
                                    var arr_child_lv2 = new Array(); 
                                    //get array child lv 3
                                    if($(this).find('.sortable-lv-3 > tr').length){
                                        $(this).find('.sortable-lv-3 > tr').each(function(){
                                            var ob_lv3 = {};
                                            var title_lv3 = $(this).find('> td:nth-child(2) > .tb-title input').val();
                                            var id_content_lv3 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
                                            var content_lv3 = CKEDITOR.instances[id_content_lv3].getData();
                                            var position_lv3 = $(this).attr('data-position');
                                            ob_lv3.title = title_lv3;
                                            ob_lv3.content = content_lv3;
                                            ob_lv3.position = position_lv3;
                                            arr_child_lv2.push(ob_lv3);
                                        });
                                    }
                                    ob_lv2.title = title_lv2;
                                    ob_lv2.content = content_lv2;
                                    ob_lv2.position = position_lv2;
                                    ob_lv2.child = arr_child_lv2;
                                    arr_child_lv1.push(ob_lv2);
                                });
                            }
                            if($(this).closest('#frm-tb-content').hasClass('has-thumb'))
                                ob_lv1.image = $(this).find('input.thumb-media').val();
                            ob_lv1.title = title_lv1; 
                            if($(this).closest('#frm-tb-content').hasClass('has-map'))
                                ob_lv1.map = $(this).find('textarea.tb-map').val();
                            ob_lv1.content = content_lv1;
                            ob_lv1.position = position_lv1;

                            if($(this).closest('#frm-tb-content').hasClass('has-duration'))
                                ob_lv1.list_city = $(this).find('select[name="list_city[]"]').val();
                                ob_lv1.list_style = $(this).find('select[name="list_style[]"]').val();
                                ob_lv1.list_tour = $(this).find('select[name="list_tour[]"]').val();

                            if(!$(this).closest('#frm-tb-content').hasClass('just-level-1'))
                                ob_lv1.child = arr_child_lv1; 
                            tableContent.push(ob_lv1);
                        });
                    }

                    $(this).find('.string-value').val(JSON.stringify(tableContent));
                }

                //remove attribute name in input & textarea
                $(this).find('input[type=text]').removeAttr('name');
                $(this).find('textarea').removeAttr('name');
            });  
        }

        //frm-nearby in hotel (accommodation)
        if($('#frm-nearby').length){
            var nearby = new Array();
            if($('#frm-nearby tbody tr.add').length){
                $('#frm-nearby tbody tr.add').each(function(){
                    var ob = {};
                    ob.attraction = $(this).find('.attraction select').val();
                    ob.distance = $(this).find('.distance input').val();
                    ob.position = $(this).attr('data-position');
                    nearby.push(ob);
                }); 
                $('#frm-nearby input[name=list_add_nearby]').val(JSON.stringify(nearby));
            }
            if($('#frm-nearby tbody tr.edit').length){
                $('#frm-nearby tbody tr.edit').each(function(){
                    var ob = {};
                    ob.id = $(this).attr('data-id');
                    ob.attraction = $(this).find('.attraction select').val();
                    ob.distance = $(this).find('.distance input').val();
                    ob.position = $(this).attr('data-position');
                    nearby.push(ob);
                }); 
                 $('#frm-nearby input[name=list_edit_nearby]').val(JSON.stringify(nearby));
            }
        }

        //action to send ajax
		var link = $(this).attr('action'); 
		$('#overlay').show();
        $('.loading').show(); 
		$.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: $(this).serialize(),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            success: function (data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.error) {
                	var errors = data.error;
                	var i;
                	var error_count = 0;
	        		var html = '<ul>';
                	for(i = 0; i < errors.length; i++){
			            if(errors[i] != ""){
			                html +='<li>'+errors[i]+'</li>';
			                error_count += 1;
			            }
			        }
			        html += '</ul>';

			        if(error_count>0){ 
			            new PNotify({
			                title: 'Error ('+error_count+')',
			                text: html,
			                hide: true,
			                delay: 4000,
			            });
			        }
                }
                else{
                	new PNotify({
                        title: 'Successfully',
                        text: data.success,
                        type: 'success',
                        hide: true,
                        delay: 4000,
                    });
                    if(data.url){
                        setTimeout(function(){
                            window.location.href = data.url;
                        }, 1000);
                    }
                }
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
		return false;
	});

    $('form.activity-s-form').submit(function(e){ 
        e.preventDefault();
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            url: $(this).attr('action'),
            type: "GET",
            data: $(this).serialize(),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.html != undefined){
                    $('#tb-result').html(data.html);
                }

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
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
    });

    $('form.activity-s-form').on('click', '.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        var link = $(this).closest('form').attr('action');
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            url: link,
            type: "GET",
            data: $(this).closest('form').serialize()+'&page='+page,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.html != undefined){ 
                    $('#tb-result').html(data.html);
                }
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
    });

    $('form.frm-nvp').submit(function(e){ 
        e.preventDefault();
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.html != undefined){
                    $('#tb-result').html(data.html);
                }
                $(".table-days .sortable" ).sortable({           
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
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
    });

});