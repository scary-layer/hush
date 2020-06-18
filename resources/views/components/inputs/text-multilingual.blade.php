@if (!isset($input['multirow']) || !$input['multirow'])

<div class="multilingual-input row no-gutters align-items-center">
    <div class="col">
        @php($mark = true)
        @foreach ($langs as $i => $lang)
        {!! Form::text($input['name'] . "[$lang->code]", $values[$lang->code] ?? '', [
            'class' => 'form-control multilingual-field '
                . ($i != 0 ? 'd-none' : '') . ' '
                . (isset($input['slugify']) && $mark && !$model->id ? 'sluggable' : '') . ' '
                . ($input['class'] ?? ''),
            'placeholder' => __('hush::admin.' . ($input['placeholder'] ?? $input['label'] ?? '')),
            'data-slugify-target' => $mark ? ($input['slugify'] ?? null) : null,
        ]) !!}
        @php($mark = false)
        @endforeach
    </div>
    <select class="col-2 multilingual-selector">
        @foreach ($langs as $lang)
        <option value="{{ $input['name'] }}[{{ $lang->code }}]">{{ $lang->name }}</option>
        @endforeach
    </select>
</div>

@else

<div class="row">
    @php($mark = true)
    @foreach ($langs as $i => $lang)
    <div class="form-group {{ $input['field_width'] ?? "col-12" }}">
        {!! Form::label($input['name'] . "[$lang->code]", __('hush::admin.' . $input['label']) . " ($lang->name)") !!}
        {!! Form::text($input['name'] . "[$lang->code]", $values[$lang->code] ?? '', [
            'class' => 'form-control multilingual-field '
                . (isset($input['slugify']) && $mark && !$model->id ? 'sluggable' : '') . ' '
                . ($input['class'] ?? ''),
                'placeholder' => __('hush::admin.' . ($input['placeholder'] ?? $input['label'] ?? '')),
                'data-slugify-target' => $mark ? ($input['slugify'] ?? null) : null,
        ]) !!}
    </div>
    @php ($mark = false)
    @endforeach
</div>

@endif