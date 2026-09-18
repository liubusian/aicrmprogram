<script setup>
import { reactive } from 'vue';

const props = defineProps({
    page: { type: String, required: true },
    data: { type: Object, default: () => ({}) },
});

const customer = props.data.customer ?? {};
const form = reactive({
    name: customer.name ?? '',
    company: customer.company ?? '',
    email: customer.email ?? '',
    phone: customer.phone ?? '',
    source: customer.source ?? 'website',
    status: customer.status ?? 'new',
    notes: customer.notes ?? '',
});

const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const statusOptions = [
    { value: 'new', label: 'New' },
    { value: 'contacted', label: 'Contacted' },
    { value: 'qualified', label: 'Qualified' },
];
const sourceOptions = [
    { value: 'website', label: 'Website' },
    { value: 'referral', label: 'Referral' },
    { value: 'social', label: 'Social' },
];

const statusLabel = (status) => statusOptions.find((item) => item.value === status)?.label ?? status ?? 'New';
const statusClass = (status) => `status status-${status ?? 'new'}`;
const customerCount = () => props.data.customers?.data?.length ?? 0;
const customerUrl = (id) => `/customers/${id}`;
const paginationUrl = (page) => {
    const params = new URLSearchParams();
    if (props.data.search) params.set('search', props.data.search);
    if (props.data.status) params.set('status', props.data.status);
    params.set('page', page);
    return `/customers?${params.toString()}`;
};
</script>

<template>
    <section v-if="page === 'dashboard'" class="page-shell">
        <div class="page-heading reveal">
            <div>
                <p class="eyebrow">Overview / 01</p>
                <h1>客戶關係，一眼掌握。</h1>
                <p class="lede">把每一次互動，整理成下一個值得跟進的機會。</p>
            </div>
            <a class="button button-primary" href="/customers/create">新增客戶 <span>↗</span></a>
        </div>

        <div class="stat-grid">
            <article class="stat-card stat-card-dark reveal reveal-delay-1">
                <span>總客戶數</span>
                <strong>{{ data.totalCustomers ?? 0 }}</strong>
                <small>目前 CRM 名單</small>
            </article>
            <article class="stat-card reveal reveal-delay-2">
                <span>本月新增</span>
                <strong>{{ data.newCustomers ?? 0 }}</strong>
                <small class="accent-green">持續累積中</small>
            </article>
            <article class="stat-card reveal reveal-delay-3">
                <span>待跟進</span>
                <strong>{{ data.pendingFollowUp ?? 0 }}</strong>
                <small class="accent-orange">需要你的注意</small>
            </article>
        </div>

        <div class="dashboard-grid reveal reveal-delay-2">
            <div class="feature-panel">
                <div class="panel-kicker">Today’s focus</div>
                <h2>讓重要的客戶<br><em>不再被遺漏。</em></h2>
                <p>從列表快速找到關係進度，更新狀態，讓團隊知道下一步該做什麼。</p>
                <a class="text-link" href="/customers">開啟客戶列表 <span>→</span></a>
            </div>
            <div class="note-panel">
                <span class="panel-kicker">Workflow</span>
                <div class="workflow-row"><b>01</b><span>捕捉新線索</span><i>●</i></div>
                <div class="workflow-row"><b>02</b><span>建立聯繫</span><i>●</i></div>
                <div class="workflow-row"><b>03</b><span>轉化成機會</span><i>●</i></div>
            </div>
        </div>
    </section>

    <section v-else-if="page === 'index'" class="page-shell">
        <div class="page-heading reveal">
            <div>
                <p class="eyebrow">Customers / Directory</p>
                <h1>客戶名單</h1>
                <p class="lede">{{ data.customers?.total ?? customerCount() }} 位客戶，清楚看見每一段關係。</p>
            </div>
            <a class="button button-primary" href="/customers/create">新增客戶 <span>+</span></a>
        </div>

        <div v-if="data.success" class="flash-message">{{ data.success }}</div>
        <div class="filter-bar reveal reveal-delay-1">
            <form method="GET" action="/customers" class="filter-form">
                <label class="search-field"><span>⌕</span><input name="search" :value="data.search" placeholder="搜尋姓名、公司、Email 或電話"></label>
                <select name="status" :value="data.status"><option value="">全部狀態</option><option v-for="option in statusOptions" :key="option.value" :value="option.value">{{ option.label }}</option></select>
                <button class="button button-ink" type="submit">篩選</button>
                <a class="reset-link" href="/customers">重置</a>
            </form>
        </div>

        <div class="table-panel reveal reveal-delay-2">
            <div class="table-meta"><span>顯示 {{ customerCount() }} 筆資料</span><span class="meta-dot">●</span><span>最新建立優先</span></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>客戶</th><th>公司</th><th>聯絡方式</th><th>來源</th><th>狀態</th><th></th></tr></thead>
                    <tbody>
                        <tr v-for="item in (data.customers?.data ?? [])" :key="item.id">
                            <td><a class="customer-name" :href="customerUrl(item.id)">{{ item.name }}</a><small>{{ item.created_at?.slice(0, 10) }}</small></td>
                            <td>{{ item.company || '—' }}</td>
                            <td><span>{{ item.email || '—' }}</span><small>{{ item.phone || '' }}</small></td>
                            <td class="muted-cell">{{ item.source || '—' }}</td>
                            <td><span :class="statusClass(item.status)">{{ statusLabel(item.status) }}</span></td>
                            <td class="actions"><a :href="customerUrl(item.id)">查看</a><a :href="`${customerUrl(item.id)}/edit`">編輯</a><form method="POST" :action="customerUrl(item.id)" @submit="(event) => { if (!confirm('確定刪除這位客戶？')) event.preventDefault(); }"><input type="hidden" name="_token" :value="csrf"><input type="hidden" name="_method" value="DELETE"><button type="submit">刪除</button></form></td>
                        </tr>
                        <tr v-if="!data.customers?.data?.length"><td colspan="6" class="empty-state">目前沒有客戶資料。</td></tr>
                    </tbody>
                </table>
            </div>
            <div v-if="data.customers?.last_page > 1" class="pagination"><a v-if="data.customers.current_page > 1" :href="paginationUrl(data.customers.current_page - 1)">← 上一頁</a><span>第 {{ data.customers.current_page }} / {{ data.customers.last_page }} 頁</span><a v-if="data.customers.current_page < data.customers.last_page" :href="paginationUrl(data.customers.current_page + 1)">下一頁 →</a></div>
        </div>
    </section>

    <section v-else-if="page === 'form'" class="page-shell form-shell">
        <div class="page-heading reveal"><div><p class="eyebrow">Customers / {{ customer.id ? 'Edit profile' : 'New profile' }}</p><h1>{{ customer.id ? '編輯客戶' : '新增客戶' }}</h1><p class="lede">建立完整資料，讓下一次聯繫更有準備。</p></div><a class="text-link" href="/customers">← 返回列表</a></div>
        <form class="form-panel reveal reveal-delay-1" method="POST" :action="customer.id ? `/customers/${customer.id}` : '/customers'">
            <input type="hidden" name="_token" :value="csrf"><input v-if="customer.id" type="hidden" name="_method" value="PUT">
            <div class="form-section"><span class="section-number">01</span><div><h2>基本資料</h2><p>先從名字與公司開始。</p></div></div>
            <div class="form-grid"><label>姓名 *<input v-model="form.name" name="name" required></label><label>公司<input v-model="form.company" name="company"></label><label>Email<input v-model="form.email" name="email" type="email"></label><label>電話<input v-model="form.phone" name="phone"></label><label>來源<select v-model="form.source" name="source"><option v-for="option in sourceOptions" :value="option.value" :key="option.value">{{ option.label }}</option></select></label><label>狀態<select v-model="form.status" name="status"><option v-for="option in statusOptions" :value="option.value" :key="option.value">{{ option.label }}</option></select></label></div>
            <div class="form-section form-section-notes"><span class="section-number">02</span><div><h2>備註</h2><p>留下下一步需要知道的事。</p></div></div><label class="wide-label"><textarea v-model="form.notes" name="notes" rows="5" placeholder="例如：預計下週回電，對方案 B 有興趣"></textarea></label>
            <div class="form-actions"><a class="button button-ghost" href="/customers">取消</a><button class="button button-primary" type="submit">{{ customer.id ? '更新資料' : '儲存客戶' }} <span>→</span></button></div>
        </form>
    </section>

    <section v-else class="page-shell detail-shell">
        <div class="page-heading reveal"><div><p class="eyebrow">Customers / Profile</p><h1>{{ customer.name }}</h1><p class="lede">{{ customer.company || '尚未填寫公司' }}</p></div><div class="heading-actions"><a class="button button-ink" :href="`/customers/${customer.id}/edit`">編輯資料</a><a class="text-link" href="/customers">← 返回列表</a></div></div>
        <div class="detail-grid reveal reveal-delay-1"><div class="detail-hero"><span :class="statusClass(customer.status)">{{ statusLabel(customer.status) }}</span><div class="monogram">{{ customer.name?.slice(0, 1) }}</div><h2>{{ customer.name }}</h2><p>{{ customer.company || '個人客戶' }}</p></div><div class="detail-info"><div><span>Email</span><a :href="`mailto:${customer.email}`">{{ customer.email || '—' }}</a></div><div><span>電話</span><p>{{ customer.phone || '—' }}</p></div><div><span>來源</span><p>{{ customer.source || '—' }}</p></div><div><span>建立時間</span><p>{{ customer.created_at?.slice(0, 10) || '—' }}</p></div><div class="detail-notes"><span>備註</span><p>{{ customer.notes || '尚無備註。' }}</p></div></div></div>
    </section>
</template>
