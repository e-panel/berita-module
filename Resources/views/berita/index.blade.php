@extends('core::page.content')

@if($kategori == 'Uncategorized')
    @section('inner-title', 'Uncategorized - ')
    @section('mUncategorized', 'opened')

    @php
        $label = 'Uncategorized';
    @endphp
@else
    @section('inner-title', "$kategori->label - ")
    @section('m'.$kategori->slug, 'opened')

    @php
        $label = $kategori->label;
    @endphp
@endif

@section('css')
    @include('core::layouts.partials.datatables')
@endsection

@section('js') 
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/datatables-net/datatables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable({
                order: [[ 4, "desc" ]], 
                processing: true,
                serverSide: true,
                ajax : '{!! request()->fullUrl() !!}?datatable=true',
                columns: [
                    { data: 'pilihan', name: 'pilihan', className: 'table-check' },
                    { data: 'oleh', name: 'oleh', className: 'table-photo' },
                    { data: 'label', name: 'label' },
                    { data: 'views', name: 'views' },
                    { data: 'tanggal', name: 'tanggal', className: 'table-date small' },
                    { data: 'published', name: 'published' },
                    { data: 'aksi', name: 'aksi', className: 'tombol' }
                ],
                "fnDrawCallback": function( oSettings ) {
                    @include('core::layouts.components.callback')
                }
            });
        });
        @include('core::layouts.components.hapus')
    </script>
@endsection

@section('content')

    @if(!$data->count())

        @include('core::layouts.components.kosong', [
            'icon' => 'font-icon font-icon-post',
            'judul' => $label,
            'subjudul' => __('berita::general.berita.empty', ['message' => str_replace('Modul ', 'data ', $title)]), 
            'tambah' => route("$prefix.berita.create", $slug)
        ])

    @else
        
        {!! Form::open(['method' => 'delete', 'route' => ["$prefix.berita.destroy", $slug, 'hapus-all'], 'id' => 'submit-all']) !!}

            @include('core::layouts.components.top', [
                'judul' => $label,
                'subjudul' => __('berita::general.berita.desc'),
                'tambah' => route("$prefix.berita.create", $slug),
                'hapus' => true
            ])

            <div class="card">
                <div class="card-block table-responsive">
                    <table id="datatable" class="display table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="table-check"></th>
                                <th class="table-photo"></th>
                                <th>LABEL</th>
                                <th width="10%"></th>
                                <th class="text-right" width="15%">CREATED</th>
                                <th width="1"></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        {!! Form::close() !!}
    @endif
@endsection
