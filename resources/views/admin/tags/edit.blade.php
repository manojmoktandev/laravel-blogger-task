@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Edit Tag
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("admin.tags.update",$tag) }}"
                enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="required" for="name">Name</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                               name="name" id="name" value="{{ old('name',$tag->name) }}" >
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>
                    <div class="form-group"  style="margin-top: 10px;">
                        <button class="btn btn-danger" type="submit">
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
