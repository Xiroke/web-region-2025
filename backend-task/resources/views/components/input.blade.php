@props(['name', 'value' => '', 'type' => 'text'])

<div>
    <input
        name="{{ $name }}"
        type="{{ $type }}"
        {{$attributes->merge(['class' => $errors->has($name) ? 'input-error' : ''])}}
        value="{{old($name, $value)}}"
    >
    @error($name)
        <span class="input-errror__text">{{$message}}</span>
    @enderror
</div>