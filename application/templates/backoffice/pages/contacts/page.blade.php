@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-md-12 mb-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["title_contact_request_info"]) }} - <span class="badge badge-pill badge-info mb-1">{{ $contact->email }} {{ $contact->date }}</span></h5>
						<div class="dashboard-quick-post">
							<form id="view_contact">
								<label class="form-group has-float-label">
									<p class="form-control">{{ $contact->name }} {{ $contact->surname }}</p>
									<span>{{ ucfirst($translations["backoffice"]["contact_fill_name"]) }}</span>
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $contact->contact }}</p>
									<span>{{ ucfirst($translations["backoffice"]["contact_fill_phone"]) }}</span>
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $contact->email }}</p>
									<span>{{ ucfirst($translations["backoffice"]["contact_fill_email"]) }}</span>
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $contact->subject }}</p>
									<span>{{ ucfirst($translations["backoffice"]["contact_fill_subject"]) }}</span>
								</label>
								<label class="form-group has-float-label">
									<p class="form-control">{{ $contact->description }}</p>
									<span>{{ ucfirst($translations["backoffice"]["contact_fill_message"]) }}</span>
								</label>
							</form>
							<a href="/adm/contacts"><button  class= "btn btn-outline-dark btn-xs float-right mr-2 ml-2" >{{ ucfirst($translations["backoffice"]["contact_btn_back"]) }}</button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
