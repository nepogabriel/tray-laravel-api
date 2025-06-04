@component('mail::message')

# Olá, {{ $seller->name }}! 👋

Aqui está o resumo das suas vendas de hoje:

## 📊 Resumo do Dia
**{{ \Carbon\Carbon::parse($salesData['date'])->format('d/m/Y') }}**

@component('mail::panel')
**{{ $salesData['total_sales'] }}** vendas realizadas

**R$ {{ number_format($salesData['total_value'], 2, ',', '.') }}** em vendas

**R$ {{ number_format($salesData['total_commission'], 2, ',', '.') }}** em comissões
@endcomponent

@if($salesData['total_sales'] > 0)
## 🎉 Parabéns!

Você teve um ótimo desempenho hoje! Continue assim!

**Valor médio por venda:** R$ {{ number_format($salesData['total_value'] / $salesData['total_sales'], 2, ',', '.') }}
@endif

@component('mail::button', ['url' => '#'])
Ver Relatório Completo
@endcomponent

Obrigado pelo seu trabalho!<br>
**Equipe de Vendas**

@endcomponent
