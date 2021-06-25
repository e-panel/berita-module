@extends('core::page.content')
@section('inner-title', __('berita::general.berita.create.title', ['attribute' => 'Berita']) . ' - ')

@if(!$kategori)
    @section('mUncategorized', 'opened')
    @php
        $label = 'Uncategorized';
        $slug = 'uncategorized';
    @endphp
@else
    @section('m'.$kategori->slug, 'opened')
    @php
        $label = $kategori->label;
        $slug = $kategori->slug;
    @endphp
@endif

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.css">
@endsection

@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.js"></script>
	<script>
		$().ready(function () {
			$('.flatpickr').flatpickr({
    			dateFormat: "Y-m-d",
			});
		});
	</script>
	@include('core::layouts.components.tinymce')
@endsection

@section('content')
	<section class="box-typical">

		{!! Form::open(['route' => ["$prefix.berita.store", $slug], 'autocomplete' => 'off', 'files' => true]) !!}

	    	@include('core::layouts.components.top', [
                'judul' => __('berita::general.berita.create.title', ['attribute' => $label]),
                'subjudul' =>  __('berita::general.berita.create.desc'),
                'kembali' => route("$prefix.berita.index", $slug)
            ])
	    
	        <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>

	    {!! Form::close() !!}

	</section>
@endsection