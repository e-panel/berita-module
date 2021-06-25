@extends('core::page.content')
@section('inner-title', __('berita::general.kategori.create.title', ['attribute' => $title]) . ' - ')
@section('mKategori', 'opened')

@section('content')
	<section class="box-typical">

		{!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}

	    	@include('core::layouts.components.top', [
                'judul' => __('berita::general.kategori.create.title', ['attribute' => $title]),
                'subjudul' =>  __('berita::general.kategori.create.desc'),
                'kembali' => route("$prefix.index")
            ])
	    
	        <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>

	    {!! Form::close() !!}

	</section>
@endsection