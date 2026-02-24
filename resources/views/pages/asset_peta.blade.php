@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/leaflet/leaflet.css') }}">
<style>
    .asset-peta-wrapper {
        padding: 0;
        margin: 0;
        width: 100%;
        height: calc(100vh - 40px);
        min-height: 400px;
    }
    #asset-peta-map {
        width: 100%;
        height: 100%;
        min-height: 400px;
    }
    #asset-peta-map .leaflet-top.leaflet-right {
        margin-top: 140px;
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
<div class="asset-peta-wrapper main-content">
    <div id="asset-peta-map"></div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/leaflet/leaflet.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Peta base: Leaflet + OpenStreetMap saja
    var map = L.map('asset-peta-map', { zoomControl: false }).setView([-2.5, 118], 5);
    L.control.zoom({ position: 'topright' }).addTo(map);

    // Base layer: OpenStreetMap (gratis, tidak perlu API key)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);
});
</script>
@endsection
