@extends('admin.utilities.backup-and-restore.layout')

@section('content')

@php
    $page_title = "VCS | Backup and Restore";
@endphp

<div class="content-header"></div>


        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif

        <div class="container">
            
<div class="page-header">
    <h3 class="mt-2" id="page-title">Backup and Restore</h3>
            <hr>
        </div>
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
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-6">
                       <form method="POST" action="{{ route('backup') }}">
                        @csrf
                           <button type="submit" class="btn btn-lg btn-secondary btn-block"><i class="fas fa-database mr-2"></i> Backup Database</button>
                       </form>
                    </div>
                    <div class="col-6">
                        <form method="POST" action="{{ route('restore') }}">
                         @csrf
                            <button type="submit" class="btn btn-lg btn-success btn-block"><i class="fas fa-redo-alt mr-2"></i> Restore Database</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>
        <p class="text-center">{{ $last_backup }}</p>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


@endsection