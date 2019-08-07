@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (session('type'))
                    <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                        <strong style="text-transform: capitalize;">{{ session('type') }}!</strong> {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($jobs->count() > 0)
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sl No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Salary</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Country</th>
                                    @if(Auth::user()->status == 0)
                                    <th scope="col">Applicant</th>
                                    @endif
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1 @endphp
                                @foreach($jobs as $job)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$job->title}}</td>
                                    <td>{{$job->description}}</td>
                                    <td>{{$job->salary}}</td>
                                    <td>{{$job->location}}</td>
                                    <td>{{$job->country}}</td>
                                    @if(Auth::user()->status == 0)
                                    <td>
                                        @if(count($job->applications) > 0)
                                        @foreach ($job->applications as $application)
                                        @foreach ($users as $user)
                                        @if($user->_id == $application->user_id)
                                        <span class="badge badge-pill badge-success">{{$user->first_name}} {{$user->last_name}}</span>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @else
                                        <span class="badge badge-pill badge-danger">No Applicant</span>
                                        @endif
                                    </td>
                                    @endif
                                    <td>
                                        @if(Auth::user()->status == 1)
                                        @php $applicale = true; @endphp
                                        @foreach ($job->applications as $application)
                                        @if(Auth::user()->id == $application->user_id)
                                        @php $applicale = false; @endphp
                                        <button class="btn btn-outline-success btn-sm" disabled>
                                            {{ __('Applied') }}
                                        </button>
                                        @endif
                                        @endforeach
                                        @if($applicale)
                                        <a class="btn btn-outline-primary btn-sm" href="{{ url('/apply-job/'.$job->id) }}">
                                            {{ __('Apply') }}
                                        </a>
                                        @endif
                                        @else
                                        <a class="btn btn-outline-info btn-sm" href="{{ url('/add-job/'.$job->id) }}">
                                            {{ __('Edit') }}
                                        </a><br>
                                        <a class="btn btn-outline-danger btn-sm" href="{{ url('/destroy-job/'.$job->id) }}">
                                            {{ __('Delete') }}
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @php $i++ @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <?php echo $jobs->render(); ?>
                    </div>
                    @else
                    <b>No job found</b>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection