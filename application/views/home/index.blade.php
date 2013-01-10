@layout('layouts.default')

@section('content')
	<h2>Applications</h2>
	@forelse ($apps as $app)
		<div>{{ HTML::link(URL::to_route('download', $app->guid), $app->name); }} ({{ $app->info_version > 0 ? 'v' . $app->info_version : 'No builds' }})</div>
	@empty

	@endforelse
@endsection