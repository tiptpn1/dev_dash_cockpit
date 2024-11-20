@extends('layouts.appoverview')

@section('content')
    <div class="mapouter" style="height: 45%; width: 60%; float:left;">
        <div class="gmap_canvas" style="height: 100%;">
            <iframe style="height: 100%; width:100%;" class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=300&amp;hl=en&amp;q=University of Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
            
        </div>
    </div>
    <div class="areal_hgu" style="height: 45%; width: 20%; float:left;">
        <iframe scrolling='no' style="height: 100%; width:100%;" src="https://lookerstudio.google.com/embed/reporting/95008c94-fb63-47aa-bef3-b125dc67c807/page/oyNLE" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
    </div>
    <div class="areal_hgu" style="height: 45%; width: 20%; float:left;">
        <iframe scrolling='no' style="height: 100%; width:100%;" src="https://lookerstudio.google.com/embed/reporting/9257a9fb-bb6d-4167-a1a2-f7d8d2a8996a/page/oyNLE" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
    </div>

@endsection