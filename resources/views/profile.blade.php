@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('type'))
                <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                    <strong style="text-transform: capitalize;">{{ session('type') }}!</strong> {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="card-header">Update Profile</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="col-md-2 float-left">
                        @if($user->picture)
                        <img id="hospital" src="{{asset(PICTURE)}}/{{$user->picture}}" style="height:200px;width:150px;" alt="image">
                        @else
                        <div style="border:solid 2px;height:200px;width:150px;">
                            <strong>No image found</strong>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-10 float-left">
                        <form method="POST" action="{{ route('update-profile') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="picture" class="col-md-4 col-form-label text-md-right">{{ __('Picture') }}</label>

                                <div class="col-md-6">
                                    <input id="picture" type="file" class="form-control-file @error('picture') is-invalid @enderror" name="picture" autocomplete="picture" autofocus>

                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="resume" class="col-md-4 col-form-label text-md-right">{{ __('Resume') }}</label>

                                <div class="col-md-6">
                                    <input id="resume" type="file" class="form-control-file @error('resume') is-invalid @enderror" name="resume" autocomplete="resume" autofocus>
                                    <?php if ($user->resume) { ?> <small><a target="_blank" href="{{asset(RESUME)}}/{{$user->resume}}">{{$user->resume}}</a></small><?php } ?>
                                    @error('resume')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="skill" class="col-md-4 col-form-label text-md-right">{{ __('Skill') }}</label>

                                <div class="col-md-6">
                                    <textarea id="skill" type="text" class="form-control @error('skill') is-invalid @enderror" name="skill" autocomplete="skill" autofocus><?php if ($user->skill) { ?>{{trim($user->skill)}}<?php } ?>
                                    </textarea>

                                    @error('skill')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-outline-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection