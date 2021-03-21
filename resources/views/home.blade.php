@extends('layouts.app')

@section('content')
	<div class="container m-auto max-w-5xl">
		<h1 class="mt-12 mb-8 text-3xl font-bold">Dashboard</h1>
		@if (session('status'))
			<div class="alert alert-success" role="alert">
				{{ session('status') }}
			</div>
		@endif
		Vous êtes bien connecté. 😉
	</div>
@endsection
