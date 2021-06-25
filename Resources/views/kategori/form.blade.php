<div class="box-typical-body padding-panel">
	<div class="form-group row {{ $errors->first('label', 'form-group-error') }}" style="margin-bottom: 0">
		<label class="col-sm-2 form-control-label">
			{{ __('berita::general.kategori.form.label.label') }} <span class="color-red">*</span>
		</label>
		<div class="col-sm-10">
			{!! Form::text('label', null, ['class' => 'form-control', 'placeholder' =>  __('berita::general.kategori.form.label.placeholder')]) !!}
			{!! $errors->first('label', '<span class="text-muted"><small>:message</small></span>') !!}
		</div>
	</div>
</div>