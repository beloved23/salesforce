 @extends('layouts.master') @section('pagestyles') @endsection @section('content')

<!-- Page Content -->
<div class="page-wrapper">
	<div class="container-fluid">
		<!-- row -->
		<div class="row">
			<!-- Left sidebar -->
			<div class="col-md-12">
				<div class="white-box">
					<div class="row">
						<div class="col-lg-2 col-md-3  col-sm-4 col-xs-12 inbox-panel">
							<div>
								<a href="{{route('inbox.create')}}" class="btn btn-custom btn-block waves-effect waves-light">Compose</a>
								<div class="list-group mail-list m-t-20">
									<a href="{{route('inbox.index')}}" class="list-group-item">
										Inbox
										<span class="label label-rouded label-success pull-right">
											{{$inboxCount}}</span>
									</a>
									<a href="{{route('inbox.category','starred')}}" class="list-group-item">
										Starred
										<span class="label label-rouded label-default pull-right">
											{{$starredCount}}</span>
									</a>
									<a href="{{route('inbox.category','draft')}}" class="list-group-item">Draft
										<span class="label label-rouded label-warning pull-right">
											{{$draftedCount}}</span>
									</a>
									<a href="{{route('inbox.sent')}}" class="list-group-item">Sent Mail
										<span class="label label-rouded label-primary pull-right">{{$sentCount}}</span>
									</a>
									<a href="{{route('inbox.category','trash')}}" class="list-group-item">Trash
										<span class="label label-rouded label-danger pull-right">{{$trashedCount}}</span>
									</a>
								</div>
								<h3 class="panel-title m-t-40 m-b-0">Labels</h3>
								<hr class="m-t-5">
								<div class="list-group b-0 mail-list">
									<a href="#" class="list-group-item">
										<span class="fa fa-circle text-info m-r-10"></span>Work</a>
									<a href="#" class="list-group-item">
										<span class="fa fa-circle text-danger m-r-10">
										</span>Urgent</a>
									<a href="#" class="list-group-item">
										<span class="fa fa-circle text-warning m-r-10"></span>Family</a>
									<a href="#" class="list-group-item">
										<span class="fa fa-circle text-purple m-r-10">
										</span>Private</a>
								</div>
							</div>
						</div>
						<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
							<div class="media m-b-30 p-t-20">
								<h4 class="font-bold m-t-0">{{$messageItem->subject}}</h4>
								<hr>
								<a class="pull-left" href="#">
									<!--check whether to show recipient or sender profile picture -->
									@if($messageItem->sender_id==Auth::user()->id)
									<!--show sender picture -->
									@if(isset($messageItem->recipientProfile->profile_picture))
									<img class="media-object thumb-sm img-circle" src="{{asset('storage')}}/{{$messageItem->recipientProfile->profile_picture}}"
									 alt="img"> @else
									<img class="media-object thumb-sm img-circle" src="{{asset('storage/avatar.jpg')}}" alt=""> @endif @else
									<!--show recipient picture -->
									@if(isset($messageItem->senderProfile->profile_picture))
									<img class="media-object thumb-sm img-circle" src="{{asset('storage')}}/{{$messageItem->senderProfile->profile_picture}}"
									 alt="img"> @else
									<img class="media-object thumb-sm img-circle" src="{{asset('storage/avatar.jpg')}}" alt=""> @endif @endif
								</a>
								<div class="media-body">
									<span class="media-meta pull-right">{{$messageItem->format_time}}</span>
									<h4 class="text-danger m-0">
										@if($messageItem->sender_id==Auth::user()->id) {{$messageItem->recipientProfile->first_name.' '.$messageItem->recipientProfile->last_name}}
										@else {{$messageItem->senderProfile->first_name.' '.$messageItem->senderProfile->last_name}} @endif

									</h4>
									<small class="text-muted">From: {{$messageItem->sender->email}}</small>
									<small class="text-muted">To: {{$messageItem->recipient->email}}</small>
								</div>
							</div>
							<p>{{$messageItem->message}}</p>
							<hr>
							<h4>
								<i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments
								<span>
									({{count($messageItem->attachments)}})
								</span>
							</h4>
							<div class="row">
								<!--Iterate over attachments -->
								@foreach($messageItem->attachments as $attach)
								<div class="col-sm-2 col-xs-4">
									<a href="{{route('download.inbox.attachment',$attach->id)}}">
										@if(pathinfo($attach->attachment_filename, PATHINFO_EXTENSION)=="jpeg" || pathinfo($attach->attachment_filename, PATHINFO_EXTENSION)=="jpg"
										|| pathinfo($attach->attachment_filename, PATHINFO_EXTENSION)=="png" || pathinfo($attach->attachment_filename,
										PATHINFO_EXTENSION)=="gif")
										<img class="img-thumbnail img-responsive" alt="attachment" src="{{asset('storage')}}/{{$attach->attachment_filename}}"> @else
										<span>Attachment ({{$loop->index+1}}) </span>
										@endif

									</a>
								</div>
								@endforeach
							</div>
							<hr> @if($messageItem->replies()->count()>0)
							<div class="white-box chat-widget">
								<ul class="chat-list slimscroll" style="overflow: hidden;" tabindex="5005">
									@foreach($messageItem->replies as $reply) @if($reply->sender_id!=Auth::user()->id)
									<li>
										<div class="chat-image">
											<img alt="male" src="{{asset('storage')}}/{{$reply->senderProfile->profile_picture}}"> </div>
										<div class="chat-body">
											<div class="chat-text">
												<p>
													<span class="font-semibold">
														{{$reply->senderProfile->first_name.' '.$reply->senderProfile->last_name}}
													</span>
													{{$reply->reply}}
												</p>
											</div>
											<span>{{QuickTaskFacade::getTimeLine($reply->created_at)}}</span>
										</div>
									</li>
									@else
									<li class="odd">
										<div class="chat-body">
											<div class="chat-text">
												<p> {{$reply->reply}} </p>
											</div>
											<span>{{QuickTaskFacade::getTimeLine($reply->created_at)}}</span>
										</div>
									</li>
									@endif @endforeach
								</ul>
							</div>
							@endif
							<div class="b-all p-20">
								<p class="p-b-20">click here to
									<a data-toggle="modal" data-target="#responsive-modal" href="#">Reply</a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
		<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
		 style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Reply Message</h4>
					</div>
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data" action="{{route('inbox.reply',$id)}}">
							{{csrf_field()}}
							<div class="form-group">
								<label for="message-text" class="control-label">Attachments</label>
								<input name="file[]" type="file" multiple />
							</div>
							<div class="form-group">
								<label for="message-text" class="control-label">Message:</label>
								<textarea class="form-control" name="reply" id="message-text"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-danger waves-effect waves-light">Submit Reply</button>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</div>
@endsection @section('pagejs') @endsection