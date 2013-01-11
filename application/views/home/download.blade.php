@layout('layouts.default')

@section('content')
	<div>Download Application "{{ $app->name }}"</div>
	@if ($app->info_version != '')
		<div><a href="itms-services://?action=download-manifest&amp;url={{ $app->manifest_url() }}">Tap Here to Install {{ $app->info_version != '' ? 'v.' . $app->info_version : '' }}</a></div>
	@else
		<div>Build something before...</div>
	@endif
@endsection
