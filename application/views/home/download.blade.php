@layout('layouts.default')

@section('content')
	<div>Download Application "{{ $app->name }}"</div>
	@if ($app->info_version != '')
		<div><a href="itms-services://?action=download-manifest&amp;url={{ $app->manifest_url() }}">Tap Here to Install {{ $app->info_version != '' ? 'v.' . $app->info_version : '' }}</a></div>
		<div><a href="{{ $app->ipa_url() }}">Tap Here to Download {{ $app->info_version > 0 ? 'v.' . $app->info_version : '' }}</div>
	@endif
@endsection
