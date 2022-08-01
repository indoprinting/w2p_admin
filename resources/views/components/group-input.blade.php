@props(['important', 'input_name'])

<div class="form-group row">
    <label class="col-sm-2 col-form-label">{{ $input_name }} {{ $important ? '<sup class="fas fa-star-of-life" style="font-size:6px;color:red"></sup>' : '' }}</label>
    <div class="col-sm-10">
        {{ $slot }}
    </div>
</div>
