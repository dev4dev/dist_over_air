@layout('layouts.default')

@section('content')
	<h2>Applications</h2>
	@forelse ($apps as $app)
		<div>{{ $app->name }} [{{ HTML::link(URL::to_route('download', $app->guid), 'Download'); }}]</div>
	@empty

	@endforelse
@endsection