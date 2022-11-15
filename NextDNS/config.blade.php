<h2>{{ __('app.apps.config') }} ({{ __('app.optional') }}) @include('items.enable')</h2>
<div class="items">
    <div class="input">
        <label>API Key</label>
        {!! Form::input('password', 'config[api_key]', isset($item) ? $item->getconfig()->api_key : null, ['placeholder' => 'abadbeefabc12c34ab3daf31aababf39', 'data-config' => 'api_key', 'class' => 'form-control config-item']) !!}
    </div>
    <div class="input">
        <label>Profile</label>
        {!! Form::text('config[profile]', null, array('placeholder' => "a1b2c3", 'data-config' => 'profile', 'class' => 'form-control config-item')) !!}
    </div>
    <div class="input">
        <button style="margin-top: 32px;" class="btn test" id="test_config">Test</button>
    </div>
</div>

