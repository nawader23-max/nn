{{-- Honeypot Anti-Bot Field — invisible to humans, irresistible to bots --}}
@if(config('security.honeypot_enabled', true))
<div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;overflow:hidden;opacity:0;pointer-events:none;tab-index:-1;">
    <label for="{{ config('security.honeypot_field_name', 'sovereign_token_verify') }}">لا تملأ هذا الحقل</label>
    <input type="text"
           name="{{ config('security.honeypot_field_name', 'sovereign_token_verify') }}"
           id="{{ config('security.honeypot_field_name', 'sovereign_token_verify') }}"
           value=""
           autocomplete="off"
           tabindex="-1" />
</div>
@endif
