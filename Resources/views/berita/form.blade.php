<div class="box-typical-body padding-panel">
	<div class="row">
		<div class="col-sm-9">
			<div class="row">
				<div class="col-md-8">
					<fieldset class="form-group {{ $errors->first('judul', 'form-group-error') }}">
						<label for="judul" class="form-label">
							{{ __('berita::general.berita.form.judul.label') }} 
							<span class="color-red">*</span>
						</label>
						<div class="form-control-wrapper">
							{!! Form::text('judul', null, ['class' => 'form-control', 'placeholder' => __('berita::general.berita.form.judul.placeholder')]) !!}
							{!! $errors->first('judul', '<span class="text-muted"><small>:message</small></span>') !!}
						</div>
					</fieldset>
				</div>
				<div class="col-md-4">
					<fieldset class="form-group {{ $errors->first('id_kategori', 'form-group-error') }}">
						<label for="id_kategori" class="form-label">
							{{ __('berita::general.berita.form.kategori.label') }}  
							<span class="color-red">*</span>
						</label>
						<div class="form-control-wrapper">
							<select class="form-control select2" name="id_kategori" 
								@if(!isset($edit))
									disabled="disabled"
								@endif
							>
								<option value="">Uncategorized</option>
								@foreach(Modules\Berita\Entities\Kategori::get() as $temp)
									<option value="{{ $temp->id }}"
										@if($kategori)
											@if($kategori->id == $temp->id)
												selected="selected" 
											@endif
										@endif
									>{{ $temp->label }}</option>
								@endforeach
							</select>
							{!! $errors->first('id_kategori', '<span class="text-muted"><small>:message</small></span>') !!}
						</div>
					</fieldset>
				</div>
			</div>

			<fieldset class="form-group {{ $errors->first('preview', 'form-group-error') }}">
				<label for="preview" class="form-label">
					{{ __('berita::general.berita.form.preview.label') }}  
					<span class="color-red">*</span>
				</label>
				<div class="form-control-wrapper">
					{!! Form::textarea('preview', null, ['class' => 'form-control', 'rows' => 3]) !!}
					{!! $errors->first('preview', '<span class="text-muted"><small>:message</small></span>') !!}
				</div>
			</fieldset>

			<fieldset class="form-group {{ $errors->first('isi', 'form-group-error') }}">
				<label for="isi" class="form-label">
					{{ __('berita::general.berita.form.konten.label') }} 
					<span class="color-red">*</span>
				</label>
				<div class="form-control-wrapper">
					{!! Form::textarea('isi', null, ['class' => 'tinymce']) !!}
					{!! $errors->first('isi', '<span class="text-muted"><small>:message</small></span>') !!}
				</div>
			</fieldset>

		</div>
		<div class="col-sm-3">

			<fieldset class="form-group {{ $errors->first('foto', 'form-group-error') }}">
				<label for="foto" class="form-label">
					{{ __('berita::general.berita.form.thumbnail.label') }}
					<span class="color-red">*</span>
				</label>
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						@if(!isset($edit))
							<img data-src="holder.js/1024x768/auto" alt="...">
						@else
							<img src="{{ viewImg($edit->foto, 'm') }}" alt="{{ $edit->judul }}">
						@endif
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
					<div>
						<span class="btn btn-default btn-file">
							<span class="fileinput-new">{{ __('berita::general.berita.form.thumbnail.select') }}</span>
							<span class="fileinput-exists">{{ __('berita::general.berita.form.thumbnail.change') }}</span>
							{!! Form::file('foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}
						</span>
						<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ __('berita::general.berita.form.thumbnail.remove') }}</a>
					</div>
					{!! $errors->first('foto', '<span class="text-muted"><small>:message</small></span>') !!}
				</div>
			</fieldset>

			<fieldset class="form-group {{ $errors->first('sumber_foto', 'form-group-error') }}">
				<label for="sumber_foto" class="form-label">
					{{ __('berita::general.berita.form.source.label') }}
					<span class="color-red">*</span>
				</label>
				<div class="form-control-wrapper">
					{!! Form::text('sumber_foto', null, ['class' => 'form-control']) !!}
					{!! $errors->first('sumber_foto', '<span class="text-muted"><small>:message</small></span>') !!}
				</div>
			</fieldset>

			<fieldset class="form-group">
				<label for="tgl_terbit" class="form-label">
					{{ __('berita::general.berita.form.date.label') }}
				</label>
				<div class="form-control-wrapper">
					@if(isset($edit))
						{!! Form::text('tgl_terbit', $edit->created_at, ['class' => 'form-control flatpickr']) !!}
					@else
						{!! Form::text('tgl_terbit', date('Y-m-d'), ['class' => 'form-control flatpickr']) !!}
					@endif
				</div>
			</fieldset>

			<fieldset class="form-group">
				<label for="status" class="form-label">
					{{ __('berita::general.berita.form.status.label') }}
				</label>
				<div class="form-control-wrapper">
					<select name="status" id="status" class="select2 select2-no-search-arrow">
						<option value="1" {{ isset($edit) ? $edit->status == 1 ? 'selected' : '' : '' }}>
							{{ __('berita::general.berita.form.status.published') }}
						</option>
						<option value="0" {{ isset($edit) ? $edit->status == 0 ? 'selected' : '' : '' }}>
							{{ __('berita::general.berita.form.status.draft') }}
						</option>
					</select>
				</div>
			</fieldset>
			
		</div>
	</div>
</div>