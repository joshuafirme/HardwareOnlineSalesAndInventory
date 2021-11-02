@if(\Session::has('success'))
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> </h5>
            {{ \Session::get('success') }}
        </div>
    </div>
</div>
    
@elseif(\Session::has('danger'))

<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ \Session::get('danger') }}
        </div>
    </div>
</div>

@endif