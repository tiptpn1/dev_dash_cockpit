@extends('layouts.app')

@section('content')
    <div class="iframe-container main-content">
        <iframe src="{{$linkiframe}}" frameborder="0" style="border:0" allowfullscreen sandbox="allow-forms allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
    </div>

@endsection