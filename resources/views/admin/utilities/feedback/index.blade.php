@extends('admin.utilities.feedback.layout')

@section('content')

@php
    $page_title = "VCS | Feedback";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Feedback</h3>
          <hr>
      </div>

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif
    

        <div class="row">
            <div class="col-12">
                <div class="float-left mt-2">
                    Date
                </div>
                <input type="date" class="form-control w-auto float-left m-1" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
                <div class="float-left mt-2">
                    -
                </div>
                <input data-column="9" type="date" class="form-control w-auto float-left m-1" name="date_to" id="date_to" value="{{ date('Y-m-d') }}">  
            </div>
          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="feedback-table">
                       <thead>
                        <tr>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Suggestion</th>
                            <th>Date time</th>
                        </tr>
                       </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection