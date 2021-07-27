<?php $key = isset($s)? $s : '';?>
<form class="frm-search" autocomplete="off" name="search" action="{{ route('searchBlog') }}" method="get">
    <a href="javascript:void(0)" class="search"></a>
    <div class="show-search">
        <input type="text" id="nameSearch" class="form-control" name="s" value="{{$key}}" placeholder="Enter your search" >
        <button type="submit" class="sb-search"></a>
    </div>
</form>