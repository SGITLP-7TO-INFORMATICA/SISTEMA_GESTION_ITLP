@extends('layouts.abm')

@section('title', 'Error del servidor')

@section('content')
<div style="
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 60vh;
  text-align: center;
  gap: 16px;
">
  <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
       stroke="var(--danger)" stroke-width="1.5"
       stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/>
    <line x1="12" y1="8" x2="12" y2="12"/>
    <line x1="12" y1="16" x2="12.01" y2="16"/>
  </svg>

  <h2 style="font-size: 20px; font-weight: 600; color: var(--text); margin: 0;">
    Error interno del servidor
  </h2>

  <p style="font-size: 14px; color: var(--muted); max-width: 420px; margin: 0; line-height: 1.6;">
    Ocurrió un problema inesperado. Por favor intentá de nuevo en unos minutos.
    Si el problema persiste, contactá al administrador del sistema.
  </p>

  <a href="{{ url('/') }}" style="
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 8px;
    padding: 9px 20px;
    border-radius: 8px;
    background: var(--surface2);
    border: 1px solid var(--border2);
    color: var(--muted);
    font-family: var(--font);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: opacity .2s;
  ">
    Volver al inicio
  </a>
</div>
@endsection
