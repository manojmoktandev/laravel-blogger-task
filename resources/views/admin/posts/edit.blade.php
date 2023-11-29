@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Edit post
            </div>

            <div class="card-body">
                <form action="{{route('admin.posts.update',$post)}}" enctype="multipart/form-data" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title" class="required">Title</label>
                        <input type="text" class="form-control {{$errors->has('title')?'is-invalid':''}}"
                        name="title" value="{{old('title',$post->title)}}" id="title">
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{$errors->first('title')}}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="title" class="required">Image</label>
                        <input type="file" class="form-control {{$errors->has('image')?'is-invalid':''}}"
                        name="image" value="{{old('image')}}" id="image">
                        @if($post->image)
                            <img src="{{asset('/storage/uploads/posts/'.$post->image)}}" alt="post pic" height="200" width="200">
                        @endif
                        @if($errors->has('image'))
                            <div class="invalid-feedback">
                                {{$errors->first('image')}}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group">
                        <label for="title" class="required">Tags</label>
                        <input type="text" class="form-control {{$errors->has('tags')?'is-invalid':''}}"
                        name="tags" value="{{old('tags',$tags)}}" id="tags">
                        @if($errors->has('tags'))
                            <div class="invalid-feedback">
                                {{$errors->first('tags')}}
                            </div>
                        @endif
                        <span class="help-block">Seperated by comma</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="category">Category</label>
                        <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category"
                                id="category" required>
                            <option value="0">--- SELECT CATEGORY ---</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{-- @if (in_array($category->id, $post->category->pluck('id')->toArray())) selected @endif>{{ $category->name }}</option> --}}
                                    @if($category->id==$post->category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('category') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group">
                        <label for="post">Post</label>
                        <textarea class="form-control {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post"
                                  id="post">{{ old('post',$post->post) }}</textarea>
                        @if($errors->has('post'))
                            <div class="invalid-feedback">
                                {{ $errors->first('post') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group" style="margin-top: 10px;">
                        <button class="btn btn-danger" type="submit">
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
