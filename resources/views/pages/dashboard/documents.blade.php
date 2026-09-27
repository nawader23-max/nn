@extends('layouts.app')
@section('title', 'المستندات — نوادر')
@section('page_title', 'خزينة المستندات')
@push('head')
<style>
.nw-documents-page{max-width:1100px;margin:auto;padding:120px 28px 80px}.nw-documents-card{border-radius:24px;padding:1.5rem;margin-bottom:1rem}.nw-document-row{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.08)}.nw-document-row:last-child{border:0}@media(max-width:640px){.nw-documents-page{padding:90px 18px 60px}.nw-document-row{align-items:start;flex-direction:column}}
</style>
@endpush
@section('content')
<main class="nw-documents-page">
  <header style="margin-bottom:1.25rem">
    <div class="nw-section-eyebrow">الخزينة الرقمية</div>
    <h1 class="nw-h1" style="margin:.55rem 0">مستنداتك في مكان واحد</h1>
    <p style="color:var(--text-secondary)">نعرض فقط الملفات التي أرفقتها أو ارتبطت بعقد مملوك لحسابك. لا توجد سجلات تجريبية.</p>
    <a class="nw-btn nw-btn-primary" style="margin-top:1rem" href="{{ route('dashboard.requests.create') }}">إضافة مستند عبر طلب جديد</a>
  </header>
  <section class="nw-documents-card nw-cinematic-panel">
    <h2 class="nw-h3">مستندات الطلبات</h2>
    @php($hasRequestDocuments = false)
    @foreach($requestDocuments as $operation)
      @foreach($operation->documents ?? [] as $document)
        @php($hasRequestDocuments = true)
        <div class="nw-document-row">
          <div><strong>{{ $document['name'] ?? 'مستند' }}</strong><div style="font-size:.78rem;color:var(--text-muted);margin-top:.2rem">{{ $operation->service_name }} · {{ $operation->request_number }}</div></div>
          <span class="nw-status">مرفق بالطلب</span>
        </div>
      @endforeach
    @endforeach
    @if(! $hasRequestDocuments)
      <div class="nw-empty" style="margin-top:1rem;padding:1.4rem">لا توجد مستندات مرفقة بطلباتك حتى الآن.</div>
    @endif
  </section>
  <section class="nw-documents-card nw-cinematic-panel">
    <h2 class="nw-h3">ملفات العقود</h2>
    @if($contracts->isEmpty())
      <div class="nw-empty" style="margin-top:1rem;padding:1.4rem">لا توجد ملفات عقود مرفقة بحسابك.</div>
    @else
      @foreach($contracts as $contract)
        <div class="nw-document-row">
          <div><strong>{{ $contract->title }}</strong><div style="font-size:.78rem;color:var(--text-muted);margin-top:.2rem">{{ $contract->contract_number }}</div></div>
          <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ Storage::url($contract->pdf_path) }}">فتح الملف</a>
        </div>
      @endforeach
    @endif
  </section>
</main>
@endsection
