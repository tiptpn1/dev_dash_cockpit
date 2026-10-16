@php
    $appUser = Auth::guard('custom')->user() ?? Auth::user();
    $appUsername = strtolower($appUser->username ?? '');
    $isRegionalUser = !empty($userRegionalId)
        || in_array($appUsername, ['regional1', 'regional2', 'regional3', 'regional5', 'regional7', 'regional8'])
        || str_starts_with($appUsername, 'regional')
        || !empty($appUser->regional);
@endphp

<div class="filter-grid">
  <div class="form-group">
    <label class="form-label">Aplikasi</label>
    <select id="selectedApp" class="form-select">
      <option value="HRIS" {{ isset($selected) && $selected === 'HRIS' ? 'selected' : '' }}>HRIS</option>
      <option value="Digital Farming" {{ isset($selected) && $selected === 'Digital Farming' ? 'selected' : '' }}>DFarm Presensi</option>
      <option value="Digital Farming Produksi" {{ isset($selected) && $selected === 'Digital Farming Produksi' ? 'selected' : '' }}>DFarm Prestasi</option>
      @if(!$isRegionalUser)
        <option value="Digital Farming BKM" {{ isset($selected) && $selected === 'Digital Farming BKM' ? 'selected' : '' }}>DFarm & BKM SAP</option>
        <option value="MAIA" {{ isset($selected) && $selected === 'MAIA' ? 'selected' : '' }}>MAIA</option>
        <option value="MONIKA" {{ isset($selected) && $selected === 'MONIKA' ? 'selected' : '' }}>MONIKA</option>
        <option value="BPD" {{ isset($selected) && $selected === 'BPD' ? 'selected' : '' }}>Aplikasi BPD</option>
        <option value="SAPA-Amanah" {{ isset($selected) && $selected === 'SAPA-Amanah' ? 'selected' : '' }}>SAPA-Amanah</option>
      @endif
    </select>
  </div>
</div>

