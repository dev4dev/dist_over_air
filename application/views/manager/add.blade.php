@layout('layouts.default')

@section('content')
	<h2>Add New App</h2>
	@if (true)
		<p>{{ $error }}</p>
	@endif
	{{ Form::open('manager/add', 'post'); }}
	{{ Form::label('app_name', 'App Name'); }}
	{{ Form::text('app_name'); }}
	{{ Form::submit('Save'); }}
	{{ Form::close(); }}
@endsection