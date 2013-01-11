@layout('layouts.default')

@section('content')
	<h2>Applications</h2>
	@forelse ($apps as $app)
		<div>{{ HTML::link(URL::to_route('download', $app->slug), $app->name); }} ({{ $app->info_version != '' ? 'v' . $app->info_version : 'No builds' }})</div>
	@empty
		<div>...infinite emptiness...</div>
	@endforelse
@endsection
