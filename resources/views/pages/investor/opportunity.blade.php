@extends('layouts.app')

@section('title', 'غرفة الفرصة — نوادر')
@section('page_title', 'غرفة الفرصة الاستثمارية')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:980px;">
    <div class="nw-cinematic-panel" style="padding:2.5rem;text-align:center;">
      <div class="nw-section-eyebrow">{{ $id }}</div>
      <h1 style="color:#fff;font-size:2rem;margin:.4rem 0 .8rem;">غرفة الفرصة غير متاحة للنشر العام</h1>
      <p style="color:var(--text-secondary);max-width:680px;margin:0 auto 1.5rem;line-height:1.9;">هذه الغرفة لا تعرض أي توقعات أو أرقام غير معتمدة. عند اعتماد الفرصة ستُفتح المستندات والصلاحيات للمستثمرين المؤهلين فقط.</p>
      <div style="display:flex;justify-content:center;gap:.75rem;flex-wrap:wrap;"><a href="{{ route('investor.opportunities') }}" class="nw-btn nw-btn-ghost">العودة للفرص</a><a href="{{ route('investor.consultations') }}" class="nw-btn nw-btn-primary">طلب تواصل مع الفريق</a></div>
    </div>
  </div>
</div>
@endsection
