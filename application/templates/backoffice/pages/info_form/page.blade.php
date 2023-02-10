@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["info_form_tilte"]) }} - <span class="badge badge-pill badge-info mb-1">{{ $info_form->name }}</span></h5>
						<div class="dashboard-quick-post">
							<form id="view_contact">
								<label class="form-group has-float-label">
									<p class="form-control">{{ $info_form->name }}</p>									
									<span>{{ucfirst($translations["backoffice"]["booking_name"])}}</span> 
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $info_form->email }}</p>									
									<span>{{ucfirst($translations["backoffice"]["booking_email"])}}</span> 
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $info_form->phone }}</p>									
									<span>{{ucfirst($translations["backoffice"]["booking_phone"])}}</span>
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $info_form->custom_1 }}</p>									
									<span>{{ucfirst($translations["backoffice"]["booking_course"])}}</span>
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $info_form->description }}</p>									
									<span>{{ucfirst($translations["backoffice"]["booking_description"])}}</span>
								</label>
								<label class="form-group has-float-label">																
									<p class="form-control">{{ $info_form->custom_2 }}</p>		
									<span>{{ucfirst($translations["backoffice"]["booking_location"])}}</span>
								</label>
							</form>
							<a href="/adm/info-form"><button  class="btn btn-outline-primary btn-xs float-right mr-2 ml-2" >{{ ucfirst($translations["backoffice"]["contact_btn_back"]) }}</button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection