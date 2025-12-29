@props(['name', 'value'])

<div>
    <label>
        <input
                name="{{ $name }}"
                type="file"
                onchange="this.nextElementSibling.innerText = this.files[0].name"
                {{$attributes->merge(['class' => $errors->has($name) ? 'input-error' : ''])}}
                value="{{old($name, $value ?? '')}}"
        >
        <span>Загрузить</span>
    </label>
    @error($name)
    <span class="input-errror__text">{{$message}}</span>
    @enderror
</div>