@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.Addcategories')</h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.categories.index')}}">@lang('site.categories')</a></li>
            <li class="active">@lang('site.edit')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">@lang('site.edit')</h3>
            </div>

            <div class="box-body">

                @include('partials._errors')
                
                <form action="{{route('dashboard.categories.update' , $category->id)}}" method="post" >
                    @csrf
                    @method('PUT')


                    @foreach (config('translatable.locales') as $lang )

                    <div class="form-group">
                        <label for="">@lang('site.'. $lang . '.name')</label>
                        <input type="text" name="{{$lang}}[name]" class="form-control" value="{{ $category->translate($lang)->name }}">
                    </div>
                        
                    @endforeach

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit" style="padding-left: 5px"></i>@lang('site.edit')</button>
                    </div>


                </form>


                

            </div>
        </div>

        
    </section><!-- end of content -->

</div><!-- end of content wrapper -->
    
@endsection