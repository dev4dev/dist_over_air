@layout('layouts.default')

@section('content')
	<h1>Apps Manager</h1>
	{{ HTML::link('manager/add', 'Add New App') }}
	@foreach ($apps as $app)
		<div>[{{ $app->info_version != '' ? 'x' : '-' }}] {{ $app->name }} ({{ $app->guid }}) [{{ HTML::link($app->ipa_url(), 'download') }}] [{{ HTML::link('manager/delete/' . $app->id, 'delete', ['onclick' => 'return confirm("Delete app?");']); }}]</div>
	@endforeach
@endsection