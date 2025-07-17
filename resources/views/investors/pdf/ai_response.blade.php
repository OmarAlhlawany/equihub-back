<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير مطابقات الاستثمار - Angeleast</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #2B37A0;
            font-size: 24px;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            display: inline-block;
            width: 100%;
        }

        .investor-details,
        .matches-summary {
            display: flex;
            justify-content: space-between;
        }

        .detail-item,
        .summary-item {
            flex: 1;
            margin: 0 10px;
            text-align: right;
        }

        .detail-label,
        .summary-label {
            color: #7F8C8D;
            font-size: 12px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .detail-value,
        .summary-value {
            color: #2C3E50;
            font-size: 15px;
            font-weight: 500;
        }

        .startup-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .startup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2B37A0;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .match-percentage {
            background-color: #4CAF50;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }

        th {
            background-color: #2B37A0;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .confidential-note {
            background-color: #FFE8E8;
            color: #DC3545;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            margin-top: 20px;
            border-radius: 8px;
        }

        .footer {
            text-align: center;
            color: #7F8C8D;
            font-size: 12px;
            margin-top: 20px;
            border-top: 1px solid #E9ECEF;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <h1>تقرير مطابقات الاستثمار</h1>

    <div class="card">
        <h2>معلومات المستثمر</h2>
        <div class="investor-details">
            <div class="detail-item">
                <div class="detail-label">الاسم</div>
                <div class="detail-value">{{ $investor->name }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">الشركة</div>
                <div class="detail-value">{{ $investor->company }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">نوع الاستثمار</div>
                <div class="detail-value">{{ optional($investor->investmentType)->name }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>ملخص المطابقات</h2>
        <div class="matches-summary">
            <div class="summary-item">
                <div class="summary-label">عدد المطابقات</div>
                <div class="summary-value">{{ $startups->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">أفضل مطابقة</div>
                <div class="summary-value">{{ round($startups->max('matching_percentage')) }}%</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">متوسط المطابقة</div>
                <div class="summary-value">{{ round($startups->avg('matching_percentage')) }}%</div>
            </div>
        </div>
    </div>

    <h2>تفاصيل المطابقات</h2>
    @foreach($startups as $startup)
        <div class="startup-card">
            <div class="startup-header">
                <h3>{{ $startup->name }}</h3>
                <div class="match-percentage">{{ round($startup->matching_percentage) }}% مطابقة</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>القطاع</th>
                        <th>المرحلة التشغيلية</th>
                        <th>مبلغ التمويل</th>
                        <th>السوق المستهدف</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $startup->sector_name }}</td>
                        <td>{{ $startup->phase_name }}</td>
                        <td>{{ $startup->funding_name }}</td>
                        <td>{{ $startup->market_name }}</td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>نمو الإيرادات</th>
                        <th>الربحية</th>
                        <th>حالة الديون</th>
                        <th>الاستثمار المشترك</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ number_format($startup->revenue_growth, 2) }}%</td>
                        <td>{{ $startup->is_profitable ? 'مربح' : 'غير مربح' }}</td>
                        <td>{{ $startup->have_debts ? 'لديه ديون' : 'بدون ديون' }}</td>
                        <td>{{ $startup->joint_investment == 1 ? 'مفتوح' : 'مغلق' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="confidential-note">
        وثيقة سرية - للاستخدام الداخلي فقط
    </div>

    <div class="footer">
        © {{ date('Y') }} نظام التوافق الذكي من Angeleast | تم الإنشاء في {{ date('Y-m-d H:i:s') }}
    </div>
</body>

</html>