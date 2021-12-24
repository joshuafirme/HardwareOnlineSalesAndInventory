
@php
$page_title =  "Val Construction Supply | Cart";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<style>
  #map {
  height: 400px;
}
    .fa {
        color: #06513D;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <main class="d-flex align-items-center py-3 py-md-0">
      <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <a href="{{ url('account') }}"><i class="fa fa-arrow-left"></i></a>
                    <h3 class="mt-2">Edit address</h3>
                    <form action="{{ route('address.update',Auth::id()) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Municipality</label><br>
                               <select class="form-control" name="municipality">
                                 @php
                                     $municipality = isset($address->municipality) ? $address->municipality : "";
                                 @endphp
                                 @foreach ($municipalities as $item)
                                    @php
                                        $selected = $item->municipality == $municipality ? "selected" : "";
                                    @endphp
                                    <option {{$selected}} value="{{ $item->municipality }}">{{ $item->municipality }}</option>
                                 @endforeach
                               </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Brgy</label><br>
                                <select class="form-control" name="brgy">
                                  @foreach ($brgys as $item)
                                  @php
                                  $brgy = isset($address->brgy) ? $address->brgy : "";
                                  $selected = "";
                                  if($item->id == $brgy) {
                                      $selected = 'selected';
                                  }else {
                                    continue;
                                  }
                                  @endphp
                                  <option {{ $selected }} value="{{ $item->id }}">{{ $item->brgy }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Street</label><br>
                                <input name="street" class="form-control" value="{{ isset($address->street) ? $address->street : "" }}">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Nearest landmark</label><br>
                                <input name="notes" class="form-control" value="{{ isset($address->notes) ? $address->notes : "" }}">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                              <label class="col-form-label">Latitude/Longitude</label><br>
                              <input name="map" class="form-control" value="{{ isset($address->map) ? $address->map : "" }}" readonly>
                          </div>
                            <div class="col-sm-12 mt-2">
                              <div id="map"></div>
                            </div>
                              
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-success mr-2" id="btn-add-user">Save changes</button>
                              </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
      </div>
    </main>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')
<script src="{{asset('js/user.js')}}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8wVIr_ne8CDZ_NM_9RPkL5nBUa7TlVms&callback=initMap&v=weekly&channel=2" async></script>
<script src="{{asset('js/gmap.js')}}"></script>