@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.Addproducts')</h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
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

                <form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="">@lang('site.categories')</label>
                        <select name="category_id" class="form-control" id="">

                            <option value="">@lang('site.all_categories')</option>

                            @foreach ($categories as $category )

                                <option value="{{$category->id}}"  {{old('category_id') == $category->id ? 'selected' : ''}} >{{$category->name}}</option>
                        
                            @endforeach

                        </select>
                    </div>

                    @foreach (config('translatable.locales') as $lang )

                    <div class="form-group">
                        <label for="">@lang('site.'. $lang . '.name')</label>
                        <input type="text" name="{{$lang}}[name]" class="form-control" value="{{old($lang . '.name')}}">
                    </div>

                    <div class="form-group">
                        <label for="">@lang('site.'. $lang . '.description')</label>
                        <textarea name="{{$lang}}[description]" class="form-control ckeditor" id="" cols="30" rows="10">{{old($lang . '.description')}}</textarea>
                    </div>
                        
                    @endforeach

                    <div class="form-group">
                        <label for="">@lang('site.image')</label>
                        <input type="file" name="image" class="form-control image" value="">
                    </div>
                    
                    <div class="form-group">
                    <img src="{{asset('uploads/product_images/default.png')}}" style="width: 100px" class="img-thumbnail image-preview " alt="">
                    </div>


                    <div class="form-group">
                        <label for="">@lang('site.purchase_price')</label>
                        <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{old('purchase_price')}}">
                    </div>

                    <div class="form-group">
                        <label for="">@lang('site.sale_price')</label>
                        <input type="number" name="sale_price" step="0.01" class="form-control" value="{{old('sale_price')}}">
                    </div>

                    <div class="form-group">
                        <label for="">@lang('site.stock')</label>
                        <input type="text" name="stock" class="form-control" value="{{old('stock')}}">
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