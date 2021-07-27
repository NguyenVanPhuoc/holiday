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
							<form action="{{ route('createMediaProfile') }}" class="dropzone dev-form" id="my-awesome-dropzone">
								{!! csrf_field() !!}							
							</form>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane active" id="media">
						<form action="{{ route('deleteLibraryProfile')}}" name="media" method="post">
							{!! csrf_field() !!}
							<div class="row">
								<div class="col-md-10">
									<div class="top">										
										<div id="media-find" class="search-input">
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" class="frm-input" placeholder="Tìm kiếm file">
										</div>
									</div>
									<div id="files" class="scrollbar-inner"></div>									
								</div>
								<div id="file-detail" class="col-md-2"></div>
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
</div>