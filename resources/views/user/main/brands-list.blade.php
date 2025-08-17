@foreach ($brands as $key => $brand)
    <li class="list-item d-flex justify-content-between {{ $key >= 5 ? 'hidden-brand d-none' : '' }}">
        <div class="form-check">
            <input class="form-check-input chk-brand me-3" type="checkbox" name="brands" value="{{ $brand->slug }}" {{ in_array($brand->slug, explode('--', Request::query('brands'))) == true ? 'checked' : '' }}>
            <label class="form-check-label">{{ $brand->name }}</label>
        </div>
        <div class="text-right float-end">{{ $brand->products_count }}</div>
    </li>
@endforeach

@if ($brands->count() > 5)
    <a href="javascript:void(0)" id="toggle-brands" class="menu-link menu-link_us-s">MORE ...</a>
@endif
