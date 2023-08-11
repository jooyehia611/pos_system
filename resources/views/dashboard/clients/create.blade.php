@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.Addclients')</h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
            <li class="active">@lang('site.Add')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">@lang('site.Add')</h3>
            </div>

            <div class="box-body">

                @include('partials._errors')

                <form action="{{route('dashboard.clients.store')}}" method="post">
                    @csrf


                    <div class="form-group">
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}" >
                    </div>


                    @for ($i = 0; $i < 2; $i++)
                            <div class="form-group">
                                <label>@lang('site.phone')</label>
                                <input type="text" name="phone[]" class="form-control">
                            </div>
                    @endfor

                    <div class="form-group">
                        <label>@lang('site.address')</label>
                        <textarea name="address" class="form-control" cols="30" rows="10">{{old('address')}}</textarea>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus" style="padding-left: 5px"></i>@lang('site.Add')</button>
                    </div>

                </form>


                

            </div>
        </div>

        
    </section><!-- end of content -->

</div><!-- end of content wrapper -->
    
@endsection