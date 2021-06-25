@extends('core::page.content')
@section('inner-title', __('berita::general.kategori.edit.title', ['attribute' => $title]) . ' - ')
@section('mKategori', 'opened')

@section('content')
	<section class="box-typical">

		{!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'method' => 'PUT']) !!}

	    	@include('core::layouts.components.top', [
                'judul' => __('berita::general.kategori.edit.title', ['attribute' => $title]),
                'subjudul' =>  __('berita::general.kategori.edit.desc'),
                'kembali' => route("$prefix.index")
            ])
	    
	        <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>

	    {!! Form::close() !!}

	</section>
@endsection