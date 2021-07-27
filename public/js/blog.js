$(document).ready(function(){
    $('.blog #sb-view .sb-title').on('click', function(event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $('.blog #sidebar #sb-view .desc').slideToggle(500);
    });
    $('.blog #sb-social .sb-title').on('click', function(event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $('.blog #sidebar #sb-social .desc').slideToggle(500);
    });
    $('.blog #sb-share .sb-title').on('click', function(event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $('.blog #sb-share .desc').slideToggle(500);
    });
    /**
     * .gr-filter blog
     */
    $('.gr-filter .box-item1 .title, .gr-filter .box-item1 input').on('click', function(event) {
        event.preventDefault();
        if ($(this).parent('.box-item1').hasClass('active')) {
            $(this).parent('.box-item1').removeClass('active');
            $(this).parent('.box-item1').find('ul.list-unstyled').slideUp('fast');
        }else {
            $('.gr-filter .box-item1').removeClass('active');
            $('.gr-filter .box-item1 ul.list-unstyled').slideUp('fast');
            $(this).parent('.box-item1').addClass('active');
            $(this).parent('.box-item1').find('ul.list-unstyled').slideDown('fast');
        }
    });
    $('.gr-filter .box-item1 ul li').on('click', function(event) {
        event.preventDefault();
        var parent = $(this).closest('.box-item1 ');
        if(parent.hasClass('single-value')){
            if($(this).hasClass('active')){
                parent.find('li').removeClass('active');
                parent.find('li input').prop('checked', false);
            }else{
                parent.find('li').removeClass('active');
                parent.find('li input').prop('checked', false);
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
        }
        else{ 
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('input').prop('checked', false);
            }
            else{ 
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
        }
    });
    $('.gr-filter .box-item1').on('click', function(event) {
        event.preventDefault();
        var title_current = $(this).attr("data-title");
        var parent = $(this);
        parent.find('li').on('click', function(event) {
            var check  = "";
            parent.find('li').each(function(index, el) {
                if ($(this).hasClass('active')) {
                    $text_vl = $(this).find('label').text();
                    //$(this).parents('.box-item1').find('.title').text($text_vl);
                    if(check == ""){
                        check = $text_vl;
                    }else{
                        check += ','+$text_vl;
                    }
                }
            });
            if(check != ""){
                $(this).parents('.box-item1').find('.title').text(check);
            }else{
                $(this).parents('.box-item1').find('.title').text(title_current);
            }
        });
    });
    $(document).mouseup(function(e) 
    {
        var container = $(".box-item1");
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            $('.gr-filter .box-item1 ul').slideUp('fast');
            $('.gr-filter .box-item1').removeClass('active');
        }
    });
    
    $(".page-blog #load-more .view-more").on("click", function(e) {
        e.preventDefault();
        var current = parseInt($('input[name="current"]').val()),
            total = parseInt($('input[name="total"]').val()),
            _token = $('input[name="_token"]').val(),
            action = $(this).attr('data-href');
            $('input[name="current"]').val(current+1);
            if (current < total) {
                current++;
                $.ajax({
                    type:'POST',            
                    url: action,
                    data:{
                        'current' : current,
                        'total' : total,
                        '_token': _token,
                    },
                    beforeSend: function( xhr ){
                        $('#overlay').show();
                        $('.loading').show();
                    },
                    success:function(data) {
                        if (data.check != 0) {
                            $('#overlay').hide();
                            $('.loading').hide();
                            $('.list-blog .row.wrap').append(data.html);
                            if (current >= total) 
                                $('#load-more').addClass('hidden');
                        }
                        else{
                           return false;
                        }
                    }
                });
            }
    });
    //input ajax
    $('.searchArticle input').on('input', function(){
        clearTimeout(this.delay);
        this.delay = setTimeout(function(){
            /* call ajax request here */
            var keyword = $(this).val(); 
            var link = $(this).attr('data-action');
            var _token = $('input[name=_token]').val();
            var parent = $(this).closest('.searchArticle');
            parent.addClass('loading');
            $.ajax({
                type:'POST',            
                url: link,
                cache: false,
                data:{
                    '_token' : _token,
                    'keyword': keyword,
                },
            }).done(function(data) {
                parent.removeClass('loading');
                if(data.msg == 'success'){
                    parent.find('ul').html(data.html);
                }
            });
        }.bind(this), 500);
    });
})
// highlight keyword search 
$(function() {
    $('#titleSearch, #id_nation').bind('keyup change', function(ev) {
        // pull in the new value
        var searchTerm = $(this).val();
        // remove any old highlighted terms
        $('.highlight-key').removeHighlight();
        // disable highlighting if empty
        if ( searchTerm ) {
            var terms = searchTerm.split(/\W+/);
           $.each(terms, function(_, term){
                  // highlight the new term
            term = term.trim();
            if(term != "")
               $('.highlight-key').highlight(term);
            });                          
        }
    });
});
jQuery.fn.highlight = function(pat) {
 function innerHighlight(node, pat) {
  var skip = 0;
  if (node.nodeType == 3) {
   var pos = node.data.toUpperCase().indexOf(pat);
   if (pos >= 0) {
    var spannode = document.createElement('span');
    spannode.className = 'highlight';
    var middlebit = node.splitText(pos);
    var endbit = middlebit.splitText(pat.length);
    var middleclone = middlebit.cloneNode(true);
    spannode.appendChild(middleclone);
    middlebit.parentNode.replaceChild(spannode, middlebit);
    skip = 1;
   }
  }
  else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
   for (var i = 0; i < node.childNodes.length; ++i) {
    i += innerHighlight(node.childNodes[i], pat);
   }
  }
  return skip;
 }
 return this.each(function() {
  innerHighlight(this, pat.toUpperCase());
 });
};
jQuery.fn.removeHighlight = function() {
 function newNormalize(node) {
    for (var i = 0, children = node.childNodes, nodeCount = children.length; i < nodeCount; i++) {
        var child = children[i];
        if (child.nodeType == 1) {
            newNormalize(child);
            continue;
        }
        if (child.nodeType != 3) { continue; }
        var next = child.nextSibling;
        if (next == null || next.nodeType != 3) { continue; }
        var combined_text = child.nodeValue + next.nodeValue;
        new_node = node.ownerDocument.createTextNode(combined_text);
        node.insertBefore(new_node, child);
        node.removeChild(child);
        node.removeChild(next);
        i--;
        nodeCount--;
    }
 }
 return this.find("span.highlight").each(function() {
    var thisParent = this.parentNode;
    thisParent.replaceChild(this.firstChild, this);
    newNormalize(thisParent);
 }).end();
};
// end highlight