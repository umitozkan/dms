@extends('layouts.app')

@section('title', 'Gelirler')

@section('content')
    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-[15px] sm:text-base">
            <!-- Stats Overview -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <div class="row g-4">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600">${{ number_format($stats['total_revenue'], 0) }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Toplam Gelir') }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-red-600">${{ number_format($stats['total_price'] ?? 0, 0) }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Toplam Fiyat') }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-red-600">${{ number_format($stats['total_merzigo_cost'] ?? 0, 0) }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Merzigo Maliyeti') }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="text-center">
                                    <div class="text-3xl font-bold {{ $stats['total_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">${{ number_format($stats['total_profit'], 0) }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Net Kar') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Chart -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-3">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Filtreler') }}</h3>
                        <form id="incomeFilters" method="GET" action="{{ route('incomes.index') }}" class="space-y-4">
                            <div>
                                <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Şirket') }}</label>
                                <select id="company_id" name="company_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2">
                                    <option value="">{{ __('Tüm Şirketler') }}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ (string)($selectedCompanyId ?? '') === (string)$company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="period" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Periyot') }}</label>
                                <select id="period" name="period" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2">
                                    <option value="day" {{ ($period ?? 'day') === 'day' ? 'selected' : '' }}>{{ __('Günlük') }}</option>
                                    <option value="week" {{ ($period ?? 'day') === 'week' ? 'selected' : '' }}>{{ __('Haftalık') }}</option>
                                    <option value="month" {{ ($period ?? 'day') === 'month' ? 'selected' : '' }}>{{ __('Aylık') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="start" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Başlangıç Tarihi') }}</label>
                                <input type="date" id="start" name="start" value="{{ $startDate }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2" />
                            </div>
                            <div>
                                <label for="end" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Bitiş Tarihi') }}</label>
                                <input type="date" id="end" name="end" value="{{ $endDate }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2" />
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
                                    {{ __('Getir') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="m-0 fw-semibold">{{ __('Günlük Gelir Grafiği') }}</h3>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-3 rounded-md transition-colors" data-bs-toggle="modal" data-bs-target="#incomeChartFullscreen">
                                <i class="bi bi-arrows-fullscreen me-1"></i> {{ __('Tam Ekran') }}
                            </button>
                        </div>
                        <div class="position-relative" style="height: 360px;">
                            <canvas id="incomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incomes Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ __('Gelir Listesi') }}</h2>
                        <a href="{{ route('incomes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
                            <i class="bi bi-plus-circle me-2"></i>{{ __('Gelir Ekle') }}
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="incomesTable" class="min-w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:28%">{{ __('Dizi') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:12%">{{ __('Dil') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:14%">{{ __('Merzigo Maliyeti') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:14%">{{ __('Fiyat') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:14%">{{ __('Gelir') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:14%">{{ __('Fark') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:14%">{{ __('Gelir Tarihi') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" data-orderable="false" style="width:14%">{{ __('İşlemler') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="px-4 sm:px-6 py-3 border-t border-gray-100 bg-gray-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm text-gray-700">
                            <div>
                                <span class="font-medium">{{ __('Toplam:') }}</span>
                                {{ $stats['total_incomes'] ?? 0 }} {{ __('kayıt') }}
                            </div>
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                                <div>
                                    <span class="text-gray-500">{{ __('Toplam Merzigo Maliyeti:') }}</span>
                                    <span class="font-semibold text-red-600">${{ number_format($stats['total_merzigo_cost'] ?? 0, 2) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">{{ __('Toplam Fiyat:') }}</span>
                                    <span class="font-semibold text-red-600">${{ number_format($stats['total_price'] ?? 0, 2) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">{{ __('Toplam Gelir:') }}</span>
                                    <span class="font-semibold text-green-600">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">{{ __('Toplam Fark (Gelir − Fiyat):') }}</span>
                                    <span class="font-semibold {{ ($stats['total_difference'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">${{ number_format($stats['total_difference'] ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Chart Modal -->
    <div class="modal fade" id="incomeChartFullscreen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Günlük Gelir Grafiği') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="w-100 h-100 position-relative" style="height: 100vh;">
                        <canvas id="incomeChartFull" style="width:100%;height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function(){
                const labels = @json($chartLabels);
                const revenue = @json($chartRevenue);
                const price = @json($chartPrice);
                const profit = @json($chartProfit);

                const formatCurrency = (v) => '$' + Number(v).toLocaleString('en-US', { maximumFractionDigits: 0 });

                function renderIncomeChart(canvasId){
                    const canvas = document.getElementById(canvasId);
                    if (!canvas) return null;
                    const ctx = canvas.getContext('2d');

                    const gradientRevenue = ctx.createLinearGradient(0, 0, 0, 320);
                    gradientRevenue.addColorStop(0, 'rgba(25, 135, 84, 0.35)');
                    gradientRevenue.addColorStop(1, 'rgba(25, 135, 84, 0.00)');

                    const gradientProfit = ctx.createLinearGradient(0, 0, 0, 320);
                    gradientProfit.addColorStop(0, 'rgba(13, 110, 253, 0.30)');
                    gradientProfit.addColorStop(1, 'rgba(13, 110, 253, 0.00)');

                    return new Chart(ctx, {
                    data: {
                        labels,
                        datasets: [
                                { // Gelir: bar
                                    type: 'bar',
                                    label: 'Gelir',
                                    data: revenue,
                                    backgroundColor: gradientRevenue,
                                    borderColor: '#198754',
                                    borderWidth: 1,
                                    order: 1,
                                    barThickness: 22
                                },
                                { // Fiyat: kırmızı çizgi
                                    type: 'line',
                                    label: 'Fiyat',
                                    data: price,
                                    borderColor: '#dc3545',
                                    backgroundColor: 'transparent',
                                    borderWidth: 2.5,
                                    pointRadius: 0,
                                    tension: 0.35,
                                    fill: false,
                                    order: 2
                                },
                                { // Profit as line
                                    type: 'line',
                                    label: 'Net Kar (Gelir − Fiyat)',
                                    data: profit,
                                    borderColor: '#0d6efd',
                                    backgroundColor: gradientProfit,
                                    borderWidth: 2.5,
                                    pointRadius: 0,
                                    tension: 0.35,
                                    fill: true,
                                    order: 3,
                                }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            layout: { padding: { top: 8, right: 12, left: 8, bottom: 0 } },
                            plugins: {
                                legend: { position: 'top', labels: { usePointStyle: true, padding: 16, boxWidth: 10 } },
                                tooltip: {
                                    enabled: true,
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: { label: (ctx) => `${ctx.dataset.label}: ${formatCurrency(ctx.parsed.y ?? 0)}` }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(0,0,0,0.06)', drawTicks: false },
                                    ticks: { callback: (v) => formatCurrency(v) }
                                },
                                x: { grid: { display: false }, ticks: { maxRotation: 0 } }
                            }
                        }
                    });
                }

                // Render main chart
                window._incomeCharts = window._incomeCharts || {};
                window._incomeCharts['incomeChart'] = renderIncomeChart('incomeChart');

                // Fullscreen modal handling
                const modalEl = document.getElementById('incomeChartFullscreen');
                modalEl.addEventListener('shown.bs.modal', function(){
                    if (window._incomeCharts['incomeChartFull']) {
                        window._incomeCharts['incomeChartFull'].destroy();
                    }
                    window._incomeCharts['incomeChartFull'] = renderIncomeChart('incomeChartFull');
                });
                modalEl.addEventListener('hidden.bs.modal', function(){
                    if (window._incomeCharts['incomeChartFull']) {
                        window._incomeCharts['incomeChartFull'].destroy();
                        window._incomeCharts['incomeChartFull'] = null;
                    }
                });

                // Keep chart and table in sync: re-render chart on filter submit and after table reload
                const filtersForm = document.getElementById('incomeFilters');
                if (filtersForm) {
                    filtersForm.addEventListener('submit', function(){
                        // let full page reload handle dataset; nothing else here
                    });
                }
            })();
        </script>
        <script>
            $(function(){
                const table = $('#incomesTable').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('incomes.datatable') }}',
                        data: function(d){
                            d.company_id = $('#company_id').val();
                            d.start = $('#start').val();
                            d.end = $('#end').val();
                        }
                    },
                    columns: [
                        { data: 'show', name: 'show', render: function(data){
                            const title = data?.title ?? '';
                            const company = data?.company ?? '';
                            return `<div class=\"fw-semibold text-body text-truncate\" style=\"max-width: 360px\">${title}</div><div class=\"small text-muted text-truncate\" style=\"max-width: 360px\">${company}</div>`;
                        }},
                        { data: 'language', name: 'language', render: function(data){
                            return `<span class=\"badge rounded-pill bg-primary-subtle text-primary\">${data}</span>`;
                        }},
                        { data: 'merzigo_cost', name: 'merzigo_cost', render: function(val){
                            return `<span class=\"text-danger fw-medium\">$${parseFloat(val).toFixed(2)}</span>`;
                        }},
                        { data: 'price', name: 'price', render: function(val){
                            return `<span class=\"text-danger fw-medium\">$${parseFloat(val).toFixed(2)}</span>`;
                        }},
                        { data: 'revenue', name: 'revenue', render: function(val){
                            return `<span class=\"text-success fw-bold\">$${parseFloat(val).toFixed(2)}</span>`;
                        }},
                        { data: 'difference', name: 'difference', render: function(val){
                            const num = parseFloat(val);
                            const cls = num >= 0 ? 'text-success' : 'text-danger';
                            return `<span class=\"fw-bold ${cls}\">$${num.toFixed(2)}</span>`;
                        }},
                        { data: 'income_date', name: 'income_date', render: function(val){
                            const d = new Date(val);
                            const dd = String(d.getDate()).padStart(2,'0');
                            const mm = String(d.getMonth()+1).padStart(2,'0');
                            const yyyy = d.getFullYear();
                            return `${dd}.${mm}.${yyyy}`;
                        }},
                        { data: 'actions', orderable: false, searchable: false, render: function(links){
                            return `
                                <div class="d-flex gap-2">
                                    <a href="${links.show}" class="text-primary" title="Görüntüle"><i class="bi bi-eye"></i></a>
                                    <a href="${links.edit}" class="text-indigo" title="Düzenle"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="${links.delete}" onsubmit="return confirm('Bu geliri silmek istediğinizden emin misiniz?')">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-link p-0 text-danger" title="Sil"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>`;
                        }}
                    ],
                    order: [[6, 'desc']],
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tümü']],
                    responsive: true,
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json',
                        paginate: {
                            previous: '<i class="bi bi-chevron-left"></i>',
                            next: '<i class="bi bi-chevron-right"></i>'
                        }
                    },
                    columnDefs: [
                        { targets: 0, responsivePriority: 1 },
                        { targets: -1, responsivePriority: 2 },
                        { targets: 1, responsivePriority: 3 },
                        { targets: 2, responsivePriority: 4 },
                        { targets: 3, responsivePriority: 5 },
                        { targets: 4, responsivePriority: 6 },
                        { targets: 5, responsivePriority: 7 },
                        { targets: 6, responsivePriority: 8 },
                    ]
                });

                // Filtreler değiştiğinde tabloyu yenile
                $('#company_id, #start, #end').on('change', function(){ table.ajax.reload(); });

                // Arama inputunu Bootstrap form-control yap
                const $wrapper = $('#incomesTable').closest('.dataTables_wrapper');
                const $searchInput = $wrapper.find('.dataTables_filter input');
                $searchInput.addClass('form-control form-control-sm').attr('placeholder', 'Ara...');
                $wrapper.find('.dataTables_filter label').addClass('mb-0');

                // Length (sayfada X kayıt) seçicisini Bootstrap form-select yap
                const $length = $wrapper.find('.dataTables_length');
                $length.find('select').addClass('form-select form-select-sm w-auto');
                $length.find('label').addClass('mb-0 d-inline-flex align-items-center gap-2');
            });
        </script>
    @endpush
@endsection
