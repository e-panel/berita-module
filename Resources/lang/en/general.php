<?php 

return [

	'kategori' => [
		'title' => 'Kategori', 
		'desc' => 'Berikut ini adalah daftar seluruh data yang telah tersimpan di dalam database.', 
		'empty' => 'Sepertinya Anda belum memiliki :message.', 

		'created' => 'Data :title berhasil ditambah!', 
		'updated' => 'Data :title berhasil diubah!', 
		'deleted' => 'Beberapa data :title berhasil dihapus sekaligus!', 

		'create' => [
			'title' => 'Tambah :attribute', 
			'desc' => 'Silahkan lengkapi form berikut untuk menambahkan data baru.'
		],

		'edit' => [
			'title' => 'Ubah :attribute', 
			'desc' => 'Silahkan lakukan perubahan sesuai dengan kebutuhan.'
		], 

		'form' => [
			'label' => [
				'label' => 'Label', 
				'placeholder' => 'Label Kategori', 
			],
		],

		'table' => [
			'label' => 'LABEL', 
			'created' => 'CREATED', 
		],
	],
	
	'berita' => [
		'title' => 'Berita', 
		'desc' => 'Berikut ini adalah daftar seluruh data yang telah tersimpan di dalam database.', 
		'empty' => 'Sepertinya Anda belum memiliki :message.', 

		'created' => 'Data :title berhasil ditambah!', 
		'updated' => 'Data :title berhasil diubah!', 
		'deleted' => 'Beberapa data :title berhasil dihapus sekaligus!', 
		'changed' => 'Status Berhasil Diubah!', 

		'create' => [
			'title' => 'Tambah :attribute', 
			'desc' => 'Silahkan lengkapi form berikut untuk menambahkan data baru.'
		],

		'edit' => [
			'title' => 'Ubah :attribute', 
			'desc' => 'Silahkan lakukan perubahan sesuai dengan kebutuhan.'
		], 

		'form' => [
			'judul' => [
				'label' => 'Judul', 
				'placeholder' => 'Judul Berita', 
			],
			'kategori' => [
				'label' => 'Kategori', 
				'placeholder' => '', 
			],
			'preview' => [
				'label' => 'Preview', 
				'placeholder' => '', 
			],
			'konten' => [
				'label' => 'Konten Berita', 
				'placeholder' => '', 
			],
			'thumbnail' => [
				'label' => 'Pilih Sampul', 
				'select' => 'Pilih Sampul', 
				'change' => 'Ganti', 
				'remove' => 'Remove', 

			],
			'source' => [
				'label' => 'Sumber Foto', 
				'placeholder' => '', 
			],
			'date' => [
				'label' => 'Tanggal Terbit', 
				'placeholder' => '', 
			],
			'status' => [
				'label' => 'Status', 
				'published' => 'Published', 
				'draft' => 'Save as Draft', 
			],
		],

		'table' => [
			'label' => 'LABEL', 
			'created' => 'CREATED', 
		],
	],
];